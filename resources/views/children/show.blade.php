<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-pink-100 rounded-lg text-pink-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-lg text-gray-800 leading-tight">
                    Detail Anak
                </h2>
                @if(isset($child))
                <p class="text-xs text-gray-500">{{ $child->name }}</p>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="">
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

        <!-- Child Profile Card -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl shadow-2xl p-8 mb-8 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full -mr-48 -mt-48"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full -ml-32 -mb-32"></div>
            
            <div class="relative z-10 flex items-start justify-between">
                <div class="flex items-center space-x-6">
                    <div class="w-32 h-32 bg-white rounded-2xl overflow-hidden shadow-2xl">
                        @if($child->photo)
                            <img src="{{ asset($child->photo) }}" class="w-full h-full object-cover" alt="{{ $child->name }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-blue-100">
                                <svg class="w-16 h-16 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold mb-2">{{ $child->name }}</h2>
                        <div class="space-y-2">
                            <p class="flex items-center">
                                <span class="text-2xl mr-2">{{ $child->gender === 'male' ? '👦' : '👧' }}</span>
                                <span class="text-lg">{{ $child->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</span>
                            </p>
                            <p class="text-blue-100">
                                📅 {{ $child->birth_date->diff(now())->format('%y Tahun %m Bulan') }} 
                                ({{ $child->birth_date->format('d M Y') }})
                            </p>
                            <p class="text-blue-100">📍 {{ $child->birth_place }}</p>
                            @if($child->blood_type)
                                <p class="text-blue-100">🩸 Golongan Darah: {{ $child->blood_type }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="text-right space-y-2">
                    <a href="{{ route('children.edit', $child->id) }}" 
                       class="inline-block px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg transition-colors">
                        ✏️ Edit Data
                    </a>
                    <a href="{{ route('growth.create', $child->id) }}" 
                       class="block px-6 py-3 bg-white text-blue-600 font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                        + Tambah Data Pertumbuhan
                    </a>
                    <a href="{{ route('children.index') }}" 
                       class="block px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg transition-colors text-sm">
                        ← Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>

        <!-- Birth Data & Latest Record -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-green-200">
                <h4 class="text-sm text-gray-600 mb-2">Berat Lahir</h4>
                <p class="text-3xl font-bold text-green-600">{{ $child->birth_weight }} <span class="text-lg">kg</span></p>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-purple-200">
                <h4 class="text-sm text-gray-600 mb-2">Tinggi Lahir</h4>
                <p class="text-3xl font-bold text-purple-600">{{ $child->birth_height }} <span class="text-lg">cm</span></p>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-blue-200">
                <h4 class="text-sm text-gray-600 mb-2">Jenis Kelahiran</h4>
                <p class="text-xl font-bold text-blue-600">{{ $child->birth_type === 'normal' ? '✨ Normal' : '🏥 Caesar' }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-orange-200">
                <h4 class="text-sm text-gray-600 mb-2">Total Record</h4>
                <p class="text-3xl font-bold text-orange-600">{{ $child->growthRecords->count() }}</p>
            </div>
        </div>

        <!-- Health & Allergy Notes -->
        @if($child->health_notes || $child->allergy_notes)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            @if($child->health_notes)
            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-yellow-200">
                <h4 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Catatan Kesehatan
                </h4>
                <p class="text-gray-700">{{ $child->health_notes }}</p>
            </div>
            @endif

            @if($child->allergy_notes)
            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-red-200">
                <h4 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Catatan Alergi
                </h4>
                <p class="text-gray-700">{{ $child->allergy_notes }}</p>
            </div>
            @endif
        </div>
        @endif
        <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl shadow-2xl p-1 mb-8 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
            
            <div class="bg-indigo-900/40 backdrop-blur-sm rounded-xl p-6 relative z-10">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                    <div class="flex items-center">
                        <div class="bg-white/20 p-3 rounded-lg mr-4">
                            <svg class="w-8 h-8 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-2xl font-bold text-white">Resume Dokter AI</h3>
                                <span class="bg-indigo-500/50 text-xs px-2 py-1 rounded-full border border-indigo-400/50">Auto-Update</span>
                            </div>
                            @if($child->summary_last_updated)
                                <p class="text-indigo-200 text-sm mt-1">
                                    Diperbarui otomatis: {{ \Carbon\Carbon::parse($child->summary_last_updated)->diffForHumans() }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                @if($child->ai_summary)
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="lg:col-span-2 bg-white/10 rounded-xl p-5 border border-white/10">
                            <h4 class="font-bold text-indigo-200 mb-3 flex items-center text-sm uppercase tracking-wider">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                Evaluasi Pertumbuhan
                            </h4>
                            <p class="text-white leading-relaxed text-lg font-light">
                                "{{ $child->ai_summary }}"
                            </p>
                        </div>

                        <div class="bg-green-500/20 rounded-xl p-5 border border-green-400/30">
                            <h4 class="font-bold text-green-200 mb-3 flex items-center text-sm uppercase tracking-wider">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Saran Tindakan
                            </h4>
                            @php $recommendations = json_decode($child->ai_recommendations); @endphp
                            
                            @if($recommendations && is_array($recommendations))
                                <ul class="space-y-3">
                                    @foreach($recommendations as $rec)
                                        <li class="flex items-start text-white/90 text-sm">
                                            <span class="mr-2 mt-1 text-green-400">•</span>
                                            <span>{{ $rec }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-white/60 italic text-sm">Menunggu data lebih banyak...</p>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="bg-white/5 rounded-xl p-6 text-center border border-white/10 border-dashed">
                        <p class="text-indigo-200">
                            Data belum cukup untuk analisis tren. Silakan tambah data pertumbuhan pertama.
                        </p>
                    </div>
                @endif
            </div>
        </div>
        <!-- Growth Charts -->
        @if($child->growthRecords->count() > 0)
        <div class="bg-white rounded-2xl shadow-xl border border-blue-100 p-6 mb-8">
            <h4 class="font-bold text-gray-800 mb-6 flex items-center text-lg">
                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                </svg>
                Grafik Pertumbuhan Standar WHO (KMS)
            </h4>
            
            <div class="relative h-96 w-full">
                <canvas id="kmsChart"></canvas>
            </div>
            
            <div class="mt-4 flex flex-wrap justify-center gap-4 text-xs text-gray-600">
                <div class="flex items-center"><span class="w-3 h-3 bg-blue-600 mr-1 rounded-full border border-white shadow-sm"></span> Anak</div>
                <div class="flex items-center"><span class="w-3 h-3 bg-green-500 mr-1 border-t-2 border-green-700 border-dashed h-0"></span> Median</div>
                <div class="flex items-center"><span class="w-3 h-3 bg-green-300 mr-1 rounded opacity-50"></span> Normal</div>
                <div class="flex items-center"><span class="w-3 h-3 bg-yellow-300 mr-1 rounded opacity-50"></span> Gemuk/Kurus</div>
                <div class="flex items-center"><span class="w-3 h-3 bg-red-400 mr-1 rounded opacity-50"></span> Gizi Buruk</div>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Weight Chart -->
            <div class="bg-white rounded-2xl shadow-xl border border-blue-100 p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Grafik Berat Badan</h3>
                <div id="weightChart"></div>
            </div>

            <!-- Height Chart -->
            <div class="bg-white rounded-2xl shadow-xl border border-blue-100 p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Grafik Tinggi Badan</h3>
                <div id="heightChart"></div>
            </div>
        </div>
        @endif

        <!-- Growth Records Timeline -->
        <div class="bg-white rounded-2xl shadow-xl border border-blue-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-white px-8 py-6 border-b border-blue-100">
                <h3 class="text-xl font-bold text-gray-800">Riwayat Pertumbuhan</h3>
            </div>

            @if($child->growthRecords->isEmpty())
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <p class="text-gray-500 font-medium mb-4">Belum ada data pertumbuhan</p>
                    <a href="{{ route('growth.create', $child->id) }}" 
                       class="inline-block px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-xl transition-colors">
                        Tambah Data Pertama
                    </a>
                </div>
            @else
                <div class="p-6 space-y-4">
                    @foreach($child->growthRecords as $record)
                    <div class="flex items-center space-x-4 p-4 bg-gradient-to-r from-blue-50 to-white rounded-xl border-2 border-blue-100 hover:shadow-lg transition-all duration-300">
                        <img src="{{ asset($record->photo_path) }}" class="w-20 h-20 object-cover rounded-xl shadow-md" alt="Record photo">
                        
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-bold text-gray-800">{{ $record->record_date->format('d M Y') }}</span>
                                <span class="text-sm text-gray-500">{{ $record->age_months }} bulan</span>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="text-xs text-gray-500">Berat</span>
                                    <p class="font-bold text-green-600">{{ $record->actual_weight }} kg</p>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500">Tinggi</span>
                                    <p class="font-bold text-purple-600">{{ $record->actual_height }} cm</p>
                                </div>
                            </div>
                            
                            @if($record->growth_status)
                                <div class="mt-2">
                                    <span class="text-xs px-3 py-1 rounded-full bg-blue-100 text-blue-800">
                                        {{ $record->growth_status }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="flex space-x-2">
                            <a href="{{ route('growth.show', $record->id) }}" 
                               class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm transition-colors">
                                Detail
                            </a>
                            <a href="{{ route('growth.edit', $record->id) }}" 
                               class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg text-sm transition-colors">
                                Edit
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    @if($child->growthRecords->count() > 0)
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ============================================
            // A. GRAFIK KMS (CHART.JS)
            // ============================================
            const ctxKms = document.getElementById('kmsChart').getContext('2d');
            const kmsDataPoints = @json($kmsData); // Data dari controller
            const gender = "{{ $child->gender }}"; 

            // Data WHO Standards
            const whoStandards = {
                'male': [
                    {x: 0, m: 3.3, s3n: 2.1, s2n: 2.5, s2p: 4.4, s3p: 5.0},
                    {x: 6, m: 7.9, s3n: 5.7, s2n: 6.4, s2p: 9.8, s3p: 10.9},
                    {x: 12, m: 9.6, s3n: 7.0, s2n: 7.7, s2p: 12.0, s3p: 13.3},
                    {x: 24, m: 12.2, s3n: 8.8, s2n: 9.7, s2p: 15.3, s3p: 17.0},
                    {x: 36, m: 14.3, s3n: 10.0, s2n: 11.3, s2p: 18.3, s3p: 20.3},
                    {x: 48, m: 16.3, s3n: 11.3, s2n: 12.7, s2p: 21.2, s3p: 23.7},
                    {x: 60, m: 18.3, s3n: 12.5, s2n: 14.1, s2p: 24.2, s3p: 27.2}
                ],
                'female': [
                    {x: 0, m: 3.2, s3n: 2.0, s2n: 2.4, s2p: 4.2, s3p: 4.8},
                    {x: 6, m: 7.3, s3n: 5.1, s2n: 5.7, s2p: 9.3, s3p: 10.4},
                    {x: 12, m: 8.9, s3n: 6.3, s2n: 7.0, s2p: 11.5, s3p: 12.9},
                    {x: 24, m: 11.5, s3n: 8.1, s2n: 9.0, s2p: 14.8, s3p: 16.5},
                    {x: 36, m: 13.9, s3n: 9.6, s2n: 10.8, s2p: 18.1, s3p: 20.2},
                    {x: 48, m: 16.1, s3n: 10.9, s2n: 12.3, s2p: 21.5, s3p: 24.0},
                    {x: 60, m: 18.2, s3n: 12.1, s2n: 13.7, s2p: 24.9, s3p: 27.9}
                ]
            };
            const standard = whoStandards[gender];

            new Chart(ctxKms, {
                type: 'line',
                data: {
                    datasets: [
                        {
                            label: 'Anak',
                            data: kmsDataPoints,
                            borderColor: 'rgb(37, 99, 235)',
                            backgroundColor: 'white',
                            borderWidth: 3,
                            pointRadius: 6,
                            pointHoverRadius: 8,
                            pointBorderWidth: 2,
                            zIndex: 100
                        },
                        {
                            label: 'Median',
                            data: standard.map(d => ({x: d.x, y: d.m})),
                            borderColor: 'rgb(22, 163, 74)',
                            borderWidth: 2,
                            pointRadius: 0,
                            borderDash: [5, 5],
                            tension: 0.4,
                            fill: false
                        },
                        // Area Kuning (Gemuk)
                        { data: standard.map(d => ({x: d.x, y: d.s3p})), borderColor: 'transparent', backgroundColor: 'rgba(250, 204, 21, 0.4)', pointRadius: 0, tension: 0.4, fill: '-1' },
                        { data: standard.map(d => ({x: d.x, y: d.s2p})), borderColor: 'transparent', backgroundColor: 'rgba(250, 204, 21, 0.4)', pointRadius: 0, tension: 0.4, fill: '-1' },
                        // Area Hijau (Normal)
                        { data: standard.map(d => ({x: d.x, y: d.s2p})), borderColor: 'transparent', backgroundColor: 'rgba(74, 222, 128, 0.5)', pointRadius: 0, tension: 0.4, fill: false },
                        { data: standard.map(d => ({x: d.x, y: d.s2n})), borderColor: 'transparent', backgroundColor: 'rgba(74, 222, 128, 0.5)', pointRadius: 0, tension: 0.4, fill: '-1' },
                        // Area Kuning (Kurus)
                        { data: standard.map(d => ({x: d.x, y: d.s3n})), borderColor: 'transparent', backgroundColor: 'rgba(250, 204, 21, 0.4)', pointRadius: 0, tension: 0.4, fill: '-1' },
                        // Area Merah (Buruk)
                        { data: standard.map(d => ({x: d.x, y: 0})), borderColor: 'transparent', backgroundColor: 'rgba(248, 113, 113, 0.5)', pointRadius: 0, tension: 0.4, fill: '-1' }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: { type: 'linear', min: 0, max: 60, title: {display: true, text: 'Usia (Bulan)'}, ticks: { stepSize: 6 } },
                        y: { title: {display: true, text: 'Berat (kg)'}, min: 0 }
                    },
                    plugins: {
                        legend: { display: false }, // Hide legend bawaan, pakai custom legend di HTML
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label ? context.dataset.label + ': ' + context.parsed.y + ' kg' : '';
                                }
                            }
                        }
                    }
                }
            });

            // ============================================
            // B. GRAFIK APEXCHARTS (YANG SUDAH ADA)
            // ============================================
            const chartLabels = {!! json_encode($chartData['labels']) !!};
            const chartWeights = {!! json_encode($chartData['weight']) !!};
            const chartHeights = {!! json_encode($chartData['height']) !!};

            // 1. Weight Chart
            const minWeight = Math.min(...chartWeights);
            const maxWeight = Math.max(...chartWeights);
            const weightPadding = Math.max((maxWeight - minWeight) * 0.2, 1);
            
            new ApexCharts(document.querySelector("#weightChart"), {
                series: [{ name: 'Berat Badan', data: chartWeights }],
                chart: { type: 'line', height: 300, toolbar: { show: false } },
                stroke: { curve: 'smooth', width: 3, colors: ['#10B981'] },
                markers: { size: 6, colors: ['#FFFFFF'], strokeColors: ['#10B981'], strokeWidth: 3 },
                xaxis: { categories: chartLabels },
                yaxis: { 
                    min: Math.floor(minWeight - weightPadding), 
                    max: Math.ceil(maxWeight + weightPadding),
                    labels: { formatter: (val) => val.toFixed(1) + ' kg' }
                },
                colors: ['#10B981']
            }).render();

            // 2. Height Chart
            const minHeight = Math.min(...chartHeights);
            const maxHeight = Math.max(...chartHeights);
            const heightPadding = Math.max((maxHeight - minHeight) * 0.15, 3);

            new ApexCharts(document.querySelector("#heightChart"), {
                series: [{ name: 'Tinggi Badan', data: chartHeights }],
                chart: { type: 'line', height: 300, toolbar: { show: false } },
                stroke: { curve: 'smooth', width: 3, colors: ['#8B5CF6'] },
                markers: { size: 6, colors: ['#FFFFFF'], strokeColors: ['#8B5CF6'], strokeWidth: 3 },
                xaxis: { categories: chartLabels },
                yaxis: { 
                    min: Math.floor(minHeight - heightPadding), 
                    max: Math.ceil(maxHeight + heightPadding),
                    labels: { formatter: (val) => val.toFixed(0) + ' cm' }
                },
                colors: ['#8B5CF6']
            }).render();
        });
    </script>
    @endif

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