<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Front Office Dashboard - The Beach House</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        ::-webkit-scrollbar { height: 8px; width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden text-slate-800">

    @php
        use Carbon\Carbon;
        $today = Carbon::today();
        
        $pendingPayments = \App\Models\Payment::where('status', 'pending')->count();
        $checkInToday = \App\Models\Reservation::whereDate('check_in_date', $today)->count();
        $checkOutToday = \App\Models\Reservation::whereDate('check_out_date', $today)->count();
        $availableRooms = \App\Models\Room::where('status', 'available')->count();
    @endphp

    <aside class="w-64 bg-slate-900 text-white flex flex-col justify-between hidden md:flex z-20 shadow-xl flex-shrink-0">
        <div>
            <div class="h-20 flex flex-col justify-center px-6 border-b border-slate-700 bg-slate-950">
                <h1 class="text-xl font-serif font-bold text-emerald-400 tracking-wide">Front Office</h1>
                <p class="text-[11px] text-slate-400 uppercase tracking-widest">Resepsionis Panel</p>
            </div>

            <nav class="p-4 space-y-2 mt-2">
                <a href="/fo/dashboard" class="flex items-center px-4 py-3 bg-emerald-500/10 text-emerald-400 border-l-4 border-emerald-500 rounded-r-lg font-medium transition-all">
                    <span class="mr-3 text-lg">📋</span>
                    <span class="text-sm">Data Reservasi</span>
                </a>
                <a href="/fo/inhouse" class="flex items-center px-4 py-3 text-slate-400 hover:text-white hover:bg-slate-800 border-l-4 border-transparent rounded-r-lg font-medium transition-all">
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
        <header class="bg-white border-b border-slate-200 px-8 py-5 flex items-center justify-between sticky top-0 z-10 shadow-sm">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Daftar Reservasi Masuk</h2>
                <p class="text-sm text-slate-500">Kelola kedatangan, pembayaran, dan informasi tamu hari ini.</p>
            </div>
            <div class="text-right hidden md:block">
                <p class="text-sm font-medium text-slate-800">{{ Carbon::now()->isoFormat('dddd, D MMMM Y') }}</p>
                <p class="text-xs text-slate-500">Waktu Server: <span class="font-mono text-emerald-600">{{ Carbon::now()->format('H:i') }}</span></p>
            </div>
        </header>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <a href="#reservationTable" class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex items-center justify-between border-l-4 border-l-amber-400 hover:shadow-md hover:-translate-y-1 transition-all cursor-pointer">
                    <div>
                        <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider mb-1">Menunggu Bayar</p>
                        <p class="text-3xl font-bold text-slate-800">{{ $pendingPayments }}</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-50 rounded-full flex items-center justify-center text-amber-500 text-2xl">⏳</div>
                </a>
                <a href="/fo/inhouse?tanggal={{ $today->format('Y-m-d') }}" class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex items-center justify-between border-l-4 border-l-blue-500 hover:shadow-md hover:-translate-y-1 transition-all cursor-pointer">
                    <div>
                        <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider mb-1">Check-in Hari Ini</p>
                        <p class="text-3xl font-bold text-slate-800">{{ $checkInToday }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-500 text-2xl">📥</div>
                </a>
                <a href="/fo/history?tanggal={{ $today->format('Y-m-d') }}" class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex items-center justify-between border-l-4 border-l-rose-500 hover:shadow-md hover:-translate-y-1 transition-all cursor-pointer">
                    <div>
                        <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider mb-1">Check-out Hari Ini</p>
                        <p class="text-3xl font-bold text-slate-800">{{ $checkOutToday }}</p>
                    </div>
                    <div class="w-12 h-12 bg-rose-50 rounded-full flex items-center justify-center text-rose-500 text-2xl">📤</div>
                </a>
                <a href="/fo/rooms" class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex items-center justify-between border-l-4 border-l-emerald-500 hover:shadow-md hover:-translate-y-1 transition-all cursor-pointer">
                    <div>
                        <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider mb-1">Kamar Kosong</p>
                        <p class="text-3xl font-bold text-slate-800">{{ $availableRooms }}</p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-500 text-2xl">🔑</div>
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-5 border-b border-slate-100 bg-slate-50 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="relative w-full md:w-96">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">🔍</span>
                        <input type="text" id="searchInput" placeholder="Cari nama tamu atau kode (TBH-...)" class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none text-sm shadow-inner transition-all">
                    </div>
                    <div class="text-xs font-medium text-slate-500 flex gap-4">
                        <span class="flex items-center gap-1"><div class="w-2 h-2 rounded-full bg-amber-400"></div> Pending</span>
                        <span class="flex items-center gap-1"><div class="w-2 h-2 rounded-full bg-blue-500"></div> Confirmed</span>
                        <span class="flex items-center gap-1"><div class="w-2 h-2 rounded-full bg-emerald-500"></div> In House</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse" id="reservationTable">
                        <thead>
                            <tr class="bg-white border-b border-slate-200 text-xs uppercase text-slate-500 tracking-wider">
                                <th class="p-4 font-semibold">Kode & Jadwal</th>
                                <th class="p-4 font-semibold">Tamu</th>
                                <th class="p-4 font-semibold">Kamar</th>
                                <th class="p-4 font-semibold text-center">Status Bayar</th>
                                <th class="p-4 font-semibold text-center">Status Kamar</th>
                                <th class="p-4 font-semibold text-right">Tindakan FO</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            
                            @foreach($reservations as $res)
                            <tr class="hover:bg-slate-50/50 transition-colors search-row">
                                <td class="p-4">
                                    <p class="font-bold text-slate-800 search-kode">{{ $res->reservation_code }}</p>
                                    <p class="text-xs text-slate-500 mt-1">
                                        {{ Carbon::parse($res->check_in_date)->format('d M') }} - 
                                        {{ Carbon::parse($res->check_out_date)->format('d M Y') }}
                                    </p>
                                </td>
                                
                                <td class="p-4">
                                    <p class="font-bold text-slate-800 search-nama">{{ $res->user->name ?? 'Tamu' }}</p>
                                    @if($res->user && $res->user->phone)
                                        <a href="https://wa.me/{{ $res->user->phone }}" target="_blank" title="Hubungi via WhatsApp" class="text-xs text-emerald-600 font-medium hover:text-emerald-800 hover:underline mt-1 flex items-center w-max transition-colors">
                                            <span class="mr-1">📞</span> {{ $res->user->phone }}
                                        </a>
                                    @else
                                        <p class="text-xs text-slate-500 mt-1 flex items-center">
                                            <span class="mr-1">📞</span> -
                                        </p>
                                    @endif
                                </td>
                                
                                <td class="p-4">
                                    <p class="font-semibold text-slate-700">{{ $res->room->roomType->type_name }}</p>
                                    <p class="text-xs text-slate-500 mt-1">No. <span class="font-bold text-slate-700">{{ $res->room->room_number }}</span></p>
                                </td>
                                
                                <td class="p-4 text-center">
                                    @if($res->payment && $res->payment->status == 'paid')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">LUNAS</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold bg-amber-100 text-amber-700 border border-amber-200">BELUM BAYAR</span>
                                    @endif
                                </td>
                                
                                <td class="p-4 text-center">
                                    @if($res->status == 'pending')
                                        <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded text-xs font-semibold uppercase tracking-wider">Menunggu</span>
                                    @elseif($res->status == 'confirmed')
                                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-semibold uppercase tracking-wider border border-blue-200">Siap Masuk</span>
                                    @elseif($res->status == 'checked_in')
                                        <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded text-xs font-semibold uppercase tracking-wider border border-emerald-200">Tamu di Kamar</span>
                                    @endif
                                </td>
                                
                                <td class="p-4 text-right">
                                    @if($res->payment && $res->payment->status == 'pending')
                                        <form action="/fo/verify/{{ $res->id }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg text-xs font-bold transition shadow-sm" onclick="return confirm('Apakah tamu sudah melakukan pembayaran via Transfer/Tunai?')">
                                                Verifikasi Bayar
                                            </button>
                                        </form>
                                    @elseif($res->payment && $res->payment->status == 'paid' && ($res->status == 'pending' || $res->status == 'confirmed'))
                                        <form action="/fo/room-checkin/{{ $res->id }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-xs font-bold transition shadow-sm" onclick="return confirm('Proses Check-in tamu sekarang?')">
                                                Proses Check-in
                                            </button>
                                        </form>
                                    @elseif($res->status == 'checked_in')
                                        <form action="/fo/rooms/{{ $res->id }}/checkout" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-slate-700 hover:bg-slate-800 text-white px-4 py-2 rounded-lg text-xs font-bold transition shadow-sm" onclick="return confirm('Proses Check-out? Kamar akan dikosongkan dan info dikirim ke Housekeeping.')">
                                                Proses Check-out
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            
                            @if(count($reservations) == 0)
                            <tr>
                                <td colspan="6" class="p-8 text-center text-slate-500">
                                    <div class="text-4xl mb-3">🏖️</div>
                                    <p class="font-medium text-lg">Belum ada reservasi masuk.</p>
                                </td>
                            </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const tableRows = document.querySelectorAll('.search-row');
            searchInput.addEventListener('keyup', function() {
                const keyword = this.value.toLowerCase();
                tableRows.forEach(row => {
                    const kode = row.querySelector('.search-kode').textContent.toLowerCase();
                    const nama = row.querySelector('.search-nama').textContent.toLowerCase();
                    if (kode.includes(keyword) || nama.includes(keyword)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>