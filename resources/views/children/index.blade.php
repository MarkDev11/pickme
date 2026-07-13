<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-purple-100 rounded-lg text-purple-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <h2 class="font-bold text-lg text-gray-800 leading-tight">
                Monitoring Tumbuh Kembang Anak
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

        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl shadow-xl p-8 mb-8 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full -ml-24 -mb-24"></div>
            
            <div class="relative z-10">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold mb-1">Selamat Datang, {{ auth()->user()->name }}!</h2>
                        <p class="text-blue-100">Pantau perkembangan tumbuh kembang buah hati Anda dengan mudah</p>
                    </div>
                </div>
            </div>
        </div>

        @if($children->isEmpty())
            <!-- Empty State -->
            <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 p-12 text-center">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Data Anak</h3>
                    <p class="text-gray-600 mb-6">Mulai pantau tumbuh kembang buah hati Anda dengan menambahkan data anak terlebih dahulu.</p>
                    <a href="{{ route('children.create') }}" 
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Tambah Data Anak
                    </a>
                </div>
            </div>
        @else
            <!-- Action Button -->
            <div class="mb-6 flex justify-between items-center">
                <h3 class="text-2xl font-bold text-gray-800">Daftar Anak</h3>
                <a href="{{ route('children.create') }}" 
                   class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    <span>Tambah Anak</span>
                </a>
            </div>

            <!-- Children Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($children as $child)
                <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 overflow-hidden transform hover:scale-105 hover:shadow-2xl transition-all duration-300">
                    <!-- Child Photo -->
                    <div class="relative h-48 bg-gradient-to-br from-blue-100 to-blue-200">
                        @if($child->photo)
                            <img src="{{ asset($child->photo) }}" alt="{{ $child->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-24 h-24 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Gender Badge -->
                        <div class="absolute top-3 right-3">
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $child->gender === 'male' ? 'bg-blue-500 text-white' : 'bg-pink-500 text-white' }} shadow-lg">
                                {{ $child->gender === 'male' ? '👦 Laki-laki' : '👧 Perempuan' }}
                            </span>
                        </div>

                        <!-- Records Count Badge -->
                        <div class="absolute top-3 left-3">
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-white text-blue-600 shadow-lg">
                                📊 {{ $child->growth_records_count ?? 0 }} Catatan
                            </span>
                        </div>
                    </div>

                    <!-- Child Info -->
                    <div class="p-6">
                        <h4 class="text-xl font-bold text-gray-800 mb-2">{{ $child->name }}</h4>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>{{ $child->birth_date->diff(now())->format('%y Tahun %m Bulan') }}</span>
                            </div>

                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>{{ $child->birth_place }}</span>
                            </div>

                            @if($child->latestGrowth)
                            <div class="mt-3 p-3 bg-gradient-to-r from-green-50 to-white rounded-xl border border-green-200">
                                <p class="text-xs text-gray-600 mb-1">Data Terakhir:</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-semibold text-gray-800">BB: {{ $child->latestGrowth->actual_weight }} kg</span>
                                    <span class="text-sm font-semibold text-gray-800">TB: {{ $child->latestGrowth->actual_height }} cm</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">{{ $child->latestGrowth->record_date->format('d M Y') }}</p>
                            </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <a href="{{ route('children.show', $child->id) }}" 
                               class="flex-1 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-center font-semibold rounded-lg transition-colors text-sm">
                                Lihat Detail
                            </a>
                            <a href="{{ route('growth.create', $child->id) }}" 
                               class="flex-1 px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-center font-semibold rounded-lg transition-colors text-sm">
                                + Tambah Catatan
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <div class="bg-gradient-to-br from-blue-50 to-white rounded-2xl p-6 border-2 border-blue-100">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-800">Rutin Pantau</h4>
                </div>
                <p class="text-sm text-gray-600">Lakukan monitoring setiap bulan untuk hasil terbaik</p>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-white rounded-2xl p-6 border-2 border-green-100">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-800">Foto Berkualitas</h4>
                </div>
                <p class="text-sm text-gray-600">Gunakan foto full body dengan pencahayaan baik</p>
            </div>

            <div class="bg-gradient-to-br from-purple-50 to-white rounded-2xl p-6 border-2 border-purple-100">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-800">Data Akurat</h4>
                </div>
                <p class="text-sm text-gray-600">Koreksi hasil AI jika diperlukan untuk akurasi data</p>
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
        // Auto-hide success/error messages after 5 seconds
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