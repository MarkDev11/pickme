<x-app-layout>
    <x-slot name="header">
        Detil Anak
    </x-slot>

    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.children') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            ← Kembali ke Daftar Anak
        </a>
    </div>

    <!-- Child Information Card -->
    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-blue-50 to-white px-8 py-6 border-b border-blue-100">
            <h3 class="text-2xl font-bold text-gray-800 flex items-center">
                <svg class="w-7 h-7 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Informasi Anak
            </h3>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Photo -->
                <div class="lg:col-span-1">
                    <div class="sticky top-8">
                        @if($child->photo)
                            <img src="{{ asset($child->photo) }}" 
                                 class="w-full rounded-2xl shadow-lg border-4 border-blue-100"
                                 alt="{{ $child->name }}">
                        @else
                            <div class="w-full aspect-square bg-gradient-to-br from-blue-200 to-blue-400 rounded-2xl flex items-center justify-center shadow-lg">
                                <svg class="w-32 h-32 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        @endif

                        <!-- Quick Stats -->
                        <div class="mt-6 bg-gradient-to-br from-blue-50 to-white p-6 rounded-xl border-2 border-blue-100">
                            <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                Statistik Cepat
                            </h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Total Catatan:</span>
                                    <span class="text-lg font-bold text-blue-600">{{ $child->growth_records_count }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Usia:</span>
                                    <span class="text-lg font-bold text-green-600">{{ $child->age_text }}</span>
                                </div>
                                @if($child->latestGrowth)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Berat Terakhir:</span>
                                    <span class="text-lg font-bold text-purple-600">{{ $child->latestGrowth->actual_weight }} kg</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Tinggi Terakhir:</span>
                                    <span class="text-lg font-bold text-orange-600">{{ $child->latestGrowth->actual_height }} cm</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Details -->
                <div class="lg:col-span-2">
                    <div class="space-y-6">
                        <!-- Basic Information -->
                        <div class="bg-gradient-to-br from-blue-50 to-white p-6 rounded-xl border-2 border-blue-100">
                            <h4 class="font-bold text-lg text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Informasi Dasar
                                <div>
                                    <label class="text-xs font-semibold text-gray-500 uppercase">Nama Lengkap</label>
                                    <p class="text-sm font-medium text-gray-900 mt-1">{{ $child->name }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-gray-500 uppercase">Jenis Kelamin</label>
                                    <p class="mt-1">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $child->gender === 'Laki-laki' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }}">
                                            {{ $child->gender }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-gray-500 uppercase">Tgl Lahir</label>
                                    <p class="text-sm font-medium text-gray-900 mt-1">{{ $child->birth_date->format('d F Y') }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-gray-500 uppercase">Tempat Lahir</label>
                                    <p class="text-sm font-medium text-gray-900 mt-1">{{ $child->birth_place ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-gray-500 uppercase">Gol Darah</label>
                                    <p class="text-sm font-medium text-gray-900 mt-1">{{ $child->blood_type ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-gray-500 uppercase">Jenis Kelahiran</label>
                                    <p class="text-sm font-medium text-gray-900 mt-1">{{ $child->birth_type ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Kelahiran -->
                        <div class="bg-gradient-to-br from-green-50 to-white p-6 rounded-xl border-2 border-green-100">
                            <h4 class="font-bold text-lg text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Informasi Kelahiran
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs font-semibold text-gray-500 uppercase">Berat Lahir</label>
                                    <p class="text-sm font-medium text-gray-900 mt-1">{{ $child->birth_weight ?? '-' }} kg</p>
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-gray-500 uppercase">Tinggi Lahir</label>
                                    <p class="text-sm font-medium text-gray-900 mt-1">{{ $child->birth_height ?? '-' }} cm</p>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Orang Tua -->
                        <div class="bg-gradient-to-br from-purple-50 to-white p-6 rounded-xl border-2 border-purple-100">
                            <h4 class="font-bold text-lg text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                Informasi Orang Tua
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs font-semibold text-gray-500 uppercase">Nama Orang Tua</label>
                                    <p class="text-sm font-medium text-gray-900 mt-1">{{ $child->user->name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-gray-500 uppercase">Email Orang Tua</label>
                                    <p class="text-sm font-medium text-gray-900 mt-1">{{ $child->user->email ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Health Notes -->
                        @if($child->health_notes || $child->allergy_notes)
                        <div class="bg-gradient-to-br from-orange-50 to-white p-6 rounded-xl border-2 border-orange-100">
                            <h4 class="font-bold text-lg text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                Informasi Kesehatan
                            </h4>
                            @if($child->health_notes)
                            <div class="mb-4">
                                <label class="text-xs font-semibold text-gray-500 uppercase">Catatan Kesehatan</label>
                                <p class="text-sm text-gray-700 mt-1">{{ $child->health_notes }}</p>
                            </div>
                            @endif
                            @if($child->allergy_notes)
                            <div>
                                <label class="text-xs font-semibold text-gray-500 uppercase">Catatan Alergi</label>
                                <p class="text-sm text-gray-700 mt-1">{{ $child->allergy_notes }}</p>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Growth Records -->
    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-50 to-white px-8 py-6 border-b border-blue-100">
            <h3 class="text-2xl font-bold text-gray-800 flex items-center justify-between">
                <span class="flex items-center">
                    <svg class="w-7 h-7 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Riwayat Catatan Pertumbuhan
                </span>
                <span class="text-sm font-normal text-gray-600">{{ $child->growth_records_count }} total catatan</span>
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Usia</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Berat</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Tinggi</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Lingkar Kpl</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Foto</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($child->growthRecords as $record)
                    <tr class="hover:bg-blue-50/50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                            {{ $record->record_date->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $record->age_months }} bulan
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                {{ $record->actual_weight }} kg
                            </span>
                            @if($record->weight_difference)
                                <span class="ml-2 text-xs {{ $record->weight_difference > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $record->weight_difference > 0 ? '+' : '' }}{{ $record->weight_difference }} kg
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                {{ $record->actual_height }} cm
                            </span>
                            @if($record->height_difference)
                                <span class="ml-2 text-xs {{ $record->height_difference > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $record->height_difference > 0 ? '+' : '' }}{{ $record->height_difference }} cm
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $record->head_circumference ?? '-' }} cm
                        </td>
                        <td class="px-6 py-4">
                            @if($record->growth_status)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-{{ $record->status_color }}-100 text-{{ $record->status_color }}-800">
                                    {{ Str::limit($record->growth_status, 20) }}
                                </span>
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($record->photo_path)
                                <img src="{{ asset($record->photo_path) }}" 
                                     class="w-12 h-12 object-cover rounded-lg border-2 border-blue-200 cursor-pointer hover:scale-110 transition-transform"
                                     onclick="window.open('{{ asset($record->photo_path) }}', '_blank')"
                                     alt="Foto Pertumbuhan">
                            @else
                                <span class="text-xs text-gray-400">Tidak ada foto</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <p class="text-lg font-semibold">Belum ada catatan pertumbuhan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>