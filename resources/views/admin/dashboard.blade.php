<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Panel - The Beach House</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        @keyframes fadeInUp { 0% { opacity: 0; transform: translateY(15px); } 100% { opacity: 1; transform: translateY(0); } }
        .animate-card { animation: fadeInUp 0.4s ease-out forwards; }
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
                <a href="/admin/dashboard" class="flex items-center px-4 py-3 bg-emerald-500/10 text-emerald-400 border-l-4 border-emerald-500 rounded-r-lg font-medium transition-all">
                    <span class="mr-3 text-lg">📈</span> <span class="text-sm">Dashboard</span>
                </a>
                <a href="/admin/room-types" class="flex items-center px-4 py-3 text-slate-400 hover:text-white hover:bg-slate-800 border-l-4 border-transparent rounded-r-lg font-medium transition-all">
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
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="ml-3 overflow-hidden">
                    <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name }}</p>
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
                <h2 class="text-2xl font-bold text-slate-800">Ringkasan Sistem</h2>
                <p class="text-sm text-slate-500">Pantau performa dan kelola data utama The Beach House.</p>
            </div>
            <div class="text-right hidden md:block">
                <p class="text-sm font-medium text-slate-800">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</p>
            </div>
        </header>

        <div class="p-8">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex items-center justify-between border-l-4 border-l-blue-500 animate-card" style="animation-delay: 0s;">
                    <div>
                        <p class="text-xs text-slate-500 font-semibold uppercase mb-1">Total Kamar</p>
                        <p class="text-3xl font-bold text-slate-800">{{ $totalKamar }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-500 text-2xl">🚪</div>
                </div>

                <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex items-center justify-between border-l-4 border-l-purple-500 animate-card" style="animation-delay: 0.1s;">
                    <div>
                        <p class="text-xs text-slate-500 font-semibold uppercase mb-1">Tipe Kamar</p>
                        <p class="text-3xl font-bold text-slate-800">{{ $totalTipeKamar }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-50 rounded-full flex items-center justify-center text-purple-500 text-2xl">🛏️</div>
                </div>

                <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex items-center justify-between border-l-4 border-l-amber-500 animate-card" style="animation-delay: 0.2s;">
                    <div>
                        <p class="text-xs text-slate-500 font-semibold uppercase mb-1">Reservasi Aktif</p>
                        <p class="text-3xl font-bold text-slate-800">{{ $reservasiAktif }}</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-50 rounded-full flex items-center justify-center text-amber-500 text-2xl">📅</div>
                </div>

                <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex items-center justify-between border-l-4 border-l-emerald-500 animate-card" style="animation-delay: 0.3s;">
                    <div>
                        <p class="text-xs text-slate-500 font-semibold uppercase mb-1">Total Pendapatan</p>
                        <p class="text-2xl font-bold text-emerald-600">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-500 text-2xl">💰</div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden animate-card" style="animation-delay: 0.4s;">
                <div class="p-5 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800 text-lg">5 Reservasi Terbaru</h3>
                    <span class="text-xs font-semibold text-emerald-600 bg-emerald-100 px-3 py-1 rounded-full">Real-time Data</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-white border-b border-slate-200 text-xs uppercase text-slate-500 tracking-wider">
                                <th class="p-4 font-semibold">Tamu</th>
                                <th class="p-4 font-semibold">Kamar</th>
                                <th class="p-4 font-semibold">Jadwal</th>
                                <th class="p-4 font-semibold">Nilai Transaksi</th>
                                <th class="p-4 font-semibold text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @foreach($latestReservations as $res)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="p-4">
                                    <p class="font-bold text-slate-800">{{ $res->user->name ?? 'Tamu' }}</p>
                                    <p class="text-xs text-slate-500">{{ $res->reservation_code }}</p>
                                </td>
                                <td class="p-4">
                                    <p class="font-semibold text-slate-700">{{ $res->room->roomType->type_name ?? '-' }}</p>
                                    <p class="text-xs text-slate-500">No. {{ $res->room->room_number ?? '-' }}</p>
                                </td>
                                <td class="p-4 text-slate-600 font-medium">
                                    {{ \Carbon\Carbon::parse($res->check_in_date)->format('d M y') }} - 
                                    {{ \Carbon\Carbon::parse($res->check_out_date)->format('d M y') }}
                                </td>
                                <td class="p-4 font-bold text-slate-700">
                                    Rp {{ number_format($res->total_price, 0, ',', '.') }}
                                </td>
                                <td class="p-4 text-center">
                                    @if($res->status == 'pending')
                                        <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded text-[11px] font-bold uppercase tracking-wider border border-amber-200">Pending</span>
                                    @elseif($res->status == 'confirmed' || $res->status == 'checked_in')
                                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-[11px] font-bold uppercase tracking-wider border border-blue-200">Aktif</span>
                                    @else
                                        <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded text-[11px] font-bold uppercase tracking-wider border border-slate-200">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            
                            @if(count($latestReservations) == 0)
                            <tr>
                                <td colspan="5" class="p-8 text-center text-slate-500">
                                    <p class="font-medium">Belum ada data reservasi masuk ke dalam sistem.</p>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</body>
</html>