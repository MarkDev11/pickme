<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            <h2 class="font-bold text-lg text-gray-800 leading-tight">
                Tambah Data Anak
            </h2>
        </div>
    </x-slot>

    <div class=" mx-auto">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 shadow-md" role="alert">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 shadow-md" role="alert">
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
                        <p class="font-medium mb-2">Terdapat beberapa kesalahan:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Info Banner -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl shadow-xl p-6 mb-8 text-white">
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-1">Informasi Penting</h3>
                    <p class="text-sm text-blue-100">Isi data dengan lengkap dan benar. Data ini akan digunakan untuk analisis tumbuh kembang anak Anda.</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-white px-8 py-6 border-b border-blue-100">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Data Anak
                </h3>
            </div>

            <form action="{{ route('children.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf

                <!-- Nama Anak -->
                <div class="group">
                    <label for="name" class="block text-sm font-semibold text-gray-800 mb-2">
                        Nama Lengkap Anak <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" required value="{{ old('name') }}"
                           class="w-full px-4 py-3 bg-white border-2 {{ $errors->has('name') ? 'border-red-300' : 'border-blue-200' }} rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition-all duration-300 outline-none group-hover:border-blue-300"
                           placeholder="Contoh: Ahmad Fauzi">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Jenis Kelamin & Tanggal Lahir -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="group">
                        <label for="gender" class="block text-sm font-semibold text-gray-800 mb-2">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select id="gender" name="gender" required
                                class="w-full px-4 py-3 bg-white border-2 {{ $errors->has('gender') ? 'border-red-300' : 'border-blue-200' }} rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition-all duration-300 outline-none">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="group">
                        <label for="birth_date" class="block text-sm font-semibold text-gray-800 mb-2">
                            Tanggal Lahir <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="birth_date" name="birth_date" required value="{{ old('birth_date') }}"
                               max="{{ date('Y-m-d') }}"
                               min="{{ now()->subYears(18)->format('Y-m-d') }}"
                               class="w-full px-4 py-3 bg-white border-2 {{ $errors->has('birth_date') ? 'border-red-300' : 'border-blue-200' }} rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition-all duration-300 outline-none">
                        @error('birth_date')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Tempat Lahir -->
                <div class="group">
                    <label for="birth_place" class="block text-sm font-semibold text-gray-800 mb-2">
                        Tempat Lahir <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="birth_place" name="birth_place" required value="{{ old('birth_place') }}"
                           class="w-full px-4 py-3 bg-white border-2 {{ $errors->has('birth_place') ? 'border-red-300' : 'border-blue-200' }} rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition-all duration-300 outline-none"
                           placeholder="Contoh: RS Budi Asih, Jakarta">
                    @error('birth_place')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Data Kelahiran -->
                <div class="bg-blue-50 rounded-xl p-6 border-2 border-blue-200">
                    <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Data Saat Lahir
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="group">
                            <label for="birth_weight" class="block text-sm font-semibold text-gray-800 mb-2">
                                Berat Lahir (kg) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" step="0.01" id="birth_weight" name="birth_weight" required value="{{ old('birth_weight') }}"
                                   min="0.5" max="10"
                                   class="w-full px-4 py-3 bg-white border-2 {{ $errors->has('birth_weight') ? 'border-red-300' : 'border-blue-200' }} rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition-all duration-300 outline-none"
                                   placeholder="Contoh: 3.2">
                            @error('birth_weight')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="group">
                            <label for="birth_height" class="block text-sm font-semibold text-gray-800 mb-2">
                                Tinggi Lahir (cm) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" step="0.01" id="birth_height" name="birth_height" required value="{{ old('birth_height') }}"
                                   min="20" max="80"
                                   class="w-full px-4 py-3 bg-white border-2 {{ $errors->has('birth_height') ? 'border-red-300' : 'border-blue-200' }} rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition-all duration-300 outline-none"
                                   placeholder="Contoh: 48">
                            @error('birth_height')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="group">
                            <label for="birth_type" class="block text-sm font-semibold text-gray-800 mb-2">
                                Jenis Kelahiran <span class="text-red-500">*</span>
                            </label>
                            <select id="birth_type" name="birth_type" required
                                    class="w-full px-4 py-3 bg-white border-2 {{ $errors->has('birth_type') ? 'border-red-300' : 'border-blue-200' }} rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition-all duration-300 outline-none">
                                <option value="">Pilih</option>
                                <option value="normal" {{ old('birth_type') === 'normal' ? 'selected' : '' }}>Normal</option>
                                <option value="cesarean" {{ old('birth_type') === 'cesarean' ? 'selected' : '' }}>Caesar</option>
                            </select>
                            @error('birth_type')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Golongan Darah (Optional) -->
                <div class="group">
                    <label for="blood_type" class="block text-sm font-semibold text-gray-800 mb-2">
                        Golongan Darah <span class="text-gray-500 text-xs">(Opsional)</span>
                    </label>
                    <select id="blood_type" name="blood_type"
                            class="w-full px-4 py-3 bg-white border-2 {{ $errors->has('blood_type') ? 'border-red-300' : 'border-blue-200' }} rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition-all duration-300 outline-none">
                        <option value="">Pilih Golongan Darah</option>
                        <optgroup label="Golongan A">
                            <option value="A+" {{ old('blood_type') === 'A+' ? 'selected' : '' }}>A+</option>
                            <option value="A-" {{ old('blood_type') === 'A-' ? 'selected' : '' }}>A-</option>
                            <option value="A" {{ old('blood_type') === 'A' ? 'selected' : '' }}>A (Rhesus tidak diketahui)</option>
                        </optgroup>
                        <optgroup label="Golongan B">
                            <option value="B+" {{ old('blood_type') === 'B+' ? 'selected' : '' }}>B+</option>
                            <option value="B-" {{ old('blood_type') === 'B-' ? 'selected' : '' }}>B-</option>
                            <option value="B" {{ old('blood_type') === 'B' ? 'selected' : '' }}>B (Rhesus tidak diketahui)</option>
                        </optgroup>
                        <optgroup label="Golongan AB">
                            <option value="AB+" {{ old('blood_type') === 'AB+' ? 'selected' : '' }}>AB+</option>
                            <option value="AB-" {{ old('blood_type') === 'AB-' ? 'selected' : '' }}>AB-</option>
                            <option value="AB" {{ old('blood_type') === 'AB' ? 'selected' : '' }}>AB (Rhesus tidak diketahui)</option>
                        </optgroup>
                        <optgroup label="Golongan O">
                            <option value="O+" {{ old('blood_type') === 'O+' ? 'selected' : '' }}>O+</option>
                            <option value="O-" {{ old('blood_type') === 'O-' ? 'selected' : '' }}>O-</option>
                            <option value="O" {{ old('blood_type') === 'O' ? 'selected' : '' }}>O (Rhesus tidak diketahui)</option>
                        </optgroup>
                    </select>
                    @error('blood_type')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Catatan Kesehatan -->
                <div class="group">
                    <label for="health_notes" class="block text-sm font-semibold text-gray-800 mb-2">
                        Catatan Kesehatan Khusus <span class="text-gray-500 text-xs">(Opsional)</span>
                    </label>
                    <textarea id="health_notes" name="health_notes" rows="3"
                              class="w-full px-4 py-3 bg-white border-2 {{ $errors->has('health_notes') ? 'border-red-300' : 'border-blue-200' }} rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition-all duration-300 outline-none resize-none"
                              placeholder="Contoh: Lahir prematur, riwayat penyakit bawaan, dll">{{ old('health_notes') }}</textarea>
                    @error('health_notes')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Catatan Alergi -->
                <div class="group">
                    <label for="allergy_notes" class="block text-sm font-semibold text-gray-800 mb-2">
                        Catatan Alergi <span class="text-gray-500 text-xs">(Opsional)</span>
                    </label>
                    <textarea id="allergy_notes" name="allergy_notes" rows="2"
                              class="w-full px-4 py-3 bg-white border-2 {{ $errors->has('allergy_notes') ? 'border-red-300' : 'border-blue-200' }} rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition-all duration-300 outline-none resize-none"
                              placeholder="Contoh: Alergi susu sapi, telur, kacang, dll">{{ old('allergy_notes') }}</textarea>
                    @error('allergy_notes')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Foto Anak (Optional) -->
                <div class="group">
                    <label for="photo" class="block text-sm font-semibold text-gray-800 mb-2">
                        Foto Anak <span class="text-gray-500 text-xs">(Opsional - Maks 5MB)</span>
                    </label>
                    <div class="relative border-3 border-dashed {{ $errors->has('photo') ? 'border-red-300' : 'border-blue-300' }} rounded-2xl p-6 text-center hover:border-blue-500 transition-all duration-300 bg-blue-50/30 cursor-pointer"
                         onclick="document.getElementById('photo').click()">
                        <input type="file" id="photo" name="photo" accept="image/jpeg,image/jpg,image/png" class="hidden" onchange="previewImage(event)">
                        
                        <div id="uploadPrompt">
                            <svg class="w-12 h-12 text-blue-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-gray-600 mb-1">Klik untuk upload foto</p>
                            <p class="text-sm text-gray-500">Format: PNG, JPG, JPEG • Maksimal 5MB</p>
                        </div>

                        <div id="imagePreview" class="hidden">
                            <img id="preview" class="max-h-40 mx-auto rounded-xl shadow-lg">
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

                <!-- Action Buttons -->
                <div class="flex gap-4 pt-4">
                    <a href="{{ route('children.index') }}" 
                       class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl text-center transition-all duration-300">
                        Batal
                    </a>
                    <button type="submit" 
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-300">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Data Anak
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                // Validasi ukuran file (5MB = 5 * 1024 * 1024 bytes)
                if (file.size > 5 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar! Maksimal 5MB.');
                    event.target.value = '';
                    return;
                }

                // Validasi tipe file
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
    </script>
</x-app-layout>