<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Kamar - Front Office</title>
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
                <a href="/fo/inhouse" class="flex items-center px-4 py-3 text-slate-400 hover:text-white hover:bg-slate-800 border-l-4 border-transparent rounded-r-lg font-medium transition-all">
                    <span class="mr-3 text-lg">🛏️</span>
                    <span class="text-sm">Tamu Menginap</span>
                </a>
                <a href="/fo/history" class="flex items-center px-4 py-3 text-slate-400 hover:text-white hover:bg-slate-800 border-l-4 border-transparent rounded-r-lg font-medium transition-all">
                    <span class="mr-3 text-lg">📜</span>
                    <span class="text-sm">Riwayat Check-out</span>
                </a>
                <a href="/fo/rooms" class="flex items-center px-4 py-3 bg-emerald-500/10 text-emerald-400 border-l-4 border-emerald-500 rounded-r-lg font-medium transition-all">
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
                <h2 class="text-2xl font-bold text-slate-800">Pemantauan Status Kamar</h2>
                <p class="text-sm text-slate-500">Pantau ketersediaan dan kebersihan kamar secara real-time.</p>
            </div>
        </header>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($rooms as $room)
                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-2xl font-bold text-slate-800">{{ $room->room_number }}</h3>
                        @if($room->status == 'available')
                            <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-md text-xs font-bold">Tersedia</span>
                        @elseif($room->status == 'dirty')
                            <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-md text-xs font-bold">Kotor</span>
                        @elseif($room->status == 'occupied')
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-md text-xs font-bold">Terisi</span>
                        @elseif($room->status == 'cleaning')
                            <span class="bg-sky-100 text-sky-700 px-3 py-1 rounded-md text-xs font-bold">Dibersihkan</span>
                        @endif
                    </div>
                    
                    <div class="mb-6">
                        <p class="text-sm font-semibold text-slate-700">{{ $room->roomType->type_name }}</p>
                        <p class="text-xs text-slate-500 mt-1">Lantai {{ $room->floor }} • Kapasitas: {{ $room->roomType->Max_occupancy }} Org</p>
                    </div>
                    
                    <div class="border-t border-slate-100 pt-4 text-center">
                        @if($room->status == 'available')
                            <p class="text-xs font-medium text-slate-400">Siap menerima tamu</p>
                        @elseif($room->status == 'dirty')
                            <p class="text-xs font-medium text-amber-500">Menunggu Housekeeping</p>
                        @elseif($room->status == 'occupied')
                            <p class="text-xs font-medium text-blue-500">Tamu sedang menginap</p>
                        @elseif($room->status == 'cleaning')
                            <p class="text-xs font-medium text-sky-500">Sedang dibersihkan HK</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</body>
</html>