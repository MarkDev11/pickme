<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOA - Sistem Monitoring Tumbuh Kembang Anak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes blob {
            0%, 100% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        .animate-slideInLeft {
            animation: slideInLeft 0.8s ease-out;
        }
        .animate-slideInRight {
            animation: slideInRight 0.8s ease-out;
        }
        .animate-fadeIn {
            animation: fadeIn 0.6s ease-out;
        }
    </style>
</head>
<body class="bg-white overflow-x-hidden">
    
    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-white/80 backdrop-blur-lg border-b border-gray-200 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">
                        MOA
                    </span>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#fitur" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Fitur</a>
                    <a href="#cara-kerja" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Cara Kerja</a>
                    <a href="#keunggulan" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Keunggulan</a>
                    
                    @auth
                        <a href="{{ route('dashboard') }}" 
                           class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="text-gray-700 hover:text-blue-600 font-medium transition-colors">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" 
                           class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                            Daftar Gratis
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobileMenuBtn" class="md:hidden p-2 rounded-lg hover:bg-gray-100">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden bg-white border-t border-gray-200">
            <div class="px-4 py-4 space-y-3">
                <a href="#fitur" class="block py-2 text-gray-700 hover:text-blue-600 font-medium">Fitur</a>
                <a href="#cara-kerja" class="block py-2 text-gray-700 hover:text-blue-600 font-medium">Cara Kerja</a>
                <a href="#keunggulan" class="block py-2 text-gray-700 hover:text-blue-600 font-medium">Keunggulan</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="block py-2 text-blue-600 font-semibold">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="block py-2 text-gray-700 hover:text-blue-600 font-medium">Masuk</a>
                    <a href="{{ route('register') }}" class="block py-2 text-white bg-blue-600 text-center rounded-lg font-semibold">Daftar Gratis</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 overflow-hidden bg-gradient-to-br from-blue-50 via-white to-blue-100">
        <!-- Animated Background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-10 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob"></div>
            <div class="absolute top-40 right-10 w-96 h-96 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-1/2 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-4000"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="animate-slideInLeft">
                    <div class="inline-flex items-center px-4 py-2 bg-blue-100 rounded-full mb-6">
                        <svg class="w-4 h-4 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-semibold text-blue-600">Platform Terpercaya</span>
                    </div>
                    
                    <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                        Pantau Tumbuh Kembang
                        <span class="bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">
                            Buah Hati
                        </span>
                    </h1>
                    
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        Sistem monitoring tumbuh kembang anak yang mudah, praktis, dan dilengkapi dengan fitur analisa AI untuk membantu Anda memantau pertumbuhan anak dengan lebih baik.
                    </p>
                    
                    <div class="flex flex-wrap gap-4 mb-8">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">Mudah Digunakan</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">Data Aman</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">Fitur AI</span>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('register') }}" 
                           class="px-8 py-4 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold rounded-xl shadow-2xl transform hover:scale-105 transition-all duration-300">
                            Mulai Sekarang - Gratis!
                        </a>
                        <a href="#cara-kerja" 
                           class="px-8 py-4 bg-white hover:bg-gray-50 text-blue-600 font-bold rounded-xl border-2 border-blue-200 shadow-lg transform hover:scale-105 transition-all duration-300">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>

                <!-- Right Content - Illustration -->
                <div class="animate-slideInRight">
                    <div class="relative">
                        <div class="relative z-10 bg-white rounded-3xl shadow-2xl p-8 border-4 border-blue-100">
                            <!-- Mockup Dashboard -->
                            <div class="space-y-4">
                                <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                                    <h3 class="text-lg font-bold text-gray-900">Dashboard Anak</h3>
                                    <div class="flex space-x-2">
                                        <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                                        <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                                        <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                                    </div>
                                </div>
                                
                                <!-- Child Card -->
                                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-xl">
                                            A
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">Anak Pertama</p>
                                            <p class="text-sm text-gray-600">24 bulan</p>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="bg-white rounded-lg p-2">
                                            <p class="text-xs text-gray-600">Tinggi</p>
                                            <p class="text-sm font-bold text-blue-600">85 cm</p>
                                        </div>
                                        <div class="bg-white rounded-lg p-2">
                                            <p class="text-xs text-gray-600">Berat</p>
                                            <p class="text-sm font-bold text-blue-600">12 kg</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Growth Chart Preview -->
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <p class="text-sm font-semibold text-gray-700 mb-2">Grafik Pertumbuhan</p>
                                    <div class="h-24 bg-gradient-to-r from-blue-200 via-blue-300 to-blue-400 rounded-lg flex items-end justify-around p-2">
                                        <div class="w-8 bg-blue-600 rounded-t" style="height: 40%"></div>
                                        <div class="w-8 bg-blue-600 rounded-t" style="height: 60%"></div>
                                        <div class="w-8 bg-blue-600 rounded-t" style="height: 80%"></div>
                                        <div class="w-8 bg-blue-600 rounded-t" style="height: 70%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Decorative Elements -->
                        <div class="absolute -top-6 -right-6 w-24 h-24 bg-blue-400 rounded-3xl opacity-20 animate-float"></div>
                        <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-blue-300 rounded-3xl opacity-20 animate-float animation-delay-2000"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-flex items-center px-4 py-2 bg-blue-100 rounded-full mb-4">
                    <span class="text-sm font-semibold text-blue-600">Fitur Unggulan</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Semua yang Anda Butuhkan
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Platform lengkap untuk memantau dan merekam setiap tahap perkembangan buah hati Anda
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-gradient-to-br from-blue-50 to-white rounded-2xl p-8 border-2 border-blue-100 hover:border-blue-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mb-4 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Kelola Data Anak</h3>
                    <p class="text-gray-600">
                        Daftarkan dan kelola data lengkap anak Anda termasuk data kelahiran, golongan darah, dan informasi kesehatan lainnya.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-gradient-to-br from-green-50 to-white rounded-2xl p-8 border-2 border-green-100 hover:border-green-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mb-4 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Catat Pertumbuhan</h3>
                    <p class="text-gray-600">
                        Rekam tinggi badan, berat badan, lingkar kepala, dan lingkar lengan anak secara berkala dengan mudah.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-gradient-to-br from-purple-50 to-white rounded-2xl p-8 border-2 border-purple-100 hover:border-purple-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mb-4 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Grafik Pertumbuhan</h3>
                    <p class="text-gray-600">
                        Visualisasi data pertumbuhan dalam bentuk grafik yang mudah dipahami dan dianalisa.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-gradient-to-br from-yellow-50 to-white rounded-2xl p-8 border-2 border-yellow-100 hover:border-yellow-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center mb-4 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Riwayat Lengkap</h3>
                    <p class="text-gray-600">
                        Akses seluruh riwayat pencatatan pertumbuhan anak dari waktu ke waktu dengan mudah.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-gradient-to-br from-pink-50 to-white rounded-2xl p-8 border-2 border-pink-100 hover:border-pink-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl flex items-center justify-center mb-4 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Galeri Foto</h3>
                    <p class="text-gray-600">
                        Simpan foto-foto perkembangan anak Anda dan lihat perubahan dari waktu ke waktu.
                    </p>
                </div>

                <!-- Feature 6 - AI Feature -->
                <div class="bg-gradient-to-br from-indigo-50 to-white rounded-2xl p-8 border-2 border-indigo-100 hover:border-indigo-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center mb-4 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Analisa AI (Bonus)</h3>
                    <p class="text-gray-600">
                        Fitur tambahan: estimasi tinggi, berat, dan usia menggunakan teknologi AI dari foto.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="cara-kerja" class="py-20 bg-gradient-to-br from-blue-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-flex items-center px-4 py-2 bg-blue-100 rounded-full mb-4">
                    <span class="text-sm font-semibold text-blue-600">Mudah & Praktis</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Cara Menggunakan MOA
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Hanya 3 langkah mudah untuk mulai memantau tumbuh kembang anak Anda
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="relative">
                    <div class="bg-white rounded-2xl p-8 shadow-xl border-2 border-blue-100 hover:border-blue-300 transition-all duration-300 transform hover:-translate-y-2">
                        <div class="absolute -top-6 left-8 w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg">
                            1
                        </div>
                        <div class="mt-6 mb-4">
                            <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Daftar & Tambah Anak</h3>
                        <p class="text-gray-600 text-center">
                            Buat akun gratis dan daftarkan data anak Anda dengan lengkap
                        </p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="relative">
                    <div class="bg-white rounded-2xl p-8 shadow-xl border-2 border-green-100 hover:border-green-300 transition-all duration-300 transform hover:-translate-y-2">
                        <div class="absolute -top-6 left-8 w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg">
                            2
                        </div>
                        <div class="mt-6 mb-4">
                            <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Catat Perkembangan</h3>
                        <p class="text-gray-600 text-center">
                            Rekam tinggi, berat, dan data pertumbuhan lainnya secara rutin
                        </p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="relative">
                    <div class="bg-white rounded-2xl p-8 shadow-xl border-2 border-purple-100 hover:border-purple-300 transition-all duration-300 transform hover:-translate-y-2">
                        <div class="absolute -top-6 left-8 w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg">
                            3
                        </div>
                        <div class="mt-6 mb-4">
                            <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Pantau & Analisa</h3>
                        <p class="text-gray-600 text-center">
                            Lihat grafik pertumbuhan dan pantau perkembangan anak dari waktu ke waktu
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section id="keunggulan" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left: Benefits List -->
                <div>
                    <div class="inline-flex items-center px-4 py-2 bg-blue-100 rounded-full mb-4">
                        <span class="text-sm font-semibold text-blue-600">Keunggulan Kami</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                        Kenapa Memilih MOA?
                    </h2>
                    <p class="text-xl text-gray-600 mb-8">
                        Platform terpercaya untuk memantau tumbuh kembang anak dengan berbagai keunggulan
                    </p>

                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">100% Gratis</h3>
                                <p class="text-gray-600">Semua fitur utama dapat digunakan tanpa biaya berlangganan</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Data Aman & Privasi Terjaga</h3>
                                <p class="text-gray-600">Data anak Anda tersimpan dengan aman dan hanya bisa diakses oleh Anda</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Mudah Digunakan</h3>
                                <p class="text-gray-600">Interface yang intuitif dan mudah dipahami, cocok untuk semua kalangan</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Akses Kapan Saja</h3>
                                <p class="text-gray-600">Pantau perkembangan anak dari mana saja dan kapan saja melalui browser</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Visual/Stats -->
                <div class="relative">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-3xl p-8 shadow-2xl text-white">
                        <h3 class="text-2xl font-bold mb-8">Dipercaya Oleh Ribuan Orang Tua</h3>
                        
                        <div class="grid grid-cols-2 gap-6 mb-8">
                            <div class="bg-white/20 backdrop-blur-lg rounded-2xl p-6">
                                <p class="text-4xl font-bold mb-2">1000+</p>
                                <p class="text-blue-100">Orang Tua Aktif</p>
                            </div>
                            <div class="bg-white/20 backdrop-blur-lg rounded-2xl p-6">
                                <p class="text-4xl font-bold mb-2">5000+</p>
                                <p class="text-blue-100">Data Tercatat</p>
                            </div>
                            <div class="bg-white/20 backdrop-blur-lg rounded-2xl p-6">
                                <p class="text-4xl font-bold mb-2">100%</p>
                                <p class="text-blue-100">Gratis</p>
                            </div>
                            <div class="bg-white/20 backdrop-blur-lg rounded-2xl p-6">
                                <p class="text-4xl font-bold mb-2">24/7</p>
                                <p class="text-blue-100">Akses</p>
                            </div>
                        </div>

                        <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6">
                            <div class="flex items-center space-x-2 mb-3">
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </div>
                            <p class="text-sm italic">"Platform yang sangat membantu untuk memantau perkembangan anak. Interface-nya mudah digunakan dan fiturnya lengkap!"</p>
                            <p class="text-sm font-semibold mt-3">- Ibu Sarah, Jakarta</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-blue-600 to-blue-700 text-white relative overflow-hidden">
        <!-- Background decoration -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-4000"></div>
        </div>

        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">
                Siap Memantau Tumbuh Kembang Anak Anda?
            </h2>
            <p class="text-xl text-blue-100 mb-10 max-w-2xl mx-auto">
                Bergabunglah dengan ribuan orang tua yang telah mempercayai MOA untuk monitoring kesehatan anak
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('register') }}" 
                   class="px-8 py-4 bg-white hover:bg-gray-100 text-blue-600 font-bold rounded-xl shadow-2xl transform hover:scale-105 transition-all duration-300">
                    Daftar Gratis Sekarang
                </a>
                <a href="#fitur" 
                   class="px-8 py-4 bg-blue-700 hover:bg-blue-800 text-white font-bold rounded-xl border-2 border-white shadow-2xl transform hover:scale-105 transition-all duration-300">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Company Info -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-white">MOA</span>
                    </div>
                    <p class="text-gray-400 mb-4 max-w-md">
                        Platform terpercaya untuk memantau dan merekam tumbuh kembang anak Anda dengan mudah dan praktis.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-lg flex items-center justify-center transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-lg flex items-center justify-center transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-lg flex items-center justify-center transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Product Links -->
                <div>
                    <h4 class="text-white font-bold mb-4">Produk</h4>
                    <ul class="space-y-2">
                        <li><a href="#fitur" class="hover:text-blue-400 transition-colors">Fitur</a></li>
                        <li><a href="#cara-kerja" class="hover:text-blue-400 transition-colors">Cara Kerja</a></li>
                        <li><a href="#keunggulan" class="hover:text-blue-400 transition-colors">Keunggulan</a></li>
                    </ul>
                </div>

                <!-- Company Links -->
                <div>
                    <h4 class="text-white font-bold mb-4">Perusahaan</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-blue-400 transition-colors">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition-colors">Kontak</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition-colors">Blog</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm mb-4 md:mb-0">
                    © 2025 MOA. Semua hak dilindungi.
                </p>
                <div class="flex space-x-6 text-sm">
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors">Syarat & Ketentuan</a>
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors">Kebijakan Cookie</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Smooth Scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    mobileMenu.classList.add('hidden');
                }
            });
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fadeIn');
                }
            });
        }, observerOptions);

        document.querySelectorAll('section').forEach(section => {
            observer.observe(section);
        });
    </script>
</body>
</html>