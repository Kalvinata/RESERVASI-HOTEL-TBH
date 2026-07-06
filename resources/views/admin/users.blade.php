<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - Admin</title>
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
            <a href="/admin/room-types" class="block py-2.5 px-4 rounded transition hover:bg-indigo-900 text-slate-300">🛏️ Kelola Tipe Kamar</a>
            <a href="/admin/rooms" class="block py-2.5 px-4 rounded transition hover:bg-indigo-900 text-slate-300">🚪 Kelola Kamar</a>
            <a href="/admin/users" class="block py-2.5 px-4 rounded transition bg-indigo-900 text-indigo-300 border-l-4 border-indigo-400">👥 Kelola Pengguna</a>
        </nav>
        <div class="p-4 border-t border-indigo-900">
            <a href="/login" class="block py-2 text-center text-sm text-indigo-300 hover:text-white transition">Logout</a>
        </div>
    </aside>

    <main class="flex-grow p-8 max-w-7xl mx-auto overflow-y-auto h-screen">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-semibold text-slate-800">Kelola Pengguna (Staf)</h2>
                <p class="text-sm text-slate-500 mt-1">Buat akun untuk resepsionis, housekeeping, atau admin lainnya</p>
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
                    <h3 class="text-lg font-medium text-slate-800 mb-4 border-b border-slate-100 pb-2">Buat Akun Baru</h3>
                    
                    <form action="/admin/users" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" placeholder="Misal: Budi Santoso" class="w-full text-sm px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" required>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-1">Email</label>
                            <input type="email" name="email" placeholder="budi@hotel.com" class="w-full text-sm px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" required>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-1">Password</label>
                            <input type="password" name="password" placeholder="Minimal 8 karakter" class="w-full text-sm px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" required>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-1">Hak Akses (Role)</label>
                            <select name="role" class="w-full text-sm px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500 bg-white" required>
                                <option value="" disabled selected>-- Pilih Peran --</option>
                                <option value="admin">Admin (Manajer)</option>
                                <option value="front_office">Front Office (Resepsionis)</option>
                                <option value="housekeeping">Housekeeping (Pembersih)</option>
                                <option value="guest">Tamu (Guest)</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 text-white text-sm font-medium py-2.5 rounded-lg hover:bg-indigo-700 transition shadow-sm mt-2">
                            Simpan Akun
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-600 text-sm border-b border-slate-200">
                                <th class="p-4 font-medium">Nama Pengguna</th>
                                <th class="p-4 font-medium">Email</th>
                                <th class="p-4 font-medium">Hak Akses (Role)</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach($users as $user)
                            <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                                <td class="p-4 font-semibold text-slate-800">
                                    {{ $user->name }}
                                </td>
                                <td class="p-4 text-slate-600">
                                    {{ $user->email }}
                                </td>
                                <td class="p-4">
                                    @if($user->role == 'admin')
                                        <span class="inline-block bg-indigo-100 text-indigo-700 px-2 py-1 rounded text-xs font-semibold">Admin</span>
                                    @elseif($user->role == 'front_office')
                                        <span class="inline-block bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-semibold">Front Office</span>
                                    @elseif($user->role == 'housekeeping')
                                        <span class="inline-block bg-amber-100 text-amber-700 px-2 py-1 rounded text-xs font-semibold">Housekeeping</span>
                                    @else
                                        <span class="inline-block bg-slate-100 text-slate-700 px-2 py-1 rounded text-xs font-semibold">Tamu</span>
                                    @endif
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