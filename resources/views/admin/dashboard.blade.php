<x-app-layout>
    <x-slot name="header">
        Dashboard Admin
    </x-slot>

    <!-- Admin Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <span class="text-3xl font-bold">{{ $totalUsers }}</span>
            </div>
            <p class="text-blue-100 font-medium">Total Pengguna</p>
            <a href="{{ route('admin.users') }}" class="text-xs text-blue-200 hover:text-white mt-2 inline-block">Lihat semua →</a>
        </div>

        <!-- Total Children -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-3xl font-bold">{{ $totalChildren }}</span>
            </div>
            <p class="text-green-100 font-medium">Total Anak</p>
            <a href="{{ route('admin.children') }}" class="text-xs text-green-200 hover:text-white mt-2 inline-block">Lihat semua →</a>
        </div>

        <!-- Total Growth Records -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <span class="text-3xl font-bold">{{ $totalGrowthRecords }}</span>
            </div>
            <p class="text-purple-100 font-medium">Catatan Pertumbuhan</p>
            <a href="{{ route('admin.growth-records') }}" class="text-xs text-purple-200 hover:text-white mt-2 inline-block">Lihat semua →</a>
        </div>

        <!-- Total Analyses -->
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <span class="text-3xl font-bold">{{ $totalAnalyses }}</span>
            </div>
            <p class="text-orange-100 font-medium">Analisis Tubuh</p>
            <a href="{{ route('admin.analyses') }}" class="text-xs text-orange-200 hover:text-white mt-2 inline-block">Lihat semua →</a>
        </div>
    </div>

    <!-- Secondary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Today's Analyses -->
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Analisis Hari Ini</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $todayAnalyses }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Users (30 days) -->
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Pengguna Aktif (30h)</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $activeUsers }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-green-100 to-green-200 rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Status Sistem</p>
                    <div class="flex items-center gap-2 mt-2">
                        <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                        <p class="text-xl font-bold text-gray-800">Daring</p>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">CPU: {{ $systemLoad['cpu_1min'] }}%</p>
                </div>
                <a href="{{ route('admin.system-status') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                    Detail
                </a>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Analyses Chart -->
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-white px-6 py-4 border-b border-blue-100">
                <h3 class="text-lg font-bold text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Analisis (7 Hari)
                </h3>
            </div>
            <div class="p-6">
                <canvas id="analysesChart" height="180"></canvas>
            </div>
        </div>

        <!-- User Growth Chart -->
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-white px-6 py-4 border-b border-blue-100">
                <h3 class="text-lg font-bold text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    Pendaftaran Pengguna
                </h3>
            </div>
            <div class="p-6">
                <canvas id="usersChart" height="180"></canvas>
            </div>
        </div>

        <!-- Growth Records Chart -->
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-white px-6 py-4 border-b border-blue-100">
                <h3 class="text-lg font-bold text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Catatan Pertumbuhan
                </h3>
            </div>
            <div class="p-6">
                <canvas id="growthChart" height="180"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activity and Users -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Recent Activity Logs -->
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-white px-6 py-4 border-b border-blue-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Aktivitas Terbaru
                </h3>
                <a href="{{ route('admin.activity-logs') }}" class="text-sm text-blue-600 hover:text-blue-700">Lihat semua →</a>
            </div>
            <div class="overflow-y-auto max-h-96">
                <div class="divide-y divide-gray-200">
                    @forelse($recentLogs as $log)
                    <div class="px-6 py-3 hover:bg-blue-50/50 transition-colors">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $log->user->name ?? 'Sistem' }}
                                </p>
                                <p class="text-xs text-gray-600">{{ $log->description }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $log->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ 
                                str_contains($log->action, 'delete') ? 'bg-red-100 text-red-700' : 
                                (str_contains($log->action, 'create') ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700') 
                            }}">
                                {{ str_replace('_', ' ', $log->action) }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        Belum ada aktivitas
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-white px-6 py-4 border-b border-blue-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Pengguna Terbaru
                </h3>
                <a href="{{ route('admin.users') }}" class="text-sm text-blue-600 hover:text-blue-700">Lihat semua →</a>
            </div>
            <div class="overflow-y-auto max-h-96">
                <div class="divide-y divide-gray-200">
                    @forelse($users as $user)
                    <div class="px-6 py-3 hover:bg-blue-50/50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center flex-1">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white font-bold shadow-md">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 text-xs text-gray-600">
                                <div class="text-center">
                                    <p class="font-semibold text-blue-600">{{ $user->children_count }}</p>
                                    <p>Anak</p>
                                </div>
                                <div class="text-center">
                                    <p class="font-semibold text-green-600">{{ $user->growth_records_count }}</p>
                                    <p>Catatan</p>
                                </div>
                                <span class="px-2 py-1 rounded-full {{ $user->role === 'admin' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $user->role }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        Belum ada pengguna
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Analyses Table -->
    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-50 to-white px-6 py-4 border-b border-blue-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
                Analisis Tubuh Terbaru
            </h3>
            <a href="{{ route('admin.analyses') }}" class="text-sm text-blue-600 hover:text-blue-700">Lihat semua →</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Pengguna</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Foto</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Tinggi</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Berat</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">BMI</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($recentAnalyses as $analysis)
                    <tr class="hover:bg-blue-50/50 transition-colors">
                        <td class="px-6 py-3 text-sm font-medium text-gray-900">
                            {{ $analysis->user->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-3">
                            <img src="{{ asset($analysis->image_path) }}" 
                                 class="w-12 h-12 object-cover rounded-lg border-2 border-blue-200"
                                 alt="Analisis">
                        </td>
                        <td class="px-6 py-3">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                {{ $analysis->estimated_height }} cm
                            </span>
                        </td>
                        <td class="px-6 py-3">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                {{ $analysis->estimated_weight }} kg
                            </span>
                        </td>
                        <td class="px-6 py-3">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-{{ $analysis->bmi_color }}-100 text-{{ $analysis->bmi_color }}-800">
                                {{ $analysis->bmi }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-600">
                            {{ $analysis->created_at->format('M d, H:i') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            Belum ada analisis
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Analyses Chart
        const analysesCtx = document.getElementById('analysesChart').getContext('2d');
        new Chart(analysesCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Analisis',
                    data: {!! json_encode($chartData) !!},
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Users Chart
        const usersCtx = document.getElementById('usersChart').getContext('2d');
        new Chart(usersCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($userChartLabels) !!},
                datasets: [{
                    label: 'Pengguna Baru',
                    data: {!! json_encode($userChartData) !!},
                    backgroundColor: 'rgba(34, 197, 94, 0.8)',
                    borderColor: 'rgb(34, 197, 94)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Growth Records Chart
        const growthCtx = document.getElementById('growthChart').getContext('2d');
        new Chart(growthCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($growthChartLabels) !!},
                datasets: [{
                    label: 'Catatan Pertumbuhan',
                    data: {!! json_encode($growthChartData) !!},
                    backgroundColor: 'rgba(168, 85, 247, 0.8)',
                    borderColor: 'rgb(168, 85, 247)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</x-app-layout>