<x-app-layout>
    <x-slot name="header">
        Analisis Tubuh Baru
    </x-slot>

    <div class="">
        <!-- Info Banner -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl shadow-xl p-8 mb-8 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full -ml-24 -mb-24"></div>
            
            <div class="relative z-10">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold mb-1">Analisis Tubuh dengan AI</h2>
                        <p class="text-blue-100">Unggah foto seluruh tubuh untuk analisis AI instan</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6">
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <div>
                                <p class="text-sm text-blue-100">Waktu Proses</p>
                                <p class="font-bold">3-5 detik</p>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <div>
                                <p class="text-sm text-blue-100">AI Model</p>
                                <p class="font-bold">Gemini 2.5 Flash</p>
                            </div>
                        </div>
                    </div> --}}
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6">
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <div>
                                <p class="text-sm text-blue-100">Ukuran Maks File</p>
                                <p class="font-bold">5 MB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Upload Form -->
            <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-white px-8 py-6 border-b border-blue-100">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Unggah Foto
                    </h3>
                </div>

                <form action="{{ route('analysis.store') }}" method="POST" enctype="multipart/form-data" class="p-8" id="analysisForm">
                    @csrf

                    @if(session('error'))
                        <div id="aiError" class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl flex items-start space-x-2">
                            <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-red-800">Analisis AI Gagal</p>
                                <p class="text-sm text-red-700 mt-1">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl flex items-start space-x-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                        </div>
                    @endif

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-800 mb-3">
                            Pilih Foto Seluruh Tubuh
                        </label>
                        
                        <!-- File Upload Area -->
                        <div class="relative border-3 border-dashed border-blue-300 rounded-2xl p-8 text-center hover:border-blue-500 transition-all duration-300 bg-blue-50/30 group cursor-pointer"
                             onclick="document.getElementById('photoInput').click()">
                            <input type="file" 
                                   id="photoInput"
                                   name="photo" 
                                   accept="image/*" 
                                   required 
                                   class="hidden"
                                   onchange="previewImage(event)">
                            
                            <div id="uploadPrompt" class="space-y-3">
                                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto group-hover:scale-110 transition-transform">
                                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-600 font-medium">Klik untuk unggah atau seret dan lepas</p>
                                <p class="text-sm text-gray-500">PNG, JPG, JPEG maks 5MB</p>
                            </div>

                            <div id="imagePreview" class="hidden">
                                <img id="preview" class="max-h-64 mx-auto rounded-xl shadow-lg">
                                <p class="mt-3 text-sm text-gray-600">Klik untuk ganti foto</p>
                            </div>
                        </div>

                        @error('photo')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <button type="submit" 
                            id="submitBtn"
                            class="w-full py-4 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 flex items-center justify-center space-x-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <span>Analisis dengan AI</span>
                    </button>

                    <div id="loadingState" class="hidden mt-4 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                        <div class="flex items-center justify-center space-x-3">
                            <svg class="animate-spin h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <p class="text-blue-700 font-medium">Menganalisis gambar dengan AI... Harap tunggu</p>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Instructions -->
            <div class="space-y-6">
                <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 p-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Panduan
                    </h3>
                    <ul class="space-y-3">
                        <li class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">Gunakan foto yang jelas dan cukup terang</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">Pastikan seluruh tubuh terlihat</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">Berdiri tegak, menghadap kamera</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">Hindari pakaian longgar</span>
                        </li>
                    </ul>
                </div>

                <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl shadow-lg border border-yellow-200 p-8">
                    <div class="flex items-start space-x-3">
                        <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h4 class="font-bold text-yellow-900 mb-2">Catatan Penting</h4>
                            <p class="text-sm text-yellow-800 leading-relaxed">
                                Ini adalah alat estimasi AI. Hasil dapat bervariasi dan tidak boleh digunakan untuk diagnosis medis. Untuk pengukuran akurat, silakan konsultasi dengan tenaga kesehatan profesional.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                    document.getElementById('uploadPrompt').classList.add('hidden');
                    document.getElementById('imagePreview').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        const form = document.getElementById('analysisForm');
        const photoInput = document.getElementById('photoInput');

        photoInput.addEventListener('invalid', function(e) {
            e.preventDefault();
            let msg = 'Silakan pilih foto terlebih dahulu.';
            if (e.target.validity.typeMismatch) {
                msg = 'File harus berupa gambar (JPG, JPEG, atau PNG).';
            } else if (e.target.validity.valueMissing) {
                msg = 'Silakan pilih foto terlebih dahulu.';
            }
            showInlineError(msg);
        });

        function showInlineError(msg) {
            let box = document.getElementById('inlineError');
            if (!box) {
                box = document.createElement('div');
                box.id = 'inlineError';
                box.className = 'mb-4 p-4 bg-red-50 border border-red-200 rounded-xl flex items-start space-x-2';
                form.insertBefore(box, form.firstChild.nextSibling);
            }
            box.innerHTML = '<svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg><p class="text-sm text-red-700 font-medium">' + msg + '</p>';
            box.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        form.addEventListener('submit', function(e) {
            if (!photoInput.files || photoInput.files.length === 0) {
                e.preventDefault();
                showInlineError('Silakan pilih foto terlebih dahulu.');
                return;
            }
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('loadingState').classList.remove('hidden');
        });
    </script>
</x-app-layout>