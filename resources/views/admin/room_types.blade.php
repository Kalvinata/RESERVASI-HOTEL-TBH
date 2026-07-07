<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Tipe Kamar - Admin</title>
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
                <a href="/admin/room-types" class="flex items-center px-4 py-3 bg-emerald-500/10 text-emerald-400 border-l-4 border-emerald-500 rounded-r-lg font-medium transition-all">
                    <span class="mr-3 text-lg">🛏️</span> <span class="text-sm">Kelola Tipe Kamar</span>
                </a>
                <a href="/admin/rooms" class="flex items-center px-4 py-3 text-slate-400 hover:text-white hover:bg-slate-800 border-l-4 border-transparent rounded-r-lg font-medium transition-all">
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
                <h2 class="text-2xl font-bold text-slate-800">Kelola Tipe Kamar</h2>
                <p class="text-sm text-slate-500 mt-1">Tambah dan kelola jenis kamar yang ditawarkan ke tamu.</p>
            </div>
        </header>

        <div class="p-8">
            @if(session('success'))
            <div class="bg-emerald-50 text-emerald-700 px-4 py-3 rounded-lg mb-6 border border-emerald-200 text-sm font-medium flex items-center">
                <span class="mr-2">✅</span> {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="bg-rose-50 text-rose-700 px-4 py-3 rounded-lg mb-6 border border-rose-200 text-sm font-medium">
                <div class="flex items-center mb-2">
                    <span class="mr-2">⚠️</span> <strong>Gagal menyimpan data! Periksa hal berikut:</strong>
                </div>
                <ul class="list-disc pl-8">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <h3 class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-100 pb-2">Tambah Tipe Baru</h3>
                        
                        <form action="/admin/room-types" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Nama Tipe Kamar</label>
                                <input type="text" name="type_name" placeholder="Misal: Standard Room" class="w-full text-sm px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50" value="{{ old('type_name') }}" required>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 mb-1">Harga (Rp)</label>
                                    <input type="number" name="base_price" placeholder="500000" class="w-full text-sm px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50" value="{{ old('base_price') }}" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 mb-1">Maks. Penghuni</label>
                                    <input type="number" name="Max_occupancy" placeholder="2" class="w-full text-sm px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50" value="{{ old('Max_occupancy') }}" required>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Fasilitas (Singkat)</label>
                                <input type="text" name="facilities" placeholder="AC, TV, WiFi..." class="w-full text-sm px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50" value="{{ old('facilities') }}" required>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Deskripsi / Detail Kamar</label>
                                <textarea name="description" rows="3" placeholder="Jelaskan suasana dan keunggulan kamar ini..." class="w-full text-sm px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50" required>{{ old('description') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Foto Kamar (Maks 2MB)</label>
                                <input type="file" name="image" accept="image/*" class="w-full text-sm px-3 py-1.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50 file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300" required>
                            </div>

                            <button type="submit" class="w-full bg-slate-800 text-white text-sm font-bold py-2.5 rounded-lg hover:bg-slate-900 transition shadow-sm mt-2">
                                Simpan Tipe Kamar
                            </button>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500 tracking-wider">
                                    <th class="p-4 font-semibold">Tipe Kamar</th>
                                    <th class="p-4 font-semibold">Fasilitas & Deskripsi</th>
                                    <th class="p-4 font-semibold text-right">Harga</th>
                                    <th class="p-4 font-semibold text-center">Aksi</th> 
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm">
                                @foreach($roomTypes as $type)
                                <tr class="hover:bg-slate-50/50 transition">
                                    
                                    <td class="p-4 flex items-start gap-3">
                                        @if($type->image)
                                            <img src="{{ asset('storage/' . $type->image) }}" alt="Foto" class="w-20 h-16 object-cover rounded-lg shadow-sm border border-slate-200 flex-shrink-0">
                                        @else
                                            <div class="w-20 h-16 bg-slate-100 rounded-lg flex flex-col items-center justify-center text-[10px] text-slate-400 border border-slate-200 flex-shrink-0">
                                                <span>📷</span><span>No Img</span>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-bold text-slate-800 text-base">{{ $type->type_name }}</p>
                                            <p class="text-xs text-slate-500 mt-0.5">Maks. {{ $type->Max_occupancy }} Orang</p>
                                        </div>
                                    </td>

                                    <td class="p-4 align-top max-w-xs">
                                        <p class="text-xs font-bold text-emerald-600 mb-1">{{ $type->facilities }}</p>
                                        <p class="text-xs text-slate-500 line-clamp-2" title="{{ $type->description }}">
                                            {{ $type->description ?? 'Tidak ada deskripsi detail.' }}
                                        </p>
                                    </td>

                                    <td class="p-4 align-top text-right">
                                        <p class="font-bold text-slate-800 whitespace-nowrap">Rp {{ number_format($type->base_price, 0, ',', '.') }}</p>
                                    </td>

                                    <td class="p-4 align-top text-center space-y-2">
                                        <a href="/admin/room-types/{{ $type->id }}/edit" class="block w-full text-center bg-amber-100 text-amber-700 hover:bg-amber-200 px-3 py-1.5 rounded-md text-xs font-bold transition">Edit</a>
                                        
                                        <form action="/admin/room-types/{{ $type->id }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus Tipe Kamar ini? Tindakan ini tidak bisa dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="block w-full text-center bg-rose-100 text-rose-700 hover:bg-rose-200 px-3 py-1.5 rounded-md text-xs font-bold transition">Hapus</button>
                                        </form>
                                    </td>

                                </tr>
                                @endforeach

                                @if(count($roomTypes) == 0)
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-slate-500">Belum ada data tipe kamar.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>