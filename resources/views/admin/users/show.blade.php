<x-app-layout>
    <x-slot name="header">
        Detil Pengguna
    </x-slot>

    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.users') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            ← Kembali ke Daftar Pengguna
        </a>
    </div>

    <!-- User Information Card -->
    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-blue-50 to-white px-8 py-6 border-b border-blue-100">
            <h3 class="text-2xl font-bold text-gray-800 flex items-center">
                <svg class="w-7 h-7 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Informasi Pengguna
            </h3>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-gray-200">
                        <span class="font-semibold text-gray-600">Nama:</span>
                        <span class="text-gray-800">{{ $user->name }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-200">
                        <span class="font-semibold text-gray-600">Email:</span>
                        <span class="text-gray-800">{{ $user->email }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-200">
                        <span class="font-semibold text-gray-600">Peran:</span>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-gray-200">
                        <span class="font-semibold text-gray-600">Total Analisis:</span>
                        <span class="text-lg font-bold text-blue-600">{{ $user->body_analyses_count }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-200">
                        <span class="font-semibold text-gray-600">Total Anak:</span>
                        <span class="text-lg font-bold text-green-600">{{ $user->children_count }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-200">
                        <span class="font-semibold text-gray-600">Total Catatan Pertumbuhan:</span>
                        <span class="text-lg font-bold text-purple-600">{{ $user->growth_records_count }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-200">
                        <span class="font-semibold text-gray-600">Terdaftar Sejak:</span>
                        <span class="text-gray-800">{{ $user->created_at->format('d F Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User's Analyses -->
    @if($user->bodyAnalyses->isNotEmpty())
    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-blue-50 to-white px-8 py-6 border-b border-blue-100">
            <h3 class="text-xl font-bold text-gray-800 flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Riwayat Analisis Tubuh ({{ $user->bodyAnalyses->count() }})
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Foto</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Tinggi</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Berat</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Usia</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">BMI</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($user->bodyAnalyses as $analysis)
                    <tr class="hover:bg-blue-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <img src="{{ asset($analysis->image_path) }}"
                                 class="w-12 h-12 object-cover rounded-lg border-2 border-blue-200"
                                 alt="Foto Analisis">
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $analysis->estimated_height }} cm</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $analysis->estimated_weight }} kg</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $analysis->estimated_age }} thn</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $analysis->bmi }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $analysis->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- User's Children -->
    @if($user->children->isNotEmpty())
    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-50 to-white px-8 py-6 border-b border-blue-100">
            <h3 class="text-xl font-bold text-gray-800 flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Daftar Anak ({{ $user->children->count() }})
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Foto</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Nama</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Jenis Kelamin</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Tgl Lahir</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($user->children as $child)
                    <tr class="hover:bg-blue-50/50 transition-colors">
                        <td class="px-6 py-4">
                            @if($child->photo)
                                <img src="{{ asset($child->photo) }}"
                                     class="w-12 h-12 object-cover rounded-lg border-2 border-blue-200"
                                     alt="{{ $child->name }}">
                            @else
                                <span class="text-xs text-gray-400">Tidak ada foto</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $child->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $child->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $child->birth_date->format('d F Y') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $child->growthRecords->count() }} catatan</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</x-app-layout>
