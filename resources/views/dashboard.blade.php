<x-app-layout>
    <x-slot name="header">
    <div class="flex items-center gap-3">
        <div class="p-2 bg-blue-100 rounded-lg text-blue-600 hidden sm:block">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
            </svg>
        </div>
        
        <div>
            <h2 class="font-bold text-lg text-gray-800 leading-tight">
                Dashboard
            </h2>
            <p class="text-xs text-gray-500 hidden sm:block">
                {{ now()->isoFormat('dddd, D MMMM YYYY') }}
            </p>
        </div>
    </div>
</x-slot>

    <div class="py-8">
        <div class=" mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Welcome Section -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl shadow-xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold mb-2">
                            Selamat Datang, {{ Auth::user()->name }}! 👋
                        </h3>
                        <p class="text-blue-100">
                            Pantau dan rekam perkembangan buah hati Anda dengan mudah
                        </p>
                    </div>
                    <div class="hidden md:block">
                        <svg class="w-24 h-24 text-blue-300 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Anak -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Total Anak</p>
                                <p class="text-3xl font-bold text-gray-900">
                                    {{ $totalChildren ?? 0 }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">Terdaftar dalam sistem</p>
                            </div>
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-blue-50 px-6 py-3">
                        <a href="{{ route('children.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center justify-between group">
                            <span>Lihat Semua Anak</span>
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Total Catatan Tumbuh Kembang -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Catatan Tumbuh Kembang</p>
                                <p class="text-3xl font-bold text-gray-900">
                                    {{ $totalRecords ?? 0 }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">Total pencatatan</p>
                            </div>
                            <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-green-50 px-6 py-3">
                        <a href="{{ route('children.index') }}" class="text-sm text-green-600 hover:text-green-800 font-medium flex items-center justify-between group">
                            <span>Lihat Riwayat</span>
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Analisa Body (Fitur Tambahan) -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Analisis Tubuh AI</p>
                                <p class="text-3xl font-bold text-gray-900">
                                    {{ $totalAnalyses ?? 0 }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">Fitur tambahan</p>
                            </div>
                            <div class="w-14 h-14 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-purple-50 px-6 py-3">
                        <a href="{{ route('analysis.index') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium flex items-center justify-between group">
                            <span>Coba Fitur AI</span>
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tambah Anak Baru -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-xl p-8 text-white hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                        </div>
                        <a href="{{ route('children.create') }}" class="bg-white text-blue-600 px-6 py-3 rounded-xl font-semibold hover:bg-blue-50 transition-all duration-300 shadow-lg hover:shadow-xl">
                            Tambah Anak
                        </a>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Daftarkan Anak Baru</h3>
                    <p class="text-blue-100 text-sm">
                        Mulai memantau tumbuh kembang buah hati Anda dengan mendaftarkan data anak
                    </p>
                </div>

                <!-- Catat Tumbuh Kembang -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-xl p-8 text-white hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <a href="{{ route('children.index') }}" class="bg-white text-green-600 px-6 py-3 rounded-xl font-semibold hover:bg-green-50 transition-all duration-300 shadow-lg hover:shadow-xl">
                            Catat Sekarang
                        </a>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Rekam Perkembangan</h3>
                    <p class="text-green-100 text-sm">
                        Catat tinggi, berat, dan perkembangan lainnya untuk monitoring yang lebih baik
                    </p>
                </div>
            </div>

            <!-- Anak-anak Terdaftar -->
            @if(isset($children) && $children->count() > 0)
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                    <h3 class="text-xl font-bold text-white">👶 Daftar Anak</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($children->take(6) as $child)
                        <div class="bg-gradient-to-br from-gray-50 to-white border-2 border-gray-100 rounded-xl p-5 hover:shadow-lg transition-all duration-300 hover:border-blue-200">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    @if($child->photo)
                                        <img src="{{ asset($child->photo) }}" alt="{{ $child->name }}" class="w-14 h-14 rounded-full object-cover border-2 border-blue-200">
                                    @else
                                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-xl">
                                            {{ substr($child->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <h4 class="font-bold text-gray-900">{{ $child->name }}</h4>
                                        <p class="text-xs text-gray-500">
                                            {{ $child->gender === 'male' ? '👦 Laki-laki' : '👧 Perempuan' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Usia:</span>
                                    <span class="font-semibold text-gray-900">{{ $child->age_in_months }} bulan</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Catatan:</span>
                                    <span class="font-semibold text-gray-900">{{ $child->growth_records_count ?? 0 }} data</span>
                                </div>
                            </div>

                            <a href="{{ route('children.show', $child->id) }}" class="block w-full bg-blue-500 hover:bg-blue-600 text-white text-center py-2 rounded-lg font-medium transition-colors duration-300">
                                Lihat Detail
                            </a>
                        </div>
                        @endforeach
                    </div>

                    @if($children->count() > 6)
                    <div class="mt-6 text-center">
                        <a href="{{ route('children.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                            <span>Lihat Semua Anak</span>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Data Anak</h3>
                <p class="text-gray-600 mb-6">
                    Mulai memantau tumbuh kembang buah hati dengan mendaftarkan data anak terlebih dahulu
                </p>
                <a href="{{ route('children.create') }}" class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Anak Pertama
                </a>
            </div>
            @endif

            <!-- Catatan Tumbuh Kembang Terbaru -->
            @if(isset($recentRecords) && $recentRecords->count() > 0)
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">📈 Catatan Terbaru</h3>
                    {{-- <a href="{{ route('growth.index') }}" class="text-white hover:text-green-100 text-sm font-medium">
                        Lihat Semua →
                    </a> --}}
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($recentRecords->take(5) as $record)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center text-white font-bold">
                                    {{ substr($record->child->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $record->child->name }}</h4>
                                    <p class="text-sm text-gray-600">
                                        {{ $record->record_date->format('d M Y') }} • 
                                        {{ $record->age_months }} bulan
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600">TB: <span class="font-semibold text-gray-900">{{ $record->actual_height }} cm</span></p>
                                <p class="text-sm text-gray-600">BB: <span class="font-semibold text-gray-900">{{ $record->actual_weight }} kg</span></p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Tips & Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 border-2 border-yellow-200 rounded-2xl p-6">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-yellow-400 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-900">💡 Tips Monitoring</h3>
                    </div>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-start">
                            <span class="text-yellow-500 mr-2">✓</span>
                            <span>Catat tumbuh kembang secara rutin setiap bulan</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-yellow-500 mr-2">✓</span>
                            <span>Ukur tinggi dan berat pada waktu yang sama</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-yellow-500 mr-2">✓</span>
                            <span>Konsultasikan dengan dokter jika ada kekhawatiran</span>
                        </li>
                    </ul>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-purple-100 border-2 border-purple-200 rounded-2xl p-6">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-purple-400 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-900">🤖 Fitur AI</h3>
                    </div>
                    <p class="text-sm text-gray-700 mb-3">
                        Coba fitur analisa body menggunakan AI untuk estimasi tinggi, berat, dan usia dari foto
                    </p>
                    <a href="{{ route('analysis.create') }}" class="inline-block bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        Coba Sekarang
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>