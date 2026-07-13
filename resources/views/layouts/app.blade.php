<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MOA-Monitoring Anak') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            @keyframes blob {
                0%, 100% { transform: translate(0px, 0px) scale(1); }
                33% { transform: translate(30px, -50px) scale(1.1); }
                66% { transform: translate(-20px, 20px) scale(0.9); }
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
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50" x-data="{ sidebarOpen: false }">
        <div class="min-h-screen">
            <!-- Sidebar -->
            <aside 
                class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-blue-600 via-blue-700 to-blue-800 shadow-2xl transform transition-transform duration-300 ease-in-out lg:translate-x-0"
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            >
                <!-- Logo Section -->
                <div class="flex items-center justify-between h-20 px-6 bg-blue-900/50 border-b border-blue-500/30">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-white">MOA</h1>
                            <p class="text-xs text-blue-200">{{ Auth::user()->isAdmin() ? 'Admin Panel' : 'Dashboard' }}</p>
                        </div>
                    </div>
                    <button @click="sidebarOpen = false" class="lg:hidden text-white hover:bg-blue-700 p-2 rounded-lg transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Navigation Menu -->
                <nav class="px-4 py-6 space-y-2 overflow-y-auto h-[calc(100vh-80px)]">
                    @if(Auth::user()->isAdmin())
                        <!-- ADMIN MENU -->
                        <!-- Dashboard -->
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 shadow-lg border border-white/30' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span class="font-semibold">Admin Dashboard</span>
                        </a>

                        <!-- Divider -->
                        <div class="pt-2 pb-2">
                            <div class="h-px bg-white/20"></div>
                        </div>

                        <!-- Section Label: Management -->
                        <div class="px-4 pt-2">
                            <p class="text-xs font-semibold text-blue-200 uppercase tracking-wider">Management</p>
                        </div>

                        <!-- User Management -->
                        <a href="{{ route('admin.users') }}" 
                           class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white transition-all duration-300 {{ request()->routeIs('admin.users*') ? 'bg-white/20 shadow-lg border border-white/30' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span class="font-semibold">Users</span>
                        </a>

                        <!-- Children Management -->
                        <a href="{{ route('admin.children') }}" 
                           class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white transition-all duration-300 {{ request()->routeIs('admin.children*') ? 'bg-white/20 shadow-lg border border-white/30' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="font-semibold">Children</span>
                        </a>

                        <!-- Growth Records Management -->
                        <a href="{{ route('admin.growth-records') }}" 
                           class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white transition-all duration-300 {{ request()->routeIs('admin.growth-records') ? 'bg-white/20 shadow-lg border border-white/30' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <span class="font-semibold">Growth Records</span>
                        </a>

                        <!-- Body Analyses Management -->
                        <a href="{{ route('admin.analyses') }}" 
                           class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white transition-all duration-300 {{ request()->routeIs('admin.analyses*') ? 'bg-white/20 shadow-lg border border-white/30' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                            <span class="font-semibold">Body Analyses</span>
                        </a>

                        <!-- Divider -->
                        <div class="pt-2 pb-2">
                            <div class="h-px bg-white/20"></div>
                        </div>

                        <!-- Section Label: Monitoring -->
                        <div class="px-4 pt-2">
                            <p class="text-xs font-semibold text-blue-200 uppercase tracking-wider">Monitoring</p>
                        </div>

                        <!-- Activity Logs -->
                        <a href="{{ route('admin.activity-logs') }}" 
                           class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white transition-all duration-300 {{ request()->routeIs('admin.activity-logs') ? 'bg-white/20 shadow-lg border border-white/30' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="font-semibold">Activity Logs</span>
                        </a>

                        <!-- System Status -->
                        <a href="{{ route('admin.system-status') }}" 
                           class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white transition-all duration-300 {{ request()->routeIs('admin.system-status') ? 'bg-white/20 shadow-lg border border-white/30' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span class="font-semibold">System Status</span>
                        </a>

                        <!-- Divider -->
                        <div class="pt-2 pb-2">
                            <div class="h-px bg-white/20"></div>
                        </div>

                        {{-- Switch to User Dashboard (sementara dimatikan) --}}
                        {{--
                        <div class="px-4 pt-2">
                            <p class="text-xs font-semibold text-blue-200 uppercase tracking-wider">User Access</p>
                        </div>
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white transition-all duration-300 hover:bg-white/10">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                            <span class="font-semibold">User Dashboard</span>
                        </a>
                        --}}

                    @else
                        <!-- USER MENU -->
                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-white/20 shadow-lg border border-white/30' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span class="font-semibold">Dashboard</span>
                        </a>

                        <!-- Divider -->
                        <div class="pt-2 pb-2">
                            <div class="h-px bg-white/20"></div>
                        </div>

                        <!-- Section Label: Fitur Utama -->
                        <div class="px-4 pt-2">
                            <p class="text-xs font-semibold text-blue-200 uppercase tracking-wider">Fitur Utama</p>
                        </div>

                        <!-- Daftar Anak -->
                        <a href="{{ route('children.index') }}" 
                           class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white transition-all duration-300 {{ request()->routeIs('children.*') ? 'bg-white/20 shadow-lg border border-white/30' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span class="font-semibold">Daftar Anak</span>
                        </a>

                        <!-- Divider -->
                        <div class="pt-2 pb-2">
                            <div class="h-px bg-white/20"></div>
                        </div>

                        <!-- Section Label: Fitur Tambahan -->
                        <div class="px-4 pt-2">
                            <p class="text-xs font-semibold text-blue-200 uppercase tracking-wider">Fitur Tambahan</p>
                        </div>

                        <!-- Analisa Body AI -->
                        <a href="{{ route('analysis.index') }}" 
                           class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white transition-all duration-300 {{ request()->routeIs('analysis.*') ? 'bg-white/20 shadow-lg border border-white/30' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                            <span class="font-semibold">Analisa Body AI</span>
                        </a>

                        <!-- Divider -->
                        <div class="pt-2 pb-2">
                            <div class="h-px bg-white/20"></div>
                        </div>
                    @endif

                    <!-- Section Label: Akun -->
                    <div class="px-4 pt-2">
                        <p class="text-xs font-semibold text-blue-200 uppercase tracking-wider">Akun</p>
                    </div>

                    <!-- Profile -->
                    <a href="{{ route('profile.edit') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white transition-all duration-300 {{ request()->routeIs('profile.*') ? 'bg-white/20 shadow-lg border border-white/30' : 'hover:bg-white/10' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span class="font-semibold">Profil Saya</span>
                    </a>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-white transition-all duration-300 hover:bg-red-500/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span class="font-semibold">Keluar</span>
                        </button>
                    </form>
                </nav>
            </aside>

            <!-- Main Content Area -->
            <div class="lg:ml-64">
                <!-- Top Navigation Bar -->
                <nav class="bg-white/90 backdrop-blur-md shadow-md sticky top-0 z-40 border-b border-gray-200">
                    <div class="mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between items-center h-16">
                            <!-- Mobile Menu Button -->
                            <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                            </button>

                            <!-- Page Title (Mobile) -->
                            @isset($header)
                                <div class="ml-4 flex-1 flex items-center">
                                    <h2 class="text-lg font-bold text-gray-800">{{ $header }}</h2>
                                </div>
                            @endisset

                            <!-- Right Section -->
                            <div class="flex items-center space-x-4 ml-auto">
                                <!-- Notifications -->
                                <button class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-xl transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                    </svg>
                                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                                </button>

                                <!-- User Profile Dropdown -->
                                <div x-data="{ open: false }" class="relative">
                                    <button @click="open = !open" class="flex items-center space-x-3 px-3 py-2 rounded-xl hover:bg-gray-100 transition-colors">
                                        <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white font-bold shadow-md">
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        </div>
                                        <div class="hidden md:block text-left">
                                            <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                            <p class="text-xs text-gray-500">{{ Auth::user()->role ?? 'User' }}</p>
                                        </div>
                                        <svg class="w-4 h-4 text-gray-600 hidden md:block" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>

                                    <!-- Dropdown Menu -->
                                    <div 
                                        x-show="open" 
                                        @click.away="open = false"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 scale-95"
                                        x-transition:enter-end="opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100 scale-100"
                                        x-transition:leave-end="opacity-0 scale-95"
                                        class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-200 py-2"
                                        style="display: none;"
                                    >
                                        <div class="px-4 py-3 border-b border-gray-100">
                                            <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                        </div>
                                        
                                        <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors">
                                            <svg class="w-4 h-4 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            Profil Saya
                                        </a>

                                        @if(Auth::user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors">
                                            <svg class="w-4 h-4 mr-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            Admin Panel
                                        </a>
                                        @endif

                                        <div class="border-t border-gray-100 my-2"></div>

                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="w-full flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                                </svg>
                                                Keluar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Page Content -->
                <main class="p-4 sm:p-6 lg:p-8 min-h-[calc(100vh-4rem)] bg-gradient-to-br from-blue-50/30 via-white to-blue-100/30 relative overflow-hidden">
                    <!-- Animated Background -->
                    <div class="absolute inset-0 overflow-hidden pointer-events-none">
                        <div class="absolute top-20 right-20 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
                        <div class="absolute bottom-20 left-20 w-96 h-96 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
                    </div>

                    <!-- Content -->
                    <div class="relative z-10">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        <!-- Mobile Sidebar Overlay -->
        <div 
            x-show="sidebarOpen" 
            @click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/50 z-40 lg:hidden"
            style="display: none;"
        ></div>
    </body>
</html>