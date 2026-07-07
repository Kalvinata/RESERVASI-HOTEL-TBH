<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna - Admin</title>
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
                <a href="/admin/users" class="flex items-center px-4 py-3 bg-emerald-500/10 text-emerald-400 border-l-4 border-emerald-500 rounded-r-lg font-medium transition-all">
                    <span class="mr-3 text-lg">👥</span> <span class="text-sm">Kelola Pengguna</span>
                </a>
            </nav>
        </div>
    </aside>

    <main class="flex-1 overflow-y-auto bg-slate-50 flex flex-col">
        <header class="bg-white border-b border-slate-200 px-8 py-5 flex items-center justify-between sticky top-0 z-10 shadow-sm">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Edit Pengguna</h2>
                <p class="text-sm text-slate-500 mt-1">Perbarui data untuk {{ $user->name }}.</p>
            </div>
            <a href="/admin/users" class="text-sm font-semibold text-slate-500 hover:text-slate-800 transition">← Kembali</a>
        </header>

        <div class="p-8">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8 max-w-2xl mx-auto">
                <form action="/admin/users/{{ $user->id }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="w-full text-sm px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50" required>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="w-full text-sm px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Password Baru (Opsional)</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak ingin ganti password" class="w-full text-sm px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Hak Akses (Role)</label>
                        <select name="role" class="w-full text-sm px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50" required>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin (Manajer)</option>
                            <option value="front_office" {{ $user->role == 'front_office' ? 'selected' : '' }}>Front Office (Resepsionis)</option>
                            <option value="housekeeping" {{ $user->role == 'housekeeping' ? 'selected' : '' }}>Housekeeping (Pembersih)</option>
                            <option value="guest" {{ $user->role == 'guest' ? 'selected' : '' }}>Tamu (Guest)</option>
                        </select>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex gap-3">
                        <button type="submit" class="flex-1 bg-emerald-600 text-white font-bold py-3 rounded-lg hover:bg-emerald-700 transition shadow-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>