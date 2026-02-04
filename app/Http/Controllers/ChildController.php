<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\GrowthRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChildController extends Controller
{
    /**
     * Display a listing of user's children
     */
    public function index()
    {
        try {
            $children = Child::where('user_id', auth()->id())
                            ->withCount('growthRecords')
                            ->with('latestGrowth')
                            ->orderBy('created_at', 'desc')
                            ->get();
            
            return view('children.index', compact('children'));
        } catch (\Exception $e) {
            Log::error('Error loading children index: ' . $e->getMessage());
            return view('children.index', ['children' => collect()]);
        }
    }

    /**
     * Show the form for creating a new child
     */
    public function create()
    {
        return view('children.create');
    }

    /**
     * Store a newly created child
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'gender' => 'required|in:male,female',
                'birth_date' => [
                    'required',
                    'date',
                    'before:today',
                    'after:' . now()->subYears(18)->format('Y-m-d')
                ],
                'birth_place' => 'required|string|max:255',
                'birth_weight' => 'required|numeric|min:0.5|max:10',
                'birth_height' => 'required|numeric|min:20|max:80',
                'birth_type' => 'required|in:normal,cesarean',
                'blood_type' => 'nullable|in:A,B,AB,O,A+,A-,B+,B-,AB+,AB-,O+,O-',
                'health_notes' => 'nullable|string|max:1000',
                'allergy_notes' => 'nullable|string|max:1000',
                'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:5120', // 5MB max
            ], [
                'name.required' => 'Nama anak harus diisi',
                'gender.required' => 'Jenis kelamin harus dipilih',
                'birth_date.required' => 'Tanggal lahir harus diisi',
                'birth_date.before' => 'Tanggal lahir tidak valid',
                'birth_date.after' => 'Tanggal lahir tidak boleh lebih dari 18 tahun yang lalu',
                'birth_place.required' => 'Tempat lahir harus diisi',
                'birth_weight.required' => 'Berat lahir harus diisi',
                'birth_weight.min' => 'Berat lahir minimal 0.5 kg',
                'birth_weight.max' => 'Berat lahir maksimal 10 kg',
                'birth_height.required' => 'Tinggi lahir harus diisi',
                'birth_height.min' => 'Tinggi lahir minimal 20 cm',
                'birth_height.max' => 'Tinggi lahir maksimal 80 cm',
                'birth_type.required' => 'Jenis kelahiran harus dipilih',
                'photo.image' => 'File harus berupa gambar',
                'photo.mimes' => 'Foto harus berformat JPEG, JPG, atau PNG',
                'photo.max' => 'Ukuran foto maksimal 5MB',
            ]);

            DB::beginTransaction();

            $validated['user_id'] = auth()->id();

            // Handle photo upload dengan security yang lebih baik
            if ($request->hasFile('photo')) {
                $photoPath = $this->handlePhotoUpload($request->file('photo'));
                if ($photoPath) {
                    $validated['photo'] = $photoPath;
                }
            }

            $child = Child::create($validated);

            DB::commit();

            return redirect()
                ->route('children.show', $child->id)
                ->with('success', 'Data anak berhasil ditambahkan! 🎉');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating child: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified child
     */
    public function show($id)
    {
        try {
            $child = Child::where('user_id', auth()->id())
                         ->with(['growthRecords' => function($query) {
                             $query->orderBy('record_date', 'desc');
                         }])
                         ->findOrFail($id);
            
            // Growth chart data
            $chartData = $this->prepareChartData($child);
            $kmsData = collect([
                ['x' => 0, 'y' => (float)$child->birth_weight]
            ]);
            foreach($child->growthRecords->sortBy('age_months') as $record) {
                $kmsData->push([
                    'x' => $record->age_months,
                    'y' => (float)$record->actual_weight
                ]);
            }
            
            return view('children.show', compact('child', 'chartData','kmsData'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->route('children.index')
                ->with('error', 'Data anak tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Error showing child: ' . $e->getMessage());
            return redirect()
                ->route('children.index')
                ->with('error', 'Terjadi kesalahan saat menampilkan data.');
        }
    }

    /**
     * Show the form for editing the child
     */
    public function edit($id)
    {
        try {
            $child = Child::where('user_id', auth()->id())->findOrFail($id);
            return view('children.edit', compact('child'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->route('children.index')
                ->with('error', 'Data anak tidak ditemukan.');
        }
    }

    /**
     * Update the specified child
     */
    public function update(Request $request, $id)
    {
        try {
            $child = Child::where('user_id', auth()->id())->findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'gender' => 'required|in:male,female',
                'birth_date' => [
                    'required',
                    'date',
                    'before:today',
                    'after:' . now()->subYears(18)->format('Y-m-d')
                ],
                'birth_place' => 'required|string|max:255',
                'birth_weight' => 'required|numeric|min:0.5|max:10',
                'birth_height' => 'required|numeric|min:20|max:80',
                'birth_type' => 'required|in:normal,cesarean',
                'blood_type' => 'nullable|in:A,B,AB,O,A+,A-,B+,B-,AB+,AB-,O+,O-',
                'health_notes' => 'nullable|string|max:1000',
                'allergy_notes' => 'nullable|string|max:1000',
                'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            ], [
                'name.required' => 'Nama anak harus diisi',
                'gender.required' => 'Jenis kelamin harus dipilih',
                'birth_date.required' => 'Tanggal lahir harus diisi',
                'birth_date.before' => 'Tanggal lahir tidak valid',
                'birth_date.after' => 'Tanggal lahir tidak boleh lebih dari 18 tahun yang lalu',
                'photo.image' => 'File harus berupa gambar',
                'photo.mimes' => 'Foto harus berformat JPEG, JPG, atau PNG',
                'photo.max' => 'Ukuran foto maksimal 5MB',
            ]);

            DB::beginTransaction();

            // Handle photo upload
            if ($request->hasFile('photo')) {
                // Delete old photo
                if ($child->photo && file_exists(public_path($child->photo))) {
                    @unlink(public_path($child->photo));
                }

                $photoPath = $this->handlePhotoUpload($request->file('photo'));
                if ($photoPath) {
                    $validated['photo'] = $photoPath;
                }
            }

            $child->update($validated);

            DB::commit();

            return redirect()
                ->route('children.show', $child->id)
                ->with('success', 'Data anak berhasil diperbarui! ✅');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()
                ->route('children.index')
                ->with('error', 'Data anak tidak ditemukan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating child: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified child
     */
    public function destroy($id)
    {
        try {
            $child = Child::where('user_id', auth()->id())->findOrFail($id);
            
            DB::beginTransaction();

            $childName = $child->name;
            
            // Photo deletion is handled by model's boot method
            $child->delete();
            
            DB::commit();

            return redirect()
                ->route('children.index')
                ->with('success', "Data {$childName} berhasil dihapus.");

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()
                ->route('children.index')
                ->with('error', 'Data anak tidak ditemukan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting child: ' . $e->getMessage());
            return redirect()
                ->route('children.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    /**
     * Handle photo upload with enhanced security
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @return string|null
     */
    private function handlePhotoUpload($file)
    {
        try {
            // Validasi tambahan untuk MIME type
            $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!in_array($file->getMimeType(), $allowedMimes)) {
                Log::warning('Invalid MIME type: ' . $file->getMimeType());
                return null;
            }

            // Pastikan folder uploads/children ada
            $uploadPath = public_path('uploads/children');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Generate nama file yang aman dan unik
            $filename = 'child_' 
                      . auth()->id() . '_' 
                      . time() . '_' 
                      . uniqid() . '.' 
                      . $file->getClientOriginalExtension();

            // Sanitize filename
            $filename = preg_replace('/[^a-zA-Z0-9._-]/', '', $filename);

            // Move file
            $file->move($uploadPath, $filename);

            return 'uploads/children/' . $filename;

        } catch (\Exception $e) {
            Log::error('Error uploading photo: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Prepare chart data for growth visualization
     * 
     * @param Child $child
     * @return array
     */
    private function prepareChartData($child)
    {
        try {
            // 1. Buat Array Penampung & Masukkan DATA LAHIR sebagai Titik Pertama
            $chartPoints = [];
            
            // Masukkan Data Lahir (Wajib agar grafik punya titik awal)
            $chartPoints[] = [
                'timestamp' => \Carbon\Carbon::parse($child->birth_date)->timestamp,
                'date_str' => \Carbon\Carbon::parse($child->birth_date)->format('d M Y'),
                'weight' => (float) $child->birth_weight,
                'height' => (float) $child->birth_height,
            ];

            // 2. Ambil Data Record (yang bukan 0)
            $records = $child->growthRecords()
                             ->where('actual_weight', '>', 0)
                             ->orderBy('record_date', 'asc')
                             ->get();
            
            foreach ($records as $record) {
                // Cek agar tidak duplikat dengan data lahir (jika tgl sama)
                $recDate = \Carbon\Carbon::parse($record->record_date);
                if ($recDate->format('Y-m-d') !== $child->birth_date->format('Y-m-d')) {
                    $chartPoints[] = [
                        'timestamp' => $recDate->timestamp,
                        'date_str' => $recDate->format('d M Y'),
                        'weight' => (float) $record->actual_weight,
                        'height' => (float) $record->actual_height,
                    ];
                }
            }

            // 3. Urutkan Data Berdasarkan Waktu (Lahir -> Kecil -> Besar)
            usort($chartPoints, function($a, $b) {
                return $a['timestamp'] <=> $b['timestamp'];
            });

            // 4. Hapus Duplikat Tanggal (Ambil yang paling update per tanggal)
            $uniquePoints = [];
            foreach ($chartPoints as $point) {
                $uniquePoints[$point['date_str']] = $point;
            }
            $finalData = array_values($uniquePoints);

            // 5. Kembalikan data bersih
            return [
                'labels' => array_column($finalData, 'date_str'),
                'weight' => array_column($finalData, 'weight'),
                'height' => array_column($finalData, 'height'),
            ];

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Chart Error: ' . $e->getMessage());
            return ['labels' => [], 'weight' => [], 'height' => []];
        }
    }
}