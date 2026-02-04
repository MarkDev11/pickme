<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\GrowthRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Services\WHOZScore;
use App\Models\ActivityLog;

class GrowthRecordController extends Controller
{
    /**
     * Show form to create growth record
     */
    public function create($childId)
    {
        try {
            $child = Child::where('user_id', auth()->id())->findOrFail($childId);
            return view('growth.create', compact('child'));
        } catch (\Exception $e) {
            return redirect()
                ->route('children.index')
                ->with('error', 'Data anak tidak ditemukan.');
        }
    }

    /**
     * Store growth record with AI analysis (OPTIMIZED)
     */
    public function store(Request $request, $childId)
    {
        $child = Child::where('user_id', auth()->id())->findOrFail($childId);

        $validated = $request->validate([
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:5120',
            'record_date' => 'required|date|before_or_equal:today',
            'head_circumference' => 'nullable|numeric|min:20|max:70',
            'parent_notes' => 'nullable|string|max:1000',
        ], [
            'photo.required' => 'Foto anak harus diupload',
            'photo.image' => 'File harus berupa gambar',
            'photo.mimes' => 'Format foto harus JPG, JPEG, atau PNG',
            'photo.max' => 'Ukuran foto maksimal 5MB',
            'record_date.required' => 'Tanggal pemeriksaan harus diisi',
            'record_date.before_or_equal' => 'Tanggal pemeriksaan tidak boleh di masa depan',
        ]);

        DB::beginTransaction();
        
        try {
            // 1. Compress & Upload photo
            $photoPath = $this->handlePhotoUpload($request->file('photo'));
            
            if (!$photoPath) {
                throw new \Exception('Gagal mengupload foto');
            }

            // 2. Calculate age in months
            $recordDate = Carbon::parse($request->record_date);
            $ageMonths = $child->birth_date->diffInMonths($recordDate);

            // 3. AI Analysis (SINGLE OPTIMIZED CALL)
            $aiResults = $this->analyzeWithGemini($photoPath, $child, $ageMonths);

            if (!$aiResults['success']) {
                // Delete uploaded file if AI fails
                if (file_exists(public_path($photoPath))) {
                    @unlink(public_path($photoPath));
                }
                
                DB::rollBack();
                
                return back()
                    ->withInput()
                    ->with('error', $aiResults['message']);
            }

            // 4. Create growth record
            $record = GrowthRecord::create([
                'child_id' => $child->id,
                'user_id' => auth()->id(),
                'record_date' => $recordDate,
                'age_months' => $ageMonths,
                'ai_estimated_weight' => $aiResults['data']['weight'],
                'ai_estimated_height' => $aiResults['data']['height'],
                'actual_weight' => $aiResults['data']['weight'],
                'actual_height' => $aiResults['data']['height'],
                'head_circumference' => $request->head_circumference,
                'photo_path' => $photoPath,
                'ai_analysis' => $aiResults['data']['analysis'],
                'growth_status' => $aiResults['data']['status'],
                'recommendations' => $aiResults['data']['recommendations'],
                'nutrition_advice' => $aiResults['data']['nutrition'] ?? [],
                'milestone_check' => $aiResults['data']['milestones'] ?? [],
                
                'parent_notes' => $request->parent_notes,
            ]);

            DB::commit();

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'create',
                'description' => "Mencatat pertumbuhan: {$child->name} (Bulan ke-{$ageMonths})",
                'subject_type' => GrowthRecord::class,
                'subject_id' => $record->id,
                'properties' => json_encode(['weight' => $record->actual_weight, 'height' => $record->actual_height]),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            $this->updateAiSummary($child->id);

            // Redirect to edit page for parent confirmation
            return redirect()
                ->route('growth.edit', $record->id)
                ->with('success', '✅ Analisis AI selesai! Silakan periksa dan konfirmasi data.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Clean up uploaded photo
            if (isset($photoPath) && file_exists(public_path($photoPath))) {
                @unlink(public_path($photoPath));
            }
            
            Log::error('Growth record creation failed: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'child_id' => $childId,
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    /**
     * Show form to edit/confirm growth record
     */
    public function edit($id)
    {
        try {
            $record = GrowthRecord::with('child')
                                 ->where('user_id', auth()->id())
                                 ->findOrFail($id);
            
            return view('growth.edit', compact('record'));
        } catch (\Exception $e) {
            return redirect()
                ->route('children.index')
                ->with('error', 'Data pertumbuhan tidak ditemukan.');
        }
    }

    /**
     * Update growth record (parent confirmation/edit)
     */
    public function update(Request $request, $id)
    {
        $record = GrowthRecord::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'actual_weight' => 'required|numeric|min:2|max:50',
            'actual_height' => 'required|numeric|min:40|max:200',
            'head_circumference' => 'nullable|numeric|min:20|max:70',
            'parent_notes' => 'nullable|string|max:1000',
        ], [
            'actual_weight.required' => 'Berat badan harus diisi',
            'actual_weight.min' => 'Berat badan minimal 2 kg',
            'actual_weight.max' => 'Berat badan maksimal 50 kg',
            'actual_height.required' => 'Tinggi badan harus diisi',
            'actual_height.min' => 'Tinggi badan minimal 40 cm',
            'actual_height.max' => 'Tinggi badan maksimal 200 cm',
        ]);

        DB::beginTransaction();

        try {
            // Calculate Z-scores using WHO standards
           $zScores = $this->calculateZScores($record->child, $validated, $record->age_months);
            
            $validated['weight_for_age_zscore'] = $zScores['wfa'];
            $validated['height_for_age_zscore'] = $zScores['hfa'];
            $validated['weight_for_height_zscore'] = $zScores['wfh'];
            
            $validated['growth_status'] = $this->determineGrowthStatus($zScores, $record->child->gender);

            $record->update($validated);

            DB::commit();

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'update',
                'description' => "Memperbarui catatan pertumbuhan: {$record->child->name}",
                'subject_type' => GrowthRecord::class,
                'subject_id' => $record->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
            
            $this->updateAiSummary($record->child_id);
            return redirect()
                ->route('growth.show', $record->id)
                ->with('success', '✅ Data pertumbuhan berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Growth record update failed: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    /**
     * Display growth record details
     */
    public function show($id)
    {
        try {
            $record = GrowthRecord::with(['child', 'child.growthRecords'])
                                 ->where('user_id', auth()->id())
                                 ->findOrFail($id);
            
            // Get previous record for comparison
            $previousRecord = GrowthRecord::where('child_id', $record->child_id)
                                         ->where('record_date', '<', $record->record_date)
                                         ->orderBy('record_date', 'desc')
                                         ->first();
            
            return view('growth.show', compact('record', 'previousRecord'));
        } catch (\Exception $e) {
            return redirect()
                ->route('children.index')
                ->with('error', 'Data pertumbuhan tidak ditemukan.');
        }
    }

    /**
     * Delete growth record
     */
    public function destroy($id)
    {
        try {
            $record = GrowthRecord::where('user_id', auth()->id())->findOrFail($id);
            
            DB::beginTransaction();

            $childId = $record->child_id;
            
            // Photo deletion handled by model event
            $record->delete();
            
            DB::commit();

            return redirect()
                ->route('children.show', $childId)
                ->with('success', 'Data pertumbuhan berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->route('children.index')
                ->with('error', 'Gagal menghapus data pertumbuhan.');
        }
    }

    /**
     * Handle photo upload with compression (OPTIMIZED)
     */
    private function handlePhotoUpload($file)
    {
        try {
            // 1. Validasi tipe MIME secara manual untuk keamanan tambahan
            $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!in_array($file->getMimeType(), $allowedMimes)) {
                Log::warning('File upload ditolak: Tipe MIME tidak valid.', ['mime' => $file->getMimeType()]);
                return null;
            }

            // 2. Tentukan path penyimpanan
            $uploadPath = public_path('uploads/growth');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // 3. Buat nama file unik (selalu simpan sebagai .jpg untuk konsistensi)
            $filename = 'growth_' 
                      . auth()->id() . '_' 
                      . time() . '_' 
                      . uniqid() . '.jpg';

            $filepath = $uploadPath . '/' . $filename;

            // 4. Proses Gambar dengan Intervention Image v3
            // Inisialisasi Manager dengan Driver GD (bawaan PHP)
            $manager = new ImageManager(new Driver());
            
            // Membaca file gambar yang diupload
            $img = $manager->read($file);
            
            // 5. Optimasi Ukuran (Resize jika terlalu besar)
            // Ini penting untuk menjaga payload API Gemini tetap ringan
            if ($img->width() > 1024 || $img->height() > 1024) {
                $img->scale(width: 1024, height: 1024); // Menjaga aspect ratio secara otomatis
            }
            
            // 6. Encode ke format JPG dengan kualitas 85% dan simpan
            $encoded = $img->toJpeg(85);
            $encoded->save($filepath);

            return 'uploads/growth/' . $filename;

        } catch (\Exception $e) {
            Log::error('Photo upload failed: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Analyze with Gemini AI (OPTIMIZED FOR EFFICIENCY)
     */
    private function analyzeWithGemini($photoPath, $child, $ageMonths)
    {
        try {
            $absolutePath = public_path($photoPath);
            
            // Cek file ada atau tidak
            if (!file_exists($absolutePath)) {
                throw new \Exception('File foto tidak ditemukan di server.');
            }

            $imageData = base64_encode(file_get_contents($absolutePath));
            $mimeType = 'image/jpeg';

            // PROMPT YANG DIPERBAIKI (Lebih tegas format JSON)
            $prompt = "Anda adalah asisten medis anak profesional. Tugas: Estimasi metrik pertumbuhan berdasarkan foto.
            
Data Anak:
- Gender: " . ($child->gender === 'male' ? 'Laki-laki' : 'Perempuan') . "
- Usia: {$ageMonths} bulan
- Lahir: BB {$child->birth_weight}kg, TB {$child->birth_height}cm

PENTING:
1. Analisis visual proporsi tubuh anak.
2. Output HARUS HANYA JSON valid. Jangan ada teks lain sebelum atau sesudah JSON.
3. Jangan gunakan markdown (```json).

Format JSON:
{
  \"weight\": (number, estimasi dalam kg, contoh: 12.5),
  \"height\": (number, estimasi dalam cm, contoh: 85.0),
  \"status\": \"(string, contoh: 'Tampak Sehat', 'Kurang Gizi', 'Gemuk')\",
  \"analysis\": \"(string, max 20 kata, fokus visual)\",
  \"recommendations\": \"(string, saran umum)\",
  \"nutrition\": [\"(string)\", \"(string)\"],
  \"milestones\": [\"(string)\"]
}";

            $apiKey = env('GEMINI_API_KEY');
            
            // Gunakan model yang lebih stabil untuk visi, flash-exp sering update dan tidak stabil
            // Disarankan pakai gemini-1.5-flash jika tersedia, atau tetap gemini-2.0-flash-exp
            $modelName = env('GEMINI_MODEL', 'gemini-2.5-flash-lite-preview-09-2025'); 

            $response = Http::timeout(60)
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
                        'maxOutputTokens' => 1000,
                    ]
                ]);

            // 1. Cek Koneksi HTTP
            if (!$response->successful()) {
                Log::error('Gemini API HTTP Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return ['success' => false, 'message' => 'Gagal terhubung ke server AI.'];
            }

            $result = $response->json();
            
            // 2. Ambil Raw Text
            $rawText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';
            
            // LOG RAW TEXT (Sangat penting untuk debugging)
            // Cek file storage/logs/laravel.log untuk melihat apa jawaban asli AI
            Log::info('Gemini Raw Response:', ['text' => $rawText]);

            // 3. REFUSAL CHECK (Cek jika AI menolak)
            if (empty($rawText) || stripos($rawText, "cannot") !== false || stripos($rawText, "unable") !== false) {
                 return [
                    'success' => false,
                    'message' => 'AI menolak menganalisis karena kebijakan privasi/keamanan. Coba foto yang tidak menampakkan wajah secara jelas atau foto pakaian.'
                ];
            }

            // 4. PARSING JSON YANG LEBIH KUAT (Regex)
            // Cari string yang diawali '{' dan diakhiri '}'
            if (preg_match('/\{[\s\S]*\}/', $rawText, $matches)) {
                $jsonString = $matches[0];
            } else {
                $jsonString = $rawText; // Coba parse langsung jika regex gagal
            }

            $data = json_decode($jsonString, true);

            // 5. Validasi Hasil Decode
            if (json_last_error() !== JSON_ERROR_NONE || !isset($data['weight'])) {
                Log::error('JSON Decode Failed', ['error' => json_last_error_msg(), 'string' => $jsonString]);
                return [
                    'success' => false,
                    'message' => 'Format data AI rusak. Silakan coba lagi.'
                ];
            }

            // Sanitize data
            $data['weight'] = (float) $data['weight'];
            $data['height'] = (float) $data['height'];

            // Fallback values jika kosong
            $data['status'] = $data['status'] ?? 'Perlu Evaluasi';
            $data['analysis'] = $data['analysis'] ?? 'Analisis visual selesai.';
            $data['recommendations'] = $data['recommendations'] ?? 'Lakukan pengukuran manual untuk akurasi.';
            $data['nutrition'] = $data['nutrition'] ?? [];
            $data['milestones'] = $data['milestones'] ?? [];

            return [
                'success' => true,
                'data' => $data
            ];

        } catch (\Exception $e) {
            Log::error('Gemini Critical Error', ['msg' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat analisis.'
            ];
        }
    }

    /**
     * Calculate Z-scores using WHO Child Growth Standards
     * (Simplified version - in production use full WHO tables)
     */
    private function calculateZScores($child, $data, $ageMonths)
    {
        $gender = $child->gender;
        $weight = (float) $data['actual_weight'];
        $height = (float) $data['actual_height'];

        // Menggunakan Service WHOZScore yang baru
        return [
            'wfa' => WHOZScore::calculateWeightForAge($gender, $ageMonths, $weight),
            'hfa' => WHOZScore::calculateHeightForAge($gender, $ageMonths, $height),
            'wfh' => WHOZScore::calculateWeightForHeight($gender, $height, $weight),
        ];
    }

    /**
     * Determine growth status based on Z-scores (WHO Standards)
     */
    private function determineGrowthStatus($zScores, $gender)
    {
        $wfa = $zScores['wfa'];
        $hfa = $zScores['hfa'];
        $wfh = $zScores['wfh'];

        // WHO Classification
        if ($hfa < -3) {
            return 'Stunting Parah - Perlu Penanganan Segera';
        }
        
        if ($hfa < -2) {
            return 'Stunting - Perlu Perhatian Khusus';
        }
        
        if ($wfa < -3) {
            return 'Gizi Buruk - Konsultasi Dokter Segera';
        }
        
        if ($wfa < -2) {
            return 'Gizi Kurang - Perlu Perbaikan Nutrisi';
        }
        
        if ($wfh > 3) {
            return 'Obesitas - Perlu Pengaturan Pola Makan';
        }
        
        if ($wfh > 2) {
            return 'Gizi Lebih - Pantau Asupan Kalori';
        }
        
        if ($wfa < -1 || $hfa < -1) {
            return 'Berisiko - Perlu Pemantauan Rutin';
        }
        
        return 'Pertumbuhan Normal - Teruskan Pola Asuh';
    }
    private function updateAiSummary($childId)
    {
        try {
            $child = Child::with(['growthRecords' => function($query) {
                $query->orderBy('age_months', 'asc');
            }])->find($childId);

            if (!$child || $child->growthRecords->isEmpty()) return;

            // 1. Susun Riwayat
            $historyText = "";
            foreach ($child->growthRecords as $rec) {
                $historyText .= "- Umur {$rec->age_months} bln: BB {$rec->actual_weight}kg, TB {$rec->actual_height}cm. Status: {$rec->growth_status}.\n";
            }

            // 2. Prompt (Lebih ringkas agar cepat)
            $prompt = "Sebagai Dokter Anak, buat ringkasan tren pertumbuhan anak ini dalam JSON.
            Nama: {$child->name}, Gender: {$child->gender}.
            Riwayat:
            {$historyText}
            
            Output JSON only:
            {
                \"summary\": \"(Kesimpulan naratif tren naik/turun/stabil max 25 kata)\",
                \"actions\": [\"(Saran aksi 1)\", \"(Saran aksi 2)\", \"(Saran aksi 3)\"]
            }";

            // 3. Request ke Gemini (Pakai model Flash agar cepat)
            $apiKey = env('GEMINI_API_KEY');
            $model = "gemini-2.5-flash-lite-preview-09-2025"; // Gunakan model cepat
            
            $response = Http::timeout(10)->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
                'contents' => [['parts' => [['text' => $prompt]]]]
            ]);

            if ($response->successful()) {
                $rawText = $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? '';
                $cleanJson = str_replace(['```json', '```'], '', $rawText);
                $data = json_decode($cleanJson, true);

                if ($data) {
                    $child->update([
                        'ai_summary' => $data['summary'] ?? null,
                        'ai_recommendations' => json_encode($data['actions'] ?? []),
                        'summary_last_updated' => now()
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Silent fail: Jika summary gagal update, biarkan saja agar tidak mengganggu user menyimpan data
            Log::error('Auto Summary Failed: ' . $e->getMessage());
        }
    }
}