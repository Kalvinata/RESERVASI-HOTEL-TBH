<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tamu Menginap - Front Office</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style> body { font-family: 'Poppins', sans-serif; } .font-serif { font-family: 'Playfair Display', serif; } </style>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden text-slate-800">

    <aside class="w-64 bg-slate-900 text-white flex flex-col justify-between hidden md:flex z-20 shadow-xl flex-shrink-0">
        <div>
            <div class="h-20 flex flex-col justify-center px-6 border-b border-slate-700 bg-slate-950">
                <h1 class="text-xl font-serif font-bold text-emerald-400 tracking-wide">Front Office</h1>
                <p class="text-[11px] text-slate-400 uppercase tracking-widest">Resepsionis Panel</p>
            </div>
            
            <nav class="p-4 space-y-2 mt-2">
                <a href="/fo/dashboard" class="flex items-center px-4 py-3 text-slate-400 hover:text-white hover:bg-slate-800 border-l-4 border-transparent rounded-r-lg font-medium transition-all">
                    <span class="mr-3 text-lg">📋</span>
                    <span class="text-sm">Data Reservasi</span>
                </a>
                <a href="/fo/inhouse" class="flex items-center px-4 py-3 bg-emerald-500/10 text-emerald-400 border-l-4 border-emerald-500 rounded-r-lg font-medium transition-all">
                    <span class="mr-3 text-lg">🛏️</span>
                    <span class="text-sm">Tamu Menginap</span>
                </a>
                <a href="/fo/history" class="flex items-center px-4 py-3 text-slate-400 hover:text-white hover:bg-slate-800 border-l-4 border-transparent rounded-r-lg font-medium transition-all">
                    <span class="mr-3 text-lg">📜</span>
                    <span class="text-sm">Riwayat Check-out</span>
                </a>
                <a href="/fo/rooms" class="flex items-center px-4 py-3 text-slate-400 hover:text-white hover:bg-slate-800 border-l-4 border-transparent rounded-r-lg font-medium transition-all">
                    <span class="mr-3 text-lg">🔑</span>
                    <span class="text-sm">Status Kamar</span>
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
                    <p class="text-[11px] text-emerald-400 truncate">Petugas FO</p>
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
        <header class="bg-white border-b border-slate-200 px-8 py-5 sticky top-0 z-10 shadow-sm flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Daftar Tamu Sedang Menginap (In-House)</h2>
                <p class="text-sm text-slate-500">Kelola tamu yang saat ini berada di kamar.</p>
            </div>
        </header>

        <div class="p-8">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-5 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                    <form action="/fo/inhouse" method="GET" class="flex items-center gap-3">
                        <label class="text-sm font-medium text-slate-600">Filter Check-in:</label>
                        <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-slate-900 transition">Filter</button>
                        <a href="/fo/inhouse" class="text-sm text-red-500 hover:underline">Reset</a>
                    </form>
                </div>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white border-b border-slate-200 text-xs uppercase text-slate-500">
                            <th class="p-4 font-semibold">Tamu</th>
                            <th class="p-4 font-semibold">Kamar</th>
                            <th class="p-4 font-semibold">Tanggal Check-out</th>
                            <th class="p-4 font-semibold text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @foreach($reservations as $res)
                        <tr class="hover:bg-slate-50/50">
                            <td class="p-4 font-bold text-slate-800">{{ $res->user->name ?? 'Tamu' }}</td>
                            <td class="p-4">
                                <span class="bg-slate-800 text-white px-2 py-1 rounded text-xs">No. {{ $res->room->room_number }}</span>
                            </td>
                            <td class="p-4 text-rose-600 font-bold">{{ \Carbon\Carbon::parse($res->check_out_date)->format('d M Y') }}</td>
                            <td class="p-4 text-right">
                                <form action="/fo/rooms/{{ $res->id }}/checkout" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-slate-700 hover:bg-slate-900 text-white px-4 py-2 rounded-lg text-xs font-bold transition shadow-sm" onclick="return confirm('Proses Check-out? Kamar akan dikosongkan dan info dikirim ke Housekeeping.')">
                                        Proses Check-out
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @if(count($reservations) == 0)
                        <tr>
                            <td colspan="4" class="p-8 text-center text-slate-500">Belum ada tamu yang menginap saat ini.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>