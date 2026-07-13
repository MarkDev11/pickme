<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-green-100 rounded-lg text-green-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h2 class="font-bold text-lg text-gray-800 leading-tight">
                Tambah Data Pertumbuhan
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

        <!-- Child Info Banner -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl shadow-xl p-8 mb-8 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full -ml-24 -mb-24"></div>
            
            <div class="relative z-10 flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <div class="w-20 h-20 bg-white rounded-2xl flex items-center justify-center shadow-lg overflow-hidden">
                        @if($child->photo)
                            <img src="{{ asset($child->photo) }}" class="w-full h-full object-cover" alt="{{ $child->name }}">
                        @else
                            <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold mb-1">{{ $child->name }}</h2>
                        <div class="flex items-center space-x-4 text-blue-100">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $child->age_text }}
                            </span>
                            <span class="flex items-center">
                                {{ $child->gender === 'male' ? '👦 Laki-laki' : '👧 Perempuan' }}
                            </span>
                        </div>
                    </div>
                </div>
                <a href="{{ route('children.show', $child->id) }}" 
                   class="px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg transition-colors text-sm">
                    ← Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Upload Form -->
            <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-white px-8 py-6 border-b border-blue-100">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Unggah Foto Anak
                    </h3>
                </div>

                <form action="{{ route('growth.store', $child->id) }}" method="POST" enctype="multipart/form-data" id="growthForm" class="p-8 space-y-6">
                    @csrf

                    <!-- Photo Upload -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-3">
                            Foto Seluruh Tubuh Anak <span class="text-red-500">*</span>
                        </label>
                        
                        <div class="relative border-3 border-dashed {{ $errors->has('photo') ? 'border-red-300' : 'border-blue-300' }} rounded-2xl p-8 text-center hover:border-blue-500 transition-all duration-300 bg-blue-50/30 cursor-pointer"
                             onclick="document.getElementById('photo').click()">
                            <input type="file" id="photo" name="photo" accept="image/jpeg,image/jpg,image/png" required class="hidden" onchange="previewImage(event)">
                            
                            <div id="uploadPrompt">
                                <div class="w-20 h-20 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-700 font-medium mb-2">Klik untuk unggah foto</p>
                                <p class="text-sm text-gray-500">Format: JPG, JPEG, PNG • Maksimal 5MB</p>
                            </div>

                            <div id="imagePreview" class="hidden">
                                <img id="preview" class="max-h-64 mx-auto rounded-xl shadow-lg">
                                <p class="mt-3 text-sm text-gray-600">Klik untuk ganti foto</p>
                            </div>
                        </div>
                        @error('photo')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Record Date -->
                    <div>
                        <label for="record_date" class="block text-sm font-semibold text-gray-800 mb-2">
                            Tanggal Pemeriksaan <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="record_date" name="record_date" required 
                               value="{{ old('record_date', date('Y-m-d')) }}"
                               max="{{ date('Y-m-d') }}"
                               class="w-full px-4 py-3 bg-white border-2 {{ $errors->has('record_date') ? 'border-red-300' : 'border-blue-200' }} rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition-all duration-300 outline-none">
                        @error('record_date')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Head Circumference (Optional) -->
                    <div>
                        <label for="head_circumference" class="block text-sm font-semibold text-gray-800 mb-2">
                            Lingkar Kepala (cm) <span class="text-gray-500 text-xs">(Opsional)</span>
                        </label>
                        <input type="number" step="0.1" id="head_circumference" name="head_circumference"
                               value="{{ old('head_circumference') }}"
                               min="20" max="70"
                               class="w-full px-4 py-3 bg-white border-2 border-blue-200 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition-all duration-300 outline-none"
                               placeholder="Contoh: 45.5">
                        <p class="text-xs text-gray-500 mt-1">Diukur di bagian terlebar kepala</p>
                    </div>

                    <!-- Parent Notes -->
                    <div>
                        <label for="parent_notes" class="block text-sm font-semibold text-gray-800 mb-2">
                            Catatan <span class="text-gray-500 text-xs">(Opsional)</span>
                        </label>
                        <textarea id="parent_notes" name="parent_notes" rows="3"
                                  class="w-full px-4 py-3 bg-white border-2 border-blue-200 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition-all duration-300 outline-none resize-none"
                                  placeholder="Tambahkan catatan jika ada kondisi khusus...">{{ old('parent_notes') }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="space-y-3">
                        <button type="submit" id="submitBtn"
                                class="w-full px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span id="submitText" class="flex items-center justify-center">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Analisis dengan AI
                            </span>
                            <span id="loadingText" class="hidden flex items-center justify-center">
                                <svg class="animate-spin h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Sedang menganalisis... Mohon tunggu
                            </span>
                        </button>
                        
                        <a href="{{ route('children.show', $child->id) }}" 
                           class="block w-full px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 text-center font-semibold rounded-xl transition-colors">
                            Batal
                        </a>
                    </div>
                </form>
            </div>

            <!-- Instructions & Tips -->
            <div class="space-y-6">
                <!-- Best Practices -->
                <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-green-100 p-6">
                    <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Tips Foto yang Baik
                    </h4>
                    <ul class="space-y-3">
                        <li class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700 text-sm"><strong>Foto seluruh tubuh</strong> - Seluruh tubuh anak terlihat dari kepala sampai kaki</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700 text-sm"><strong>Pencahayaan cukup</strong> - Di siang hari atau ruangan terang</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700 text-sm"><strong>Posisi tegak</strong> - Anak berdiri tegak menghadap kamera</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700 text-sm"><strong>Background polos</strong> - Latar belakang tidak terlalu ramai</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700 text-sm"><strong>Pakaian tipis</strong> - Hindari pakaian terlalu tebal/berlapis</span>
                        </li>
                    </ul>
                </div>

                <!-- Process Info -->
                <div class="bg-gradient-to-br from-blue-50 to-white rounded-2xl shadow-lg border border-blue-200 p-6">
                    <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Proses Selanjutnya
                    </h4>
                    <ol class="space-y-3">
                        <li class="flex items-start space-x-3">
                            <span class="flex-shrink-0 w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold">1</span>
                            <span class="text-gray-700 text-sm">AI menganalisis foto (30-60 detik)</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <span class="flex-shrink-0 w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold">2</span>
                            <span class="text-gray-700 text-sm">Estimasi berat & tinggi badan</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <span class="flex-shrink-0 w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold">3</span>
                            <span class="text-gray-700 text-sm"><strong>Periksa dan edit</strong> data jika perlu</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <span class="flex-shrink-0 w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold">4</span>
                            <span class="text-gray-700 text-sm">Konfirmasi untuk menyimpan</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <span class="flex-shrink-0 w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold">5</span>
                            <span class="text-gray-700 text-sm">Lihat analisis lengkap & rekomendasi</span>
                        </li>
                    </ol>
                </div>

                <!-- Warning -->
                <div class="bg-gradient-to-br from-yellow-50 to-white rounded-2xl shadow-lg border border-yellow-200 p-6">
                    <div class="flex items-start space-x-3">
                        <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h4 class="font-bold text-yellow-900 mb-2">Penting!</h4>
                            <p class="text-sm text-yellow-800 leading-relaxed">
                                Hasil AI adalah <strong>estimasi</strong>. Anda bisa mengedit data setelah analisis selesai untuk memastikan akurasi.
                            </p>
                        </div>
                    </div>
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

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                // Validate file size (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar! Maksimal 5MB.');
                    event.target.value = '';
                    return;
                }

                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Format file tidak didukung! Gunakan JPEG, JPG, atau PNG.');
                    event.target.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                    document.getElementById('uploadPrompt').classList.add('hidden');
                    document.getElementById('imagePreview').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        document.getElementById('growthForm').addEventListener('submit', function(e) {
            const photoInput = document.getElementById('photo');
            if (!photoInput.files || !photoInput.files[0]) {
                e.preventDefault();
                alert('Silakan upload foto terlebih dahulu!');
                return;
            }

            // Disable submit button and show loading
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const loadingText = document.getElementById('loadingText');
            
            submitBtn.disabled = true;
            submitText.classList.add('hidden');
            loadingText.classList.remove('hidden');
        });

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