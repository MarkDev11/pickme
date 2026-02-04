<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\BodyAnalysis;
use Illuminate\Support\Facades\Storage;
use App\Models\ActivityLog;

class BodyAnalysisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get only current user's analyses if not admin
        if (auth()->user()->isAdmin()) {
            $history = BodyAnalysis::with('user')->latest()->get();
        } else {
            $history = BodyAnalysis::where('user_id', auth()->id())->latest()->get();
        }
        
        // Calculate statistics
        $totalAnalyses = $history->count();
        $avgHeight = $history->avg('estimated_height') ?? 0;
        $avgWeight = $history->avg('estimated_weight') ?? 0;
        $avgAge = $history->avg('estimated_age') ?? 0;
        
        return view('analysis.dashboard', compact(
            'history', 
            'totalAnalyses', 
            'avgHeight', 
            'avgWeight', 
            'avgAge'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('analysis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:5120', // Max 5MB
        ]);

        try {
            // 1. Upload file to public folder
            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $dbPath = 'uploads/' . $filename;

            // 2. Prepare data for API
            $absolutePath = public_path($dbPath);
            $imageData = base64_encode(file_get_contents($absolutePath));
            $mimeType = mime_content_type($absolutePath);

            // 3. AI Prompt
            $prompt = "Analyze this person's photo. Estimate: 1. Height (cm), 2. Weight (kg), 3. Age (years). 
                       Output MUST be pure JSON format: 
                       {\"height\": 170, \"weight\": 65, \"age\": 25, \"description\": \"brief reasoning\"}. 
                       Make logical estimations based on body proportions and appearance.";

            $apiKey = env('GEMINI_API_KEY');
            $modelName = 'gemini-2.5-flash-lite-preview-09-2025';

            // 4. Call Gemini API
            $response = Http::timeout(30)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post("https://generativelanguage.googleapis.com/v1beta/models/{$modelName}:generateContent?key={$apiKey}", [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt],
                                [
                                    'inline_data' => [
                                        'mime_type' => $mimeType,
                                        'data' => $imageData
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.4,
                        'topK' => 32,
                        'topP' => 1,
                        'maxOutputTokens' => 1024,
                    ]
                ]);

            $result = $response->json();

            // 5. Error handling
            if (isset($result['error'])) {
                // Delete uploaded file if API fails
                if (file_exists($absolutePath)) {
                    unlink($absolutePath);
                }
                
                return back()
                    ->with('error', 'AI Analysis Error: ' . ($result['error']['message'] ?? 'Unknown error'))
                    ->withInput();
            }

            // 6. Parse AI response
            $rawText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '{}';
            $cleanJson = preg_replace('/```json|```/', '', $rawText);
            $cleanJson = trim($cleanJson);
            $data = json_decode($cleanJson, true);

            // Validate parsed data
            if (!$data || !isset($data['height']) || !isset($data['weight']) || !isset($data['age'])) {
                if (file_exists($absolutePath)) {
                    unlink($absolutePath);
                }
                return back()->with('error', 'Failed to parse AI response. Please try again.')->withInput();
            }

            // 7. Save to database
            $analysis = BodyAnalysis::create([
                'user_id' => auth()->id(),
                'image_path' => $dbPath,
                'estimated_height' => (int) $data['height'],
                'estimated_weight' => (int) $data['weight'],
                'estimated_age' => (int) $data['age'],
                'full_analysis' => $data['description'] ?? 'No description provided',
            ]);

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'ai_analysis',
                'description' => "Melakukan analisis AI (Body Analysis)",
                'subject_type' => BodyAnalysis::class,
                'subject_id' => $analysis->id,
                'properties' => json_encode([
                    'height' => $analysis->estimated_height,
                    'weight' => $analysis->estimated_weight
                ]),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            return redirect()
                ->route('analysis.show', $analysis->id)
                ->with('success', 'Analysis completed successfully!');

        } catch (\Exception $e) {
            // Clean up uploaded file on error
            if (isset($absolutePath) && file_exists($absolutePath)) {
                unlink($absolutePath);
            }
            
            return back()
                ->with('error', 'An error occurred: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $analysis = BodyAnalysis::findOrFail($id);
        return view('analysis.show', compact('analysis'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Optional: implement if you want to edit analysis
        $analysis = BodyAnalysis::findOrFail($id);
        return view('analysis.edit', compact('analysis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Optional: implement if you want to manually edit measurements
        $analysis = BodyAnalysis::findOrFail($id);
        
        $request->validate([
            'estimated_height' => 'required|numeric|min:50|max:300',
            'estimated_weight' => 'required|numeric|min:20|max:300',
            'estimated_age' => 'required|numeric|min:1|max:120',
            'full_analysis' => 'nullable|string|max:1000',
        ]);

        $analysis->update($request->only([
            'estimated_height',
            'estimated_weight',
            'estimated_age',
            'full_analysis'
        ]));

        ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'update',
                'description' => "Mengedit hasil analisis AI",
                'subject_type' => BodyAnalysis::class,
                'subject_id' => $analysis->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

        return redirect()
            ->route('analysis.show', $analysis->id)
            ->with('success', 'Analysis updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $analysis = BodyAnalysis::findOrFail($id);
        
        // Delete image file
        $imagePath = public_path($analysis->image_path);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        
        // Delete database record
        $analysis->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'delete',
            'description' => "Menghapus riwayat analisis AI",
            'subject_type' => BodyAnalysis::class,
            'subject_id' => $id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
        
        return redirect()
            ->route('analysis.index')
            ->with('success', 'Analysis deleted successfully!');
    }

    /**
     * Export analysis data
     */
    public function export()
    {
        // Optional: implement CSV/PDF export
        $analyses = BodyAnalysis::all();
        
        $filename = 'body-analyses-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($analyses) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Date', 'Height (cm)', 'Weight (kg)', 'Age', 'BMI', 'Description']);

            foreach ($analyses as $analysis) {
                $heightM = $analysis->estimated_height / 100;
                $bmi = $heightM > 0 ? round($analysis->estimated_weight / ($heightM * $heightM), 1) : 0;
                
                fputcsv($file, [
                    $analysis->id,
                    $analysis->created_at->format('Y-m-d H:i:s'),
                    $analysis->estimated_height,
                    $analysis->estimated_weight,
                    $analysis->estimated_age,
                    $bmi,
                    $analysis->full_analysis,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}