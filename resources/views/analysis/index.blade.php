<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Body Analysis Laravel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen py-10">

    <div class="max-w-4xl mx-auto px-4">
        
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-blue-600">🤖 AI Body Analyzer (Laravel)</h1>
            <p class="text-gray-600 mt-2">Upload foto, Server akan mencatat estimasi Tinggi, Berat & Umur.</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-semibold mb-4">📸 Upload Foto Baru</h2>
                
                <form action="{{ route('analysis.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Foto Full Body</label>
                        <input type="file" name="photo" accept="image/*" required
                               class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition">
                        🚀 Analisis & Simpan ke DB
                    </button>
                    <p class="text-xs text-gray-400 mt-2 text-center">*Proses memakan waktu 3-5 detik</p>
                </form>
            </div>

            <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
                <h3 class="font-bold text-lg mb-2 text-blue-800">Cara Kerja Sistem:</h3>
                <ul class="list-disc list-inside text-sm text-gray-700 space-y-2">
                    <li>Foto diupload ke folder <code>storage/app/public/uploads</code>.</li>
                    <li>Laravel mengirim foto ke <strong>Gemini 1.5 Flash</strong>.</li>
                    <li>Gemini diminta membalas dalam format <strong>JSON</strong>.</li>
                    <li>Laravel membaca JSON dan menyimpan: Tinggi, Berat, Umur ke MySQL.</li>
                </ul>
            </div>
        </div>

        <div class="mt-10 bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-xl font-bold mb-4">📂 Riwayat Analisis Database</h2>
            
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="p-3">Waktu</th>
                            <th class="p-3">Foto</th>
                            <th class="p-3">Tinggi (Est)</th>
                            <th class="p-3">Berat (Est)</th>
                            <th class="p-3">Umur (Est)</th>
                            <th class="p-3">Catatan AI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($history as $item)
                        <tr>
                            <td class="p-3 text-gray-500">{{ $item->created_at->diffForHumans() }}</td>
                            <td class="p-3">
                                <img src="{{ asset($item->image_path) }}" class="h-16 w-16 object-cover rounded border">
                            </td>
                            <td class="p-3 font-bold">{{ $item->estimated_height }} cm</td>
                            <td class="p-3 font-bold">{{ $item->estimated_weight }} kg</td>
                            <td class="p-3 font-bold">{{ $item->estimated_age }} thn</td>
                            <td class="p-3 text-gray-600 line-clamp-2" title="{{ $item->full_analysis }}">
                                {{ Str::limit($item->full_analysis, 50) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                @if($history->isEmpty())
                    <p class="text-center text-gray-400 py-4">Belum ada data.</p>
                @endif
            </div>
        </div>

    </div>
</body>
</html>