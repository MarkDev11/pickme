<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-teal-100 rounded-lg text-teal-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <h2 class="font-bold text-lg text-gray-800 leading-tight">
                Detail Analisis Pertumbuhan
            </h2>
        </div>
    </x-slot>

    <div class="">
        <!-- Flash Messages -->
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 shadow-md animate-fade-in" role="alert">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        <!-- Child & Record Info Header -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl shadow-xl p-8 mb-8 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full -mr-48 -mt-48"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full -ml-32 -mb-32"></div>
            
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-6">
                        <div class="w-20 h-20 bg-white rounded-2xl overflow-hidden shadow-xl">
                            @if($record->child->photo)
                                <img src="{{ asset($record->child->photo) }}" class="w-full h-full object-cover" alt="{{ $record->child->name }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-blue-100">
                                    <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold mb-1">{{ $record->child->name }}</h2>
                            <p class="text-blue-100">{{ $record->child->age_text }} • {{ $record->child->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                            <p class="text-sm text-blue-200 mt-1">Pemeriksaan: {{ $record->record_date->format('d F Y') }} ({{ $record->age_months }} bulan)</p>
                        </div>
                    </div>

                    <div class="flex space-x-2">
                        <a href="{{ route('growth.edit', $record->id) }}" 
                           class="px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg transition-colors">
                            ✏️ Edit Data
                        </a>
                        <a href="{{ route('children.show', $record->child_id) }}" 
                           class="px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg transition-colors">
                            ← Kembali
                        </a>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-white/20 backdrop-blur rounded-xl p-4">
                        <p class="text-xs text-blue-100 mb-1">Berat Badan</p>
                        <p class="text-2xl font-bold">{{ $record->actual_weight }} kg</p>
                        @if($record->weight_difference)
                            <p class="text-xs text-blue-200 mt-1">
                                {{ $record->weight_difference > 0 ? '↗' : '↘' }} 
                                {{ abs($record->weight_difference) }} kg
                            </p>
                        @endif
                    </div>
                    <div class="bg-white/20 backdrop-blur rounded-xl p-4">
                        <p class="text-xs text-blue-100 mb-1">Tinggi Badan</p>
                        <p class="text-2xl font-bold">{{ $record->actual_height }} cm</p>
                        @if($record->height_difference)
                            <p class="text-xs text-blue-200 mt-1">
                                {{ $record->height_difference > 0 ? '↗' : '↘' }} 
                                {{ abs($record->height_difference) }} cm
                            </p>
                        @endif
                    </div>
                    @if($record->head_circumference)
                    <div class="bg-white/20 backdrop-blur rounded-xl p-4">
                        <p class="text-xs text-blue-100 mb-1">Lingkar Kepala</p>
                        <p class="text-2xl font-bold">{{ $record->head_circumference }} cm</p>
                    </div>
                    @endif
                    <div class="bg-white/20 backdrop-blur rounded-xl p-4">
                        <p class="text-xs text-blue-100 mb-1">Status</p>
                        <p class="text-sm font-bold">{{ Str::limit($record->growth_status, 50) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Photo & AI Info -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Photo -->
                <div class="bg-white rounded-2xl shadow-xl border border-blue-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-50 to-white px-6 py-4 border-b border-blue-100">
                        <h4 class="font-bold text-gray-800">Foto Pemeriksaan</h4>
                    </div>
                    <div class="p-4">
                        <img src="{{ asset($record->photo_path) }}" class="w-full rounded-xl shadow-lg" alt="Foto Pertumbuhan">
                    </div>
                </div>

                <!-- AI Estimation vs Actual -->
                @if($record->wasEditedByParent())
                <div class="bg-gradient-to-br from-purple-50 to-white rounded-2xl shadow-lg border border-purple-200 p-6">
                    <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        Perbandingan Data
                    </h4>
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-600 mb-1">Estimasi AI:</p>
                            <p class="font-semibold text-purple-700">{{ $record->ai_estimated_weight }} kg • {{ $record->ai_estimated_height }} cm</p>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">Data Aktual:</p>
                            <p class="font-semibold text-green-700">{{ $record->actual_weight }} kg • {{ $record->actual_height }} cm</p>
                        </div>
                        <div class="pt-2 border-t border-purple-200">
                            <p class="text-xs text-purple-800">✓ Data telah dikoreksi oleh orang tua</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Previous Record Comparison -->
                @if($previousRecord)
                <div class="bg-gradient-to-br from-blue-50 to-white rounded-2xl shadow-lg border border-blue-200 p-6">
                    <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        Pertumbuhan
                    </h4>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Berat Badan:</span>
                            <span class="font-bold {{ $record->weight_difference > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $record->weight_difference > 0 ? '+' : '' }}{{ $record->weight_difference }} kg
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Tinggi Badan:</span>
                            <span class="font-bold {{ $record->height_difference > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $record->height_difference > 0 ? '+' : '' }}{{ $record->height_difference }} cm
                            </span>
                        </div>
                        <div class="pt-2 border-t border-blue-200">
                            <p class="text-xs text-gray-600">Dari pemeriksaan: {{ $previousRecord->record_date->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column: Analysis & Recommendations -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Growth Status -->
                <div class="bg-white rounded-2xl shadow-xl border-2 border-{{ $record->status_color }}-200 p-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-16 h-16 bg-{{ $record->status_color }}-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-10 h-10 text-{{ $record->status_color }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Status Pertumbuhan</h3>
                            <p class="text-lg font-semibold text-{{ $record->status_color }}-700 mb-3">{{ $record->growth_status }}</p>
                            
                            @if($record->ai_analysis)
                            <div class="bg-gray-50 rounded-xl p-4">
                                <p class="text-sm text-gray-700 leading-relaxed">{{ $record->ai_analysis }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Z-Scores (WHO Standards) -->
                @if($record->weight_for_age_zscore !== null || $record->height_for_age_zscore !== null)
                <div class="bg-white rounded-2xl shadow-xl border border-blue-100 p-6">
                    <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        Grafik Pertumbuhan (KMS)
                    </h4>
                    <div class="relative h-96 w-full">
                        <canvas id="growthChart"></canvas>
                    </div>
                    {{-- <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @if($record->weight_for_age_zscore !== null)
                        <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                            <p class="text-xs text-gray-600 mb-1">Weight-for-Age</p>
                            <p class="text-2xl font-bold text-blue-700">{{ number_format($record->weight_for_age_zscore, 2) }} SD</p>
                        </div>
                        @endif
                        
                        @if($record->height_for_age_zscore !== null)
                        <div class="bg-purple-50 rounded-xl p-4 border border-purple-200">
                            <p class="text-xs text-gray-600 mb-1">Height-for-Age</p>
                            <p class="text-2xl font-bold text-purple-700">{{ number_format($record->height_for_age_zscore, 2) }} SD</p>
                        </div>
                        @endif
                        
                        @if($record->weight_for_height_zscore !== null)
                        <div class="bg-green-50 rounded-xl p-4 border border-green-200">
                            <p class="text-xs text-gray-600 mb-1">Weight-for-Height</p>
                            <p class="text-2xl font-bold text-green-700">{{ number_format($record->weight_for_height_zscore, 2) }} SD</p>
                        </div>
                        @endif
                    </div>
                    <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-600">
                            <strong>Referensi:</strong> Normal -2 SD hingga +2 SD • Rentang aman untuk pertumbuhan anak
                        </p>
                    </div> --}}
                </div>
                @endif

                <!-- Recommendations -->
                @if($record->recommendations)
                <div class="bg-gradient-to-br from-green-50 to-white rounded-2xl shadow-xl border border-green-200 p-6">
                    <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Rekomendasi
                    </h4>
                    <div class="prose prose-sm max-w-none">
                        <p class="text-gray-700 leading-relaxed">{{ $record->recommendations }}</p>
                    </div>
                </div>
                @endif

                <!-- Nutrition Advice -->
                @if($record->nutrition_advice && count($record->nutrition_advice) > 0)
                <div class="bg-gradient-to-br from-orange-50 to-white rounded-2xl shadow-xl border border-orange-200 p-6">
                    <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Panduan Nutrisi
                    </h4>
                    <ul class="space-y-3">
                        @foreach($record->nutrition_advice as $advice)
                        <li class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-orange-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm text-gray-700">{{ $advice }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Milestones -->
                @if($record->milestone_check && count($record->milestone_check) > 0)
                <div class="bg-gradient-to-br from-indigo-50 to-white rounded-2xl shadow-xl border border-indigo-200 p-6">
                    <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                        Milestone Perkembangan
                    </h4>
                    <ul class="space-y-3">
                        @foreach($record->milestone_check as $milestone)
                        <li class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-indigo-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="text-sm text-gray-700">{{ $milestone }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Parent Notes -->
                @if($record->parent_notes)
                <div class="bg-gray-50 rounded-2xl border border-gray-200 p-6">
                    <h4 class="font-bold text-gray-800 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Catatan Orang Tua
                    </h4>
                    <p class="text-sm text-gray-700 italic">{{ $record->parent_notes }}</p>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex gap-4">
                    <a href="{{ route('growth.edit', $record->id) }}" 
                       class="flex-1 px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white text-center font-semibold rounded-xl transition-colors">
                        Edit Data
                    </a>
                    <form action="{{ route('growth.destroy', $record->id) }}" method="POST" 
                          onsubmit="return confirm('Yakin ingin menghapus data pertumbuhan ini?')"
                          class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full px-6 py-3 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-xl transition-colors">
                            Hapus Data
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('growthChart').getContext('2d');
            
            // 1. DATA ANAK
            const childRecords = @json($record->child->growthRecords->sortBy('age_months')->values());
            const childData = childRecords.map(rec => ({ x: rec.age_months, y: rec.actual_weight }));
            const gender = "{{ $record->child->gender }}"; 

            // 2. DATA REFERENSI WHO (Lengkap dengan -3 SD untuk Gizi Buruk)
            const whoStandards = {
                'male': [
                    {x: 0, m: 3.3, s3n: 2.1, s2n: 2.5, s2p: 4.4, s3p: 5.0},
                    {x: 6, m: 7.9, s3n: 5.7, s2n: 6.4, s2p: 9.8, s3p: 10.9},
                    {x: 12, m: 9.6, s3n: 7.0, s2n: 7.7, s2p: 12.0, s3p: 13.3},
                    {x: 24, m: 12.2, s3n: 8.8, s2n: 9.7, s2p: 15.3, s3p: 17.0},
                    {x: 36, m: 14.3, s3n: 10.0, s2n: 11.3, s2p: 18.3, s3p: 20.3},
                    {x: 48, m: 16.3, s3n: 11.3, s2n: 12.7, s2p: 21.2, s3p: 23.7},
                    {x: 60, m: 18.3, s3n: 12.5, s2n: 14.1, s2p: 24.2, s3p: 27.2}
                ],
                'female': [
                    {x: 0, m: 3.2, s3n: 2.0, s2n: 2.4, s2p: 4.2, s3p: 4.8},
                    {x: 6, m: 7.3, s3n: 5.1, s2n: 5.7, s2p: 9.3, s3p: 10.4},
                    {x: 12, m: 8.9, s3n: 6.3, s2n: 7.0, s2p: 11.5, s3p: 12.9},
                    {x: 24, m: 11.5, s3n: 8.1, s2n: 9.0, s2p: 14.8, s3p: 16.5},
                    {x: 36, m: 13.9, s3n: 9.6, s2n: 10.8, s2p: 18.1, s3p: 20.2},
                    {x: 48, m: 16.1, s3n: 10.9, s2n: 12.3, s2p: 21.5, s3p: 24.0},
                    {x: 60, m: 18.2, s3n: 12.1, s2n: 13.7, s2p: 24.9, s3p: 27.9}
                ]
            };

            const standard = whoStandards[gender];

            new Chart(ctx, {
                type: 'line',
                data: {
                    datasets: [
                        // --- LAYER 1: DATA ANAK (Paling Atas) ---
                        {
                            label: 'Anak',
                            data: childData,
                            borderColor: 'rgb(37, 99, 235)', // Biru Tua
                            backgroundColor: 'white',
                            borderWidth: 3,
                            pointRadius: 6,
                            pointHoverRadius: 8,
                            pointBorderWidth: 2,
                            zIndex: 100 // Pastikan di paling atas
                        },
                        
                        // --- LAYER 2: GARIS MEDIAN (Ideal) ---
                        {
                            label: 'Median (Ideal)',
                            data: standard.map(d => ({x: d.x, y: d.m})),
                            borderColor: 'rgb(22, 163, 74)', // Hijau Tua Garis
                            borderWidth: 2,
                            pointRadius: 0,
                            borderDash: [5, 5],
                            tension: 0.4,
                            fill: false
                        },

                        // --- LAYER 3: AREA KUNING ATAS (Gemuk: +2SD s/d +3SD) ---
                        {
                            label: 'Gemuk (+3 SD)',
                            data: standard.map(d => ({x: d.x, y: d.s3p})),
                            borderColor: 'transparent',
                            backgroundColor: 'rgba(250, 204, 21, 0.4)', // Kuning Pekat
                            pointRadius: 0,
                            tension: 0.4,
                            fill: '-1' // Fill ke dataset sebelumnya (Median? Bukan, kita atur urutan fill nanti)
                            // Trik: Kita gambar garis paling atas, lalu fill ke garis di bawahnya
                        },
                        {
                            label: 'Batas Atas Normal (+2 SD)',
                            data: standard.map(d => ({x: d.x, y: d.s2p})),
                            borderColor: 'transparent',
                            backgroundColor: 'rgba(250, 204, 21, 0.4)', // Kuning (Menutup area atas)
                            pointRadius: 0,
                            tension: 0.4,
                            fill: '-1' // Fill ke dataset s3p (Membuat area kuning atas)
                        },

                        // --- LAYER 4: AREA HIJAU (Normal: -2SD s/d +2SD) ---
                        // Kita timpa area kuning tadi dengan hijau di tengah
                        {
                            label: 'Area Normal',
                            data: standard.map(d => ({x: d.x, y: d.s2p})), // Garis Atas Hijau (+2SD)
                            borderColor: 'transparent',
                            backgroundColor: 'rgba(74, 222, 128, 0.5)', // Hijau Segar
                            pointRadius: 0,
                            tension: 0.4,
                            fill: false // Jangan fill dulu
                        },
                        {
                            label: 'Batas Bawah Normal (-2 SD)',
                            data: standard.map(d => ({x: d.x, y: d.s2n})), // Garis Bawah Hijau (-2SD)
                            borderColor: 'transparent',
                            backgroundColor: 'rgba(74, 222, 128, 0.5)', // Hijau Segar
                            pointRadius: 0,
                            tension: 0.4,
                            fill: '-1' // Fill ke garis +2SD (Membentuk pita hijau di tengah)
                        },

                        // --- LAYER 5: AREA KUNING BAWAH (Kurang Gizi: -2SD s/d -3SD) ---
                        {
                            label: 'Kurang Gizi (-3 SD)',
                            data: standard.map(d => ({x: d.x, y: d.s3n})),
                            borderColor: 'transparent',
                            backgroundColor: 'rgba(250, 204, 21, 0.4)', // Kuning
                            pointRadius: 0,
                            tension: 0.4,
                            fill: '-1' // Fill ke garis -2SD (Membentuk pita kuning bawah)
                        },

                        // --- LAYER 6: AREA MERAH (Gizi Buruk: < -3SD) ---
                        {
                            label: 'Gizi Buruk',
                            data: standard.map(d => ({x: d.x, y: 0})), // Sampai Nol
                            borderColor: 'transparent',
                            backgroundColor: 'rgba(248, 113, 113, 0.5)', // Merah
                            pointRadius: 0,
                            tension: 0.4,
                            fill: '-1' // Fill ke garis -3SD (Membentuk area merah di paling bawah)
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: { 
                            type: 'linear', 
                            min: 0, 
                            max: 60, 
                            title: {display: true, text: 'Usia (Bulan)'},
                            ticks: { stepSize: 6 }
                        },
                        y: { 
                            title: {display: true, text: 'Berat (kg)'},
                            min: 0
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                // Filter legend agar tidak terlalu penuh (hanya tampilkan yang penting)
                                filter: function(item, chart) {
                                    return !item.text.includes('Batas') && !item.text.includes('Median'); 
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    // Custom tooltip agar label dataset lebih rapi
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += context.parsed.y + ' kg';
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    <script>
        // Auto-hide flash messages
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }, 5000);
            });
        });
    </script>
</x-app-layout>