<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="font-bold text-lg text-gray-800 leading-tight">
                Konfirmasi & Edit Data
            </h2>
        </div>
    </x-slot>

    <div class=" mx-auto px-4 sm:px-6 lg:px-8">
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

        @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 shadow-md animate-fade-in" role="alert">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 shadow-md" role="alert">
            <div class="flex items-start">
                <svg class="w-6 h-6 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="font-medium mb-2">Terdapat kesalahan:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li class="text-sm">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <!-- Child Info -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl shadow-xl p-6 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-white rounded-xl flex items-center justify-center overflow-hidden">
                        @if($record->child->photo)
                            <img src="{{ asset($record->child->photo) }}" class="w-full h-full object-cover" alt="{{ $record->child->name }}">
                        @else
                            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-xl font-bold">{{ $record->child->name }}</h3>
                        <p class="text-blue-100">{{ $record->child->age_text }} • {{ $record->child->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm text-blue-100">Tanggal Pemeriksaan</p>
                    <p class="text-lg font-bold">{{ $record->record_date->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Photo & AI Analysis -->
            <div class="space-y-6">
                <!-- Uploaded Photo -->
                <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-50 to-white px-6 py-4 border-b border-blue-100">
                        <h4 class="font-bold text-gray-800">Foto yang Diupload</h4>
                    </div>
                    <div class="p-6">
                        <img src="{{ asset($record->photo_path) }}" class="w-full rounded-xl shadow-lg" alt="Foto Anak">
                    </div>
                </div>

                <!-- AI Analysis Results -->
                <div class="bg-gradient-to-br from-purple-50 to-white rounded-2xl shadow-xl border-2 border-purple-200 p-6">
                    <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                        Estimasi AI
                    </h4>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-4 bg-white rounded-xl border border-purple-100">
                            <span class="text-gray-700 font-medium">Berat Badan:</span>
                            <span class="text-2xl font-bold text-purple-600">{{ $record->ai_estimated_weight }} kg</span>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-white rounded-xl border border-purple-100">
                            <span class="text-gray-700 font-medium">Tinggi Badan:</span>
                            <span class="text-2xl font-bold text-purple-600">{{ $record->ai_estimated_height }} cm</span>
                        </div>
                    </div>
                    <div class="mt-4 p-4 bg-purple-50 rounded-xl border border-purple-200">
                        <p class="text-sm text-purple-800">
                            <svg class="w-5 h-5 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <strong>Catatan:</strong> Ini adalah estimasi dari AI. Silakan koreksi dengan data aktual jika berbeda.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 overflow-hidden">
                <div class="bg-gradient-to-r from-green-50 to-white px-8 py-6 border-b border-green-100">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Konfirmasi Data Aktual
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Sesuaikan data jika hasil AI kurang akurat</p>
                </div>

                <form action="{{ route('growth.update', $record->id) }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Actual Weight -->
                    <div class="group">
                        <label for="actual_weight" class="block text-sm font-semibold text-gray-800 mb-2">
                            Berat Badan Aktual (kg) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" step="0.01" id="actual_weight" name="actual_weight" required
                                   value="{{ old('actual_weight', $record->actual_weight) }}"
                                   min="2" max="50"
                                   class="w-full px-4 py-3 pl-11 bg-white border-2 {{ $errors->has('actual_weight') ? 'border-red-300' : 'border-green-200' }} rounded-xl focus:ring-4 focus:ring-green-200 focus:border-green-500 transition-all duration-300 outline-none group-hover:border-green-300"
                                   placeholder="Masukkan berat aktual">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                                </svg>
                            </div>
                        </div>
                        @error('actual_weight')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">💡 Timbang di pagi hari sebelum makan untuk hasil akurat</p>
                    </div>

                    <!-- Actual Height -->
                    <div class="group">
                        <label for="actual_height" class="block text-sm font-semibold text-gray-800 mb-2">
                            Tinggi Badan Aktual (cm) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" step="0.01" id="actual_height" name="actual_height" required
                                   value="{{ old('actual_height', $record->actual_height) }}"
                                   min="40" max="200"
                                   class="w-full px-4 py-3 pl-11 bg-white border-2 {{ $errors->has('actual_height') ? 'border-red-300' : 'border-green-200' }} rounded-xl focus:ring-4 focus:ring-green-200 focus:border-green-500 transition-all duration-300 outline-none group-hover:border-green-300"
                                   placeholder="Masukkan tinggi aktual">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                                </svg>
                            </div>
                        </div>
                        @error('actual_height')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">💡 Ukur tanpa sepatu dengan anak berdiri tegak</p>
                    </div>

                    <!-- Head Circumference -->
                    <div class="group">
                        <label for="head_circumference" class="block text-sm font-semibold text-gray-800 mb-2">
                            Lingkar Kepala (cm) <span class="text-gray-500 text-xs">(Opsional)</span>
                        </label>
                        <div class="relative">
                            <input type="number" step="0.1" id="head_circumference" name="head_circumference"
                                   value="{{ old('head_circumference', $record->head_circumference) }}"
                                   min="20" max="70"
                                   class="w-full px-4 py-3 pl-11 bg-white border-2 border-blue-200 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition-all duration-300 outline-none"
                                   placeholder="Contoh: 45.5">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Parent Notes -->
                    <div class="group">
                        <label for="parent_notes" class="block text-sm font-semibold text-gray-800 mb-2">
                            Catatan Tambahan <span class="text-gray-500 text-xs">(Opsional)</span>
                        </label>
                        <textarea id="parent_notes" name="parent_notes" rows="3"
                                  class="w-full px-4 py-3 bg-white border-2 border-blue-200 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition-all duration-300 outline-none resize-none"
                                  placeholder="Tambahkan catatan jika ada kondisi khusus...">{{ old('parent_notes', $record->parent_notes) }}</textarea>
                    </div>

                    <!-- Comparison Alert -->
                    @php
                        $weightDiff = abs($record->ai_estimated_weight - $record->actual_weight);
                        $heightDiff = abs($record->ai_estimated_height - $record->actual_height);
                        $hasSignificantDiff = $weightDiff > 0.5 || $heightDiff > 2;
                    @endphp

                    @if($hasSignificantDiff)
                    <div class="p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-sm text-yellow-800 font-medium">Data berbeda dari estimasi AI</p>
                                <p class="text-xs text-yellow-700 mt-1">
                                    @if($weightDiff > 0.5)
                                        Selisih BB: {{ number_format($weightDiff, 2) }} kg
                                    @endif
                                    @if($heightDiff > 2)
                                        {{ $weightDiff > 0.5 ? ' • ' : '' }}Selisih TB: {{ number_format($heightDiff, 1) }} cm
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex gap-4 pt-4">
                        <a href="{{ route('children.show', $record->child_id) }}" 
                           class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl text-center transition-all duration-300">
                            Batal
                        </a>
                        <button type="submit" 
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-300">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan Data
                            </span>
                        </button>
                    </div>
                </form>
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

        // Real-time difference calculation
        const weightInput = document.getElementById('actual_weight');
        const heightInput = document.getElementById('actual_height');
        const aiWeight = {{ $record->ai_estimated_weight }};
        const aiHeight = {{ $record->ai_estimated_height }};

        function updateComparison() {
            const actualWeight = parseFloat(weightInput.value) || aiWeight;
            const actualHeight = parseFloat(heightInput.value) || aiHeight;
            
            const weightDiff = Math.abs(actualWeight - aiWeight);
            const heightDiff = Math.abs(actualHeight - aiHeight);
            
            // You can add visual indicators here
        }

        weightInput.addEventListener('input', updateComparison);
        heightInput.addEventListener('input', updateComparison);
    </script>
</x-app-layout>