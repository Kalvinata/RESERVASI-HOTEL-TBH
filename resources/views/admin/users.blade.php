<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - Admin</title>
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
                <a href="/admin/rooms" class="flex items-center px-4 py-3 text-slate-400 hover:text-white hover:bg-slate-800 border-l-4 border-transparent rounded-r-lg font-medium transition-all">
                    <span class="mr-3 text-lg">🚪</span> <span class="text-sm">Kelola Kamar</span>
                </a>
                <a href="/admin/users" class="flex items-center px-4 py-3 bg-emerald-500/10 text-emerald-400 border-l-4 border-emerald-500 rounded-r-lg font-medium transition-all">
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
                <h2 class="text-2xl font-bold text-slate-800">Kelola Pengguna</h2>
                <p class="text-sm text-slate-500 mt-1">Buat, edit, dan kelola akun staf serta tamu.</p>
            </div>
        </header>

        <div class="p-8">
            @if(session('success'))
            <div class="bg-emerald-50 text-emerald-700 px-4 py-3 rounded-lg mb-6 border border-emerald-200 text-sm font-medium">
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="bg-rose-50 text-rose-700 px-4 py-3 rounded-lg mb-6 border border-rose-200 text-sm font-medium">
                {{ session('error') }}
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <h3 class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-100 pb-2">Buat Akun Baru</h3>
                        <form action="/admin/users" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Nama Lengkap</label>
                                <input type="text" name="name" placeholder="Misal: Budi Santoso" class="w-full text-sm px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Email</label>
                                <input type="email" name="email" placeholder="budi@hotel.com" class="w-full text-sm px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Password</label>
                                <input type="password" name="password" placeholder="Minimal 8 karakter" class="w-full text-sm px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Hak Akses (Role)</label>
                                <select name="role" class="w-full text-sm px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50" required>
                                    <option value="" disabled selected>-- Pilih Peran --</option>
                                    <option value="admin">Admin (Manajer)</option>
                                    <option value="front_office">Front Office (Resepsionis)</option>
                                    <option value="housekeeping">Housekeeping (Pembersih)</option>
                                    <option value="guest">Tamu (Guest)</option>
                                </select>
                            </div>
                            <button type="submit" class="w-full bg-slate-800 text-white text-sm font-bold py-2.5 rounded-lg hover:bg-slate-900 transition shadow-sm mt-2">
                                Simpan Akun
                            </button>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden p-4">
                        
                        <!-- TAB NAVIGASI -->
                        <div class="flex space-x-2 mb-4 border-b border-slate-100 pb-3 overflow-x-auto">
                            <button onclick="filterUsers('all', this)" class="tab-btn bg-slate-800 text-white px-4 py-2 rounded-lg text-xs font-bold whitespace-nowrap transition">Semua</button>
                            <button onclick="filterUsers('admin', this)" class="tab-btn bg-slate-100 text-slate-600 hover:bg-slate-200 px-4 py-2 rounded-lg text-xs font-bold whitespace-nowrap transition">Admin</button>
                            <button onclick="filterUsers('front_office', this)" class="tab-btn bg-slate-100 text-slate-600 hover:bg-slate-200 px-4 py-2 rounded-lg text-xs font-bold whitespace-nowrap transition">Front Office</button>
                            <button onclick="filterUsers('housekeeping', this)" class="tab-btn bg-slate-100 text-slate-600 hover:bg-slate-200 px-4 py-2 rounded-lg text-xs font-bold whitespace-nowrap transition">Housekeeping</button>
                            <button onclick="filterUsers('guest', this)" class="tab-btn bg-slate-100 text-slate-600 hover:bg-slate-200 px-4 py-2 rounded-lg text-xs font-bold whitespace-nowrap transition">Guest</button>
                        </div>

                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500 tracking-wider">
                                    <th class="p-4 font-semibold">Nama Pengguna</th>
                                    <th class="p-4 font-semibold">Email</th>
                                    <th class="p-4 font-semibold text-center">Role</th>
                                    <th class="p-4 font-semibold text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm" id="usersTableBody">
                                @foreach($users as $user)
                                <tr class="user-row hover:bg-slate-50/50 transition" data-role="{{ $user->role }}">
                                    <td class="p-4 font-bold text-slate-800">{{ $user->name }}</td>
                                    <td class="p-4 text-slate-600 font-medium">{{ $user->email }}</td>
                                    <td class="p-4 text-center">
                                        @if($user->role == 'admin')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold bg-slate-800 text-white">ADMINISTRATOR</span>
                                        @elseif($user->role == 'front_office')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold bg-emerald-100 text-emerald-700">FRONT OFFICE</span>
                                        @elseif($user->role == 'housekeeping')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold bg-amber-100 text-amber-700">HOUSEKEEPING</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold bg-slate-100 text-slate-600">TAMU (GUEST)</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center space-x-2 whitespace-nowrap">
                                        <a href="/admin/users/{{ $user->id }}/edit" class="inline-block bg-amber-100 text-amber-700 hover:bg-amber-200 px-3 py-1.5 rounded-md text-xs font-bold transition">Edit</a>
                                        <form action="/admin/users/{{ $user->id }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
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

    <!-- SCRIPT UNTUK TAB NAVIGASI -->
    <script>
        function filterUsers(role, clickedBtn) {
            // Ubah gaya semua tombol menjadi tidak aktif
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('bg-slate-800', 'text-white');
                btn.classList.add('bg-slate-100', 'text-slate-600');
            });
            
            // Ubah gaya tombol yang diklik menjadi aktif
            clickedBtn.classList.remove('bg-slate-100', 'text-slate-600');
            clickedBtn.classList.add('bg-slate-800', 'text-white');

            // Filter baris tabel
            document.querySelectorAll('.user-row').forEach(row => {
                if (role === 'all' || row.getAttribute('data-role') === role) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>