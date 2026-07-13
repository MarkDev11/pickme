<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-slot name="header">
        Manajemen Pengguna
    </x-slot>

    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-blue-100 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-50 to-white px-8 py-6 border-b border-blue-100">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">Semua Pengguna</h3>
                        <p class="text-sm text-gray-600">Kelola dan pantau semua pengguna terdaftar</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <!-- Export Button -->
                    <a href="{{ route('admin.export.users') }}" 
                       class="inline-flex items-center justify-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition-colors shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Ekspor CSV
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
                           placeholder="Cari nama atau email..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Role Filter -->
                <div>
                    <select name="role" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Role</option>
                        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Pengguna</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors">
                        Cari
                    </button>
                    <a href="{{ route('admin.users') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl transition-colors">
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
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Role</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Statistik</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Bergabung</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users as $user)
                    <tr class="hover:bg-blue-50/50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-600">#{{ $user->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white font-bold shadow-md">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $user->role === 'admin' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-3 text-xs">
                                <div class="text-center">
                                    <p class="font-semibold text-blue-600">{{ $user->children_count }}</p>
                                    <p class="text-gray-500">Anak</p>
                                </div>
                                <div class="text-center">
                                    <p class="font-semibold text-green-600">{{ $user->growth_records_count }}</p>
                                    <p class="text-gray-500">Catatan</p>
                                </div>
                                <div class="text-center">
                                    <p class="font-semibold text-purple-600">{{ $user->body_analyses_count }}</p>
                                    <p class="text-gray-500">Analisis</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.users.show', $user->id) }}" 
                                class="p-2 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg transition-colors"
                                title="Lihat Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.toggle-role', $user->id) }}" 
                                    method="POST" 
                                    class="inline form-role-toggle" 
                                    data-name="{{ $user->name }}" 
                                    data-new-role="{{ $user->role === 'admin' ? 'User' : 'Admin' }}">
                                    @csrf
                                    <button type="button" 
                                            class="btn-submit-role p-2 bg-purple-100 hover:bg-purple-200 text-purple-600 rounded-lg transition-colors"
                                            title="Ganti Role">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                        </svg>
                                    </button>
                                </form>

                                <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                    method="POST" 
                                    class="inline form-delete" 
                                    data-name="{{ $user->name }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            class="btn-submit-delete p-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors"
                                            title="Hapus Pengguna">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="text-lg font-semibold">Tidak ada pengguna</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
        @endif
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // 1. Konfirmasi Ganti Role
        const roleForms = document.querySelectorAll('.form-role-toggle');
        roleForms.forEach(form => {
            const button = form.querySelector('.btn-submit-role');
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const name = form.getAttribute('data-name');
                const newRole = form.getAttribute('data-new-role');

                Swal.fire({
                    title: 'Ganti Role?',
                    text: `Apakah Anda yakin ingin mengubah role ${name} menjadi ${newRole}?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#9333ea', // Warna Purple
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Ubah!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // 2. Konfirmasi Hapus User
        const deleteForms = document.querySelectorAll('.form-delete');
        deleteForms.forEach(form => {
            const button = form.querySelector('.btn-submit-delete');
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const name = form.getAttribute('data-name');

                Swal.fire({
                    title: 'Hapus User?',
                    text: `Anda akan menghapus user "${name}". Semua data anak & riwayat pertumbuhan mereka juga akan terhapus permanen!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444', // Warna Red
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus Permanen!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
</x-app-layout>