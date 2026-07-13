<x-app-layout>
    <x-slot name="header">
        Pengaturan Profil
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Profile Header Card -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl shadow-xl p-8 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full -ml-24 -mb-24"></div>
            
            <div class="relative z-10 flex items-center space-x-6">
                <div class="w-24 h-24 bg-white rounded-2xl flex items-center justify-center shadow-2xl">
                    <span class="text-4xl font-bold text-blue-600">{{ substr(Auth::user()->name, 0, 1) }}</span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold mb-2">{{ Auth::user()->name }}</h1>
                    <p class="text-blue-100 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        {{ Auth::user()->email }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Profile Information Card -->
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-white px-8 py-6 border-b border-blue-100">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Informasi Profil</h3>
                        <p class="text-sm text-gray-600">Perbarui informasi profil dan alamat email akun Anda</p>
                    </div>
                </div>
            </div>
            <div class="p-8">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password Card -->
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-white px-8 py-6 border-b border-blue-100">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Perbarui Password</h3>
                        <p class="text-sm text-gray-600">Pastikan akun Anda menggunakan password panjang dan acak agar tetap aman</p>
                    </div>
                </div>
            </div>
            <div class="p-8">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Account Card -->
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-red-200 overflow-hidden">
            <div class="bg-gradient-to-r from-red-50 to-white px-8 py-6 border-b border-red-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Hapus Akun</h3>
                        <p class="text-sm text-gray-600">Hapus akun Anda dan semua data terkait secara permanen</p>
                    </div>
                </div>
            </div>
            <div class="p-8">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>