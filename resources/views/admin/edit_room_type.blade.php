<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tipe Kamar - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden text-slate-800">

    <!-- SIDEBAR KIRI -->
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
            </nav>
        </div>
    </aside>

    <main class="flex-1 overflow-y-auto bg-slate-50 flex flex-col">
        <header class="bg-white border-b border-slate-200 px-8 py-5 flex items-center justify-between sticky top-0 z-10 shadow-sm">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Edit Tipe Kamar</h2>
                <p class="text-sm text-slate-500 mt-1">Ubah rincian, fasilitas, dan foto untuk {{ $roomType->type_name }}.</p>
            </div>
            <a href="/admin/room-types" class="text-sm font-semibold text-slate-500 hover:text-slate-800 transition">← Kembali</a>
        </header>

        <div class="p-8">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8 max-w-3xl mx-auto">
                <form action="/admin/room-types/{{ $roomType->id }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PUT') <!-- Wajib untuk proses Update -->
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Nama Tipe Kamar</label>
                        <input type="text" name="type_name" value="{{ $roomType->type_name }}" class="w-full text-sm px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50" required>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1">Harga per Malam (Rp)</label>
                            <input type="number" name="base_price" value="{{ $roomType->base_price }}" class="w-full text-sm px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1">Maks. Penghuni</label>
                            <input type="number" name="Max_occupancy" value="{{ $roomType->Max_occupancy }}" class="w-full text-sm px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50" required>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Fasilitas (Singkat)</label>
                        <input type="text" name="facilities" value="{{ $roomType->facilities }}" class="w-full text-sm px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Deskripsi Detail</label>
                        <textarea name="description" rows="4" class="w-full text-sm px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50" required>{{ $roomType->description }}</textarea>
                    </div>

                    <div class="border border-slate-200 rounded-lg p-4 bg-slate-50">
                        <label class="block text-xs font-bold text-slate-600 mb-3">Foto Kamar Saat Ini</label>
                        <div class="flex items-center gap-4">
                            @if($roomType->image)
                                <img src="{{ asset('storage/' . $roomType->image) }}" class="w-32 h-20 object-cover rounded shadow-sm border border-slate-200">
                            @else
                                <div class="w-32 h-20 bg-slate-200 rounded flex items-center justify-center text-xs text-slate-500 font-medium">Belum ada foto</div>
                            @endif
                            <div class="flex-1">
                                <label class="block text-xs font-semibold text-slate-500 mb-1">Ganti Foto (Opsional, Maks 2MB)</label>
                                <input type="file" name="image" accept="image/*" class="w-full text-sm px-3 py-1.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <button type="submit" class="w-full bg-emerald-600 text-white font-bold py-3 rounded-lg hover:bg-emerald-700 transition shadow-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>