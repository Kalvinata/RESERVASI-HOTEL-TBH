<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - The Beach House</title>
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
            <a href="/admin/dashboard" class="block py-2.5 px-4 rounded transition bg-indigo-900 text-indigo-300 border-l-4 border-indigo-400">📈 Dashboard</a>
            <a href="/admin/room-types" class="block py-2.5 px-4 rounded transition hover:bg-indigo-900 text-slate-300">🛏️ Kelola Tipe Kamar</a>
            <a href="#" class="block py-2.5 px-4 rounded transition hover:bg-indigo-900 text-slate-300">🚪 Kelola Kamar</a>
            <a href="#" class="block py-2.5 px-4 rounded transition hover:bg-indigo-900 text-slate-300">👥 Kelola Pengguna</a>
        </nav>
        <div class="p-4 border-t border-indigo-900">
            <a href="/login" class="block py-2 text-center text-sm text-indigo-300 hover:text-white transition">Logout</a>
        </div>
    </aside>

    <main class="flex-grow p-8 max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-semibold text-slate-800">Ringkasan Sistem</h2>
                <p class="text-sm text-slate-500 mt-1">Pantau performa dan kelola data utama The Beach House</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-2xl">🚪</div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Total Kamar</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $totalRooms }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl">🛏️</div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Tipe Kamar</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $totalTypes }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center text-2xl">📅</div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Reservasi Aktif</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $totalReservations }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-2xl">💰</div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Total Pendapatan</p>
                    <p class="text-xl font-bold text-slate-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-8 text-center">
            <h3 class="text-xl font-semibold text-indigo-900 mb-2">Selamat Datang di Panel Administrator!</h3>
            <p class="text-indigo-700">Gunakan menu di sebelah kiri untuk mengelola data kamar, menambah tipe kamar baru, atau mengatur akses pengguna.</p>
        </div>

    </main>

</body>
</html>