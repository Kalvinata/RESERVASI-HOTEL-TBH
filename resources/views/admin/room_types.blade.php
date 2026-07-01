<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Tipe Kamar - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex">

    <aside class="w-64 bg-indigo-950 text-white min-h-screen flex flex-col hidden md:flex">
        <div class="p-6 border-b border-indigo-900">
            <h1 class="text-xl font-semibold tracking-wider">TBH Admin</h1>
            <p class="text-xs text-indigo-300 mt-1">Administrator Panel</p>
        </div>
        <nav class="flex-grow p-4 space-y-2">
            <a href="/admin/dashboard" class="block py-2.5 px-4 rounded transition hover:bg-indigo-900 text-slate-300">📈 Dashboard</a>
            <a href="/admin/room-types" class="block py-2.5 px-4 rounded transition bg-indigo-900 text-indigo-300 border-l-4 border-indigo-400">🛏️ Kelola Tipe Kamar</a>
            <a href="/admin/rooms" class="block py-2.5 px-4 rounded transition hover:bg-indigo-900 text-slate-300">🚪 Kelola Kamar</a>
            <a href="#" class="block py-2.5 px-4 rounded transition hover:bg-indigo-900 text-slate-300">👥 Kelola Pengguna</a>
        </nav>
        <div class="p-4 border-t border-indigo-900">
            <a href="/login" class="block py-2 text-center text-sm text-indigo-300 hover:text-white transition">Logout</a>
        </div>
    </aside>

    <main class="flex-grow p-8 max-w-7xl mx-auto overflow-y-auto h-screen">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-semibold text-slate-800">Kelola Tipe Kamar</h2>
                <p class="text-sm text-slate-500 mt-1">Tambah dan kelola jenis kamar yang ditawarkan ke tamu</p>
            </div>
        </div>

        @if(session('success'))
        <div class="bg-emerald-50 text-emerald-700 p-4 rounded-lg mb-6 border border-emerald-200">
            {{ session('success') }}
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-lg font-medium text-slate-800 mb-4 border-b border-slate-100 pb-2">Tambah Tipe Baru</h3>
                    
                    <form action="/admin/room-types" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-1">Nama Tipe Kamar</label>
                            <input type="text" name="type_name" placeholder="Misal: Standard Room" class="w-full text-sm px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-1">Harga per Malam (Rp)</label>
                            <input type="number" name="base_price" placeholder="Misal: 500000" class="w-full text-sm px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-1">Maksimal Penghuni</label>
                            <input type="number" name="Max_occupancy" placeholder="Misal: 2" class="w-full text-sm px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-1">Fasilitas</label>
                            <textarea name="facilities" rows="3" placeholder="AC, TV, WiFi..." class="w-full text-sm px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" required></textarea>
                        </div>
                        <button type="submit" class="w-full bg-indigo-600 text-white text-sm font-medium py-2.5 rounded-lg hover:bg-indigo-700 transition shadow-sm mt-2">
                            Simpan Tipe Kamar
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-600 text-sm border-b border-slate-200">
                                <th class="p-4 font-medium">Informasi Tipe</th>
                                <th class="p-4 font-medium">Fasilitas</th>
                                <th class="p-4 font-medium">Harga / Malam</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach($roomTypes as $type)
                            <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                                <td class="p-4">
                                    <p class="font-semibold text-slate-800">{{ $type->type_name }}</p>
                                    <p class="text-xs text-slate-500 mt-1">Maks. {{ $type->Max_occupancy }} Orang</p>
                                </td>
                                <td class="p-4">
                                    <p class="text-xs text-slate-600">{{ $type->facilities }}</p>
                                </td>
                                <td class="p-4">
                                    <p class="font-medium text-slate-800">Rp {{ number_format($type->base_price, 0, ',', '.') }}</p>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

</body>
</html>