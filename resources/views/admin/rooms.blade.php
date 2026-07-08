<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kamar - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden text-slate-800">

    <aside class="w-64 bg-slate-900 text-white flex flex-col justify-between hidden md:flex z-20 shadow-xl flex-shrink-0">
        <div>
            <div class="h-20 flex flex-col justify-center px-6 border-b border-slate-700 bg-slate-950">
                <h1 class="text-2xl font-serif font-bold text-emerald-400 tracking-wide">TBH Admin</h1>
                <p class="text-[11px] text-slate-400 uppercase tracking-widest">Administrator Panel</p>
            </div>
            
            <nav class="p-4 space-y-2 mt-2">
                <a href="/admin/dashboard" class="flex items-center px-4 py-3 text-slate-400 hover:text-white hover:bg-slate-800 border-l-4 border-transparent rounded-r-lg font-medium transition-all">
                    <span class="mr-3 text-lg">📈</span> <span class="text-sm">Dashboard</span>
                </a>
                <a href="/admin/room-types" class="flex items-center px-4 py-3 text-slate-400 hover:text-white hover:bg-slate-800 border-l-4 border-transparent rounded-r-lg font-medium transition-all">
                    <span class="mr-3 text-lg">🛏️</span> <span class="text-sm">Kelola Tipe Kamar</span>
                </a>
                <a href="/admin/rooms" class="flex items-center px-4 py-3 bg-emerald-500/10 text-emerald-400 border-l-4 border-emerald-500 rounded-r-lg font-medium transition-all">
                    <span class="mr-3 text-lg">🚪</span> <span class="text-sm">Kelola Kamar</span>
                </a>
                <a href="/admin/users" class="flex items-center px-4 py-3 text-slate-400 hover:text-white hover:bg-slate-800 border-l-4 border-transparent rounded-r-lg font-medium transition-all">
                    <span class="mr-3 text-lg">👥</span> <span class="text-sm">Kelola Pengguna</span>
                </a>
            </nav>
        </div>

        <div class="p-5 border-t border-slate-800 bg-slate-950/50">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center text-white font-bold shadow-lg">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="ml-3 overflow-hidden">
                    <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name ?? 'Administrator' }}</p>
                    <p class="text-[11px] text-emerald-400 truncate">Administrator</p>
                </div>
            </div>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center px-4 py-2 border border-slate-700 text-slate-300 rounded-lg hover:bg-red-500 hover:text-white hover:border-red-500 transition-colors text-xs font-semibold">
                    Keluar Akun
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 overflow-y-auto bg-slate-50 flex flex-col">
        <header class="bg-white border-b border-slate-200 px-8 py-5 flex items-center justify-between sticky top-0 z-10 shadow-sm">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Kelola Kamar</h2>
                <p class="text-sm text-slate-500 mt-1">Tambah nomor kamar baru dan tentukan tipenya.</p>
            </div>
        </header>

        <div class="p-8">
            @if(session('success'))
            <div class="bg-emerald-50 text-emerald-700 px-4 py-3 rounded-lg mb-6 border border-emerald-200 text-sm font-medium">
                {{ session('success') }}
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <h3 class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-100 pb-2">Tambah Kamar Baru</h3>
                        
                        <form action="/admin/rooms" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Nomor Kamar</label>
                                <input type="text" name="room_number" placeholder="Misal: D-103" class="w-full text-sm px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Pilih Tipe Kamar</label>
                                <select name="room_type_id" class="w-full text-sm px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50" required>
                                    <option value="" disabled selected>-- Pilih Tipe --</option>
                                    @foreach($roomTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->type_name }} (Rp {{ number_format($type->base_price, 0, ',', '.') }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Lantai</label>
                                <input type="number" name="floor" placeholder="Misal: 1" class="w-full text-sm px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50" required>
                            </div>
                            <button type="submit" class="w-full bg-slate-800 text-white text-sm font-bold py-2.5 rounded-lg hover:bg-slate-900 transition shadow-sm mt-2">
                                Simpan Kamar
                            </button>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500 tracking-wider">
                                    <th class="p-4 font-semibold">Nomor Kamar</th>
                                    <th class="p-4 font-semibold">Tipe</th>
                                    <th class="p-4 font-semibold text-center">Lantai</th>
                                    <th class="p-4 font-semibold text-center">Status Saat Ini</th>
                                    <th class="p-4 font-semibold text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm">
                                @foreach($rooms as $room)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="p-4 font-bold text-slate-800">
                                        {{ $room->room_number }}
                                    </td>
                                    <td class="p-4 font-semibold text-slate-700">
                                        {{ $room->roomType->type_name ?? 'Tipe Tidak Ditemukan' }}
                                    </td>
                                    <td class="p-4 text-slate-600 font-medium text-center">
                                        {{ $room->floor }}
                                    </td>
                                    <td class="p-4 text-center">
                                        @if($room->status == 'available')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">TERSEDIA</span>
                                        @elseif($room->status == 'occupied')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold bg-blue-100 text-blue-700 border border-blue-200">TERISI</span>
                                        @elseif($room->status == 'dirty')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold bg-amber-100 text-amber-700 border border-amber-200">KOTOR</span>
                                        @elseif($room->status == 'cleaning')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold bg-rose-100 text-rose-700 border border-rose-200">DIBERSIHKAN</span>
                                        @elseif($room->status == 'maintenance')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold bg-purple-100 text-purple-700 border border-purple-200">PERBAIKAN</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center space-x-2 whitespace-nowrap">
                                        <a href="/admin/rooms/{{ $room->id }}/edit" class="inline-block bg-amber-100 text-amber-700 hover:bg-amber-200 px-3 py-1.5 rounded-md text-xs font-bold transition">Edit</a>
                                        
                                        <form action="/admin/rooms/{{ $room->id }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus Kamar ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-rose-100 text-rose-700 hover:bg-rose-200 px-3 py-1.5 rounded-md text-xs font-bold transition">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>