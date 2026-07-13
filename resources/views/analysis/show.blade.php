<x-app-layout>
    <x-slot name="header">
        Detail Analisis
    </x-slot>

    <div class="">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('analysis.index') }}" 
               class="inline-flex items-center space-x-2 text-blue-600 hover:text-blue-700 font-semibold transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Kembali ke Dashboard</span>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Image Section -->
            <div class="lg:col-span-1">
                <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 overflow-hidden sticky top-8">
                    <div class="bg-gradient-to-r from-blue-50 to-white px-6 py-4 border-b border-blue-100">
                        <h3 class="font-bold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Foto Dianalisis
                        </h3>
                    </div>
                    <div class="p-6">
                        <img src="{{ asset($analysis->image_path) }}"
                             class="w-full rounded-xl shadow-lg mb-4"
                             alt="Analisis Tubuh">
                        <div class="flex gap-2">
                            <a href="{{ asset($analysis->image_path) }}"
                               target="_blank"
                               class="flex-1 px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold rounded-lg transition-colors text-center text-sm">
                                Lihat Ukuran Penuh
                            </a>
                            <button onclick="downloadImage()"
                                    class="flex-1 px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 font-semibold rounded-lg transition-colors text-sm">
                                Unduh
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details Section -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Timestamp Card -->
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl shadow-xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm mb-1">Tanggal Analisis</p>
                            <p class="text-2xl font-bold">{{ $analysis->created_at->format('F d, Y') }}</p>
                            <p class="text-blue-100 text-sm mt-1">{{ $analysis->created_at->format('h:i A') }}</p>
                        </div>
                        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Measurements Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Height Card -->
                    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-green-200 p-6 transform hover:scale-105 transition-all duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm font-medium mb-1">Tinggi</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $analysis->estimated_height }}</p>
                        <p class="text-green-600 font-semibold">cm</p>
                    </div>

                    <!-- Weight Card -->
                    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-purple-200 p-6 transform hover:scale-105 transition-all duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm font-medium mb-1">Berat</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $analysis->estimated_weight }}</p>
                        <p class="text-purple-600 font-semibold">kg</p>
                    </div>

                    <!-- Age Card -->
                    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-orange-200 p-6 transform hover:scale-105 transition-all duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                                <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm font-medium mb-1">Usia</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $analysis->estimated_age }}</p>
                        <p class="text-orange-600 font-semibold">tahun</p>
                    </div>
                </div>

                <!-- BMI Card -->
                @php
                    $heightM = $analysis->estimated_height / 100;
                    $bmi = $heightM > 0 ? round($analysis->estimated_weight / ($heightM * $heightM), 1) : 0;
                    
                    if ($bmi < 18.5) {
                        $bmiCategory = 'Kurus';
                        $bmiColor = 'blue';
                        $bmiIcon = 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6';
                    } elseif ($bmi < 25) {
                        $bmiCategory = 'Normal';
                        $bmiColor = 'green';
                        $bmiIcon = 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z';
                    } elseif ($bmi < 30) {
                        $bmiCategory = 'Gemuk';
                        $bmiColor = 'yellow';
                        $bmiIcon = 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z';
                    } else {
                        $bmiCategory = 'Obesitas';
                        $bmiColor = 'red';
                        $bmiIcon = 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z';
                    }
                @endphp

                <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-{{ $bmiColor }}-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-{{ $bmiColor }}-50 to-white px-6 py-4 border-b border-{{ $bmiColor }}-100">
                        <h3 class="font-bold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-{{ $bmiColor }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $bmiIcon }}"/>
                            </svg>
                            Indeks Massa Tubuh (BMI)
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-5xl font-bold text-{{ $bmiColor }}-600">{{ $bmi }}</p>
                                <p class="text-lg font-semibold text-{{ $bmiColor }}-700 mt-2">{{ $bmiCategory }}</p>
                            </div>
                            <div class="w-20 h-20 bg-{{ $bmiColor }}-100 rounded-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-{{ $bmiColor }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                        </div>

                        <!-- BMI Scale -->
                        <div class="space-y-2">
                            <div class="flex justify-between text-xs font-medium text-gray-600 mb-1">
                                <span>Kurus</span>
                                <span>Normal</span>
                                <span>Gemuk</span>
                                <span>Obesitas</span>
                            </div>
                            <div class="h-3 w-full bg-gradient-to-r from-blue-400 via-green-400 via-yellow-400 to-red-400 rounded-full relative">
                                <div class="absolute top-1/2 transform -translate-y-1/2 w-1 h-6 bg-gray-800 rounded-full shadow-lg" 
                                     style="left: {{ min(($bmi / 40) * 100, 100) }}%"></div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500">
                                <span>18.5</span>
                                <span>25</span>
                                <span>30</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- AI Analysis Card -->
                <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-50 to-white px-6 py-4 border-b border-blue-100">
                        <h3 class="font-bold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                            Catatan Analisis AI
                        </h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-700 leading-relaxed">{{ $analysis->full_analysis }}</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-4">
                    <a href="{{ route('analysis.create') }}" 
                       class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-300 text-center">
                        Analisis Baru
                    </a>
                    <form action="{{ route('analysis.destroy', $analysis->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus analisis ini?')" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-300">
                            Hapus Analisis
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function downloadImage() {
            const link = document.createElement('a');
            link.href = '{{ asset($analysis->image_path) }}';
            link.download = 'body-analysis-{{ $analysis->id }}.jpg';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
</x-app-layout>