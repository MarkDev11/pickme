<x-app-layout>
    <x-slot name="header">
        Growth Records Management
    </x-slot>

    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-50 to-white px-8 py-6 border-b border-blue-100">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">All Growth Records</h3>
                        <p class="text-sm text-gray-600">Monitor all children growth tracking data</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <!-- Export Button -->
                    <a href="{{ route('admin.export.growth') }}" 
                       class="inline-flex items-center justify-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition-colors shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export CSV
                    </a>
                </div>
            </div>

            <!-- Filter Form -->
            <form method="GET" class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search -->
                <div>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Search by child name..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Status Filter -->
                <div>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Status</option>
                        <option value="Normal" {{ request('status') == 'Normal' ? 'selected' : '' }}>Normal</option>
                        <option value="Perlu Perhatian" {{ request('status') == 'Perlu Perhatian' ? 'selected' : '' }}>Perlu Perhatian</option>
                        <option value="Stunting" {{ request('status') == 'Stunting' ? 'selected' : '' }}>Stunting</option>
                        <option value="Obesitas" {{ request('status') == 'Obesitas' ? 'selected' : '' }}>Obesitas</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors">
                        Filter
                    </button>
                    <a href="{{ route('admin.growth-records') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl transition-colors">
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
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Photo</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Child Name</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Parent</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Record Date</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Age</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Weight</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Height</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($records as $record)
                    <tr class="hover:bg-blue-50/50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-600">#{{ $record->id }}</td>
                        <td class="px-6 py-4">
                            @if($record->photo_path)
                                <img src="{{ asset($record->photo_path) }}" 
                                     class="w-12 h-12 object-cover rounded-xl border-2 border-blue-200 shadow-md cursor-pointer hover:scale-110 transition-transform"
                                     onclick="window.open('{{ asset($record->photo_path) }}', '_blank')"
                                     alt="Growth Photo">
                            @else
                                <div class="w-12 h-12 bg-gradient-to-br from-gray-200 to-gray-300 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($record->child->photo)
                                    <img src="{{ asset($record->child->photo) }}" 
                                         class="w-8 h-8 rounded-lg mr-2 border border-blue-200"
                                         alt="{{ $record->child->name }}">
                                @else
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg mr-2 flex items-center justify-center">
                                        <span class="text-xs font-bold text-blue-600">{{ substr($record->child->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $record->child->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $record->child->gender }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-gray-700">{{ $record->user->name ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-500">{{ $record->user->email ?? '' }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $record->record_date->format('M d, Y') }}
                            <p class="text-xs text-gray-500">{{ $record->record_date->diffForHumans() }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                {{ $record->age_months }} months
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                {{ $record->actual_weight }} kg
                            </span>
                            @if($record->weight_difference)
                                <p class="text-xs mt-1 {{ $record->weight_difference > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $record->weight_difference > 0 ? '+' : '' }}{{ $record->weight_difference }} kg
                                </p>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                {{ $record->actual_height }} cm
                            </span>
                            @if($record->height_difference)
                                <p class="text-xs mt-1 {{ $record->height_difference > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $record->height_difference > 0 ? '+' : '' }}{{ $record->height_difference }} cm
                                </p>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($record->growth_status)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-{{ $record->status_color }}-100 text-{{ $record->status_color }}-800">
                                    {{ Str::limit($record->growth_status, 25) }}
                                </span>
                                @if($record->recommendations)
                                    <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ Str::limit($record->recommendations, 50) }}</p>
                                @endif
                            @else
                                <span class="text-xs text-gray-400">No status</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center text-gray-500">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="text-lg font-semibold">No growth records found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($records->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $records->links() }}
        </div>
        @endif
    </div>

    <!-- Statistics Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
        <div class="bg-gradient-to-br from-blue-50 to-white p-6 rounded-xl border-2 border-blue-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Total Records</p>
                    <p class="text-2xl font-bold text-blue-600 mt-1">{{ $records->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-50 to-white p-6 rounded-xl border-2 border-green-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Normal Growth</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">
                        {{ $records->where('growth_status', 'like', '%normal%')->count() }}
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
                    <p class="text-sm text-gray-600 font-medium">Need Attention</p>
                    <p class="text-2xl font-bold text-yellow-600 mt-1">
                        {{ $records->where('growth_status', 'like', '%perlu perhatian%')->count() }}
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
                    <p class="text-sm text-gray-600 font-medium">Critical</p>
                    <p class="text-2xl font-bold text-red-600 mt-1">
                        {{ $records->where('growth_status', 'like', '%stunting%')->count() + $records->where('growth_status', 'like', '%obesitas%')->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>