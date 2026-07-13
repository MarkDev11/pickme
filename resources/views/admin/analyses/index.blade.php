<x-app-layout>
    <x-slot name="header">
        Manajemen Analisis Tubuh
    </x-slot>

    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-50 to-white px-8 py-6 border-b border-blue-100">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">Semua Analisis Tubuh</h3>
                        <p class="text-sm text-gray-600">Pantau semua hasil analisis tubuh AI</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <!-- Export Button -->
                    <a href="{{ route('admin.export.analyses') }}" 
                       class="inline-flex items-center justify-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition-colors shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Ekspor CSV
                    </a>
                </div>
            </div>

            <!-- Filter Form -->
            <form method="GET" class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Search -->
                <div>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Cari nama pengguna..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Buttons -->
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors">
                        Cari
                    </button>
                    <a href="{{ route('admin.analyses') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl transition-colors">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Pengguna</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Foto</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Tinggi</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Berat</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Usia</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">BMI</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Kategori</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($analyses as $analysis)
                    <tr class="hover:bg-blue-50/50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-600">#{{ $analysis->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white font-bold shadow-md">
                                    {{ substr($analysis->user->name ?? 'U', 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-gray-900">{{ $analysis->user->name ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-500">{{ $analysis->user->email ?? '' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <img src="{{ asset($analysis->image_path) }}" 
                                 class="w-16 h-16 object-cover rounded-xl border-2 border-blue-200 shadow-md cursor-pointer hover:scale-110 transition-transform"
                                 onclick="window.open('{{ asset($analysis->image_path) }}', '_blank')"
                                 alt="Foto Analisis">
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                {{ $analysis->estimated_height }} cm
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                {{ $analysis->estimated_weight }} kg
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">
                                {{ $analysis->estimated_age }} thn
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-{{ $analysis->bmi_color }}-100 text-{{ $analysis->bmi_color }}-800">
                                {{ $analysis->bmi }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold 
                                {{ $analysis->bmi_category === 'Normal' ? 'bg-green-100 text-green-700' : 
                                   ($analysis->bmi_category === 'Underweight' ? 'bg-blue-100 text-blue-700' : 
                                   ($analysis->bmi_category === 'Overweight' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700')) }}">
                                {{ $analysis->bmi_category }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $analysis->created_at->format('M d, Y') }}
                            <p class="text-xs text-gray-500">{{ $analysis->created_at->format('H:i') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('analysis.show', $analysis->id) }}" 
                                   class="p-2 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg transition-colors"
                                   title="Lihat Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                <form action="{{ route('admin.analyses.destroy', $analysis->id) }}" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('Yakin ingin menghapus analisis ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors"
                                            title="Hapus Analisis">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-6 py-12 text-center text-gray-500">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="text-lg font-semibold">Tidak ada analisis</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($analyses->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $analyses->links() }}
        </div>
        @endif
    </div>

    <!-- BMI Statistics Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
        <div class="bg-gradient-to-br from-blue-50 to-white p-6 rounded-xl border-2 border-blue-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Kurus</p>
                    <p class="text-2xl font-bold text-blue-600 mt-1">
                        {{ $analyses->filter(fn($a) => $a->bmi_category === 'Underweight')->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-50 to-white p-6 rounded-xl border-2 border-green-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Normal</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">
                        {{ $analyses->filter(fn($a) => $a->bmi_category === 'Normal')->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-yellow-50 to-white p-6 rounded-xl border-2 border-yellow-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Gemuk</p>
                    <p class="text-2xl font-bold text-yellow-600 mt-1">
                        {{ $analyses->filter(fn($a) => $a->bmi_category === 'Overweight')->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-red-50 to-white p-6 rounded-xl border-2 border-red-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Obesitas</p>
                    <p class="text-2xl font-bold text-red-600 mt-1">
                        {{ $analyses->filter(fn($a) => $a->bmi_category === 'Obese')->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>