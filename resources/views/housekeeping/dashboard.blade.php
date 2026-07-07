<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Housekeeping Panel - The Beach House</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(15px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-card {
            animation: fadeInUp 0.4s ease-out forwards;
        }
    </style>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden text-slate-800">

    <!-- SIDEBAR KIRI (SEKARANG KONSISTEN DENGAN WARNA SLATE & EMERALD) -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col justify-between hidden md:flex z-20 shadow-xl flex-shrink-0">
        <div>
            <div class="h-20 flex flex-col justify-center px-6 border-b border-slate-700 bg-slate-950">
                <h1 class="text-xl font-serif font-bold text-emerald-400 tracking-wide">TBH Staff</h1>
                <p class="text-[11px] text-slate-400 uppercase tracking-widest">Housekeeping Panel</p>
            </div>

            <nav class="p-4 space-y-2 mt-2">
                <a href="/hk/dashboard" class="flex items-center px-4 py-3 bg-emerald-500/10 text-emerald-400 border-l-4 border-emerald-500 rounded-r-lg font-medium transition-all">
                    <span class="mr-3 text-lg">🧹</span>
                    <span class="text-sm">Tugas Kebersihan</span>
                </a>
            </nav>
        </div>

        <!-- Informasi Akun -->
        <div class="p-5 border-t border-slate-800 bg-slate-950/50">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center text-white font-bold shadow-lg">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="ml-3 overflow-hidden">
                    <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[11px] text-emerald-400 truncate">Staf Kebersihan</p>
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

    <!-- KONTEN UTAMA -->
    <main class="flex-1 overflow-y-auto bg-slate-50 flex flex-col">
        
        <header class="bg-white border-b border-slate-200 px-8 py-5 flex items-center justify-between sticky top-0 z-10 shadow-sm">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Daftar Kamar Kotor & Pembersihan</h2>
                <p class="text-sm text-slate-500">Segera bersihkan kamar agar dapat disewakan kembali oleh sistem.</p>
            </div>
        </header>

        <div class="p-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Kamar Kotor -->
                <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex items-center justify-between border-l-4 border-l-rose-500">
                    <div>
                        <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider mb-1">Perlu Dibersihkan</p>
                        <p class="text-3xl font-bold text-slate-800">{{ $dirtyCount ?? 0 }} <span class="text-sm font-normal text-slate-400">Kamar</span></p>
                    </div>
                    <div class="w-12 h-12 bg-rose-50 rounded-full flex items-center justify-center text-rose-500 text-2xl">⚠️</div>
                </div>

                <!-- Sedang Dibersihkan -->
                <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex items-center justify-between border-l-4 border-l-blue-500">
                    <div>
                        <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider mb-1">Sedang Proses Kerja</p>
                        <p class="text-3xl font-bold text-slate-800">{{ $cleaningCount ?? 0 }} <span class="text-sm font-normal text-slate-400">Kamar</span></p>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-500 text-2xl">⚡</div>
                </div>

                <!-- Kamar Siap Pakai -->
                <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex items-center justify-between border-l-4 border-l-emerald-500">
                    <div>
                        <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider mb-1">Kamar Siap / Terisi</p>
                        <p class="text-3xl font-bold text-slate-800">{{ $readyCount ?? 0 }} <span class="text-sm font-normal text-slate-400">Kamar</span></p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-500 text-2xl">✨</div>
                </div>
            </div>

            <!-- TOMBOL FILTER LANTAI -->
            <div class="mb-6 flex gap-2 border-b border-slate-200 pb-4">
                <button onclick="filterFloor('all')" class="floor-btn px-4 py-2 bg-slate-800 text-white rounded-lg text-xs font-semibold shadow-sm transition-all">Semua Lantai</button>
                <button onclick="filterFloor('1')" class="floor-btn px-4 py-2 bg-white text-slate-600 border border-slate-200 rounded-lg text-xs font-semibold hover:bg-slate-50 transition-all">Lantai 1</button>
                <button onclick="filterFloor('2')" class="floor-btn px-4 py-2 bg-white text-slate-600 border border-slate-200 rounded-lg text-xs font-semibold hover:bg-slate-50 transition-all">Lantai 2</button>
            </div>

            <!-- AREA KARTU GRID KAMAR -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @if(isset($rooms) && count($rooms) > 0)
                    @foreach($rooms as $room)
                    <div class="room-card bg-white rounded-xl border border-slate-200 p-6 shadow-sm flex flex-col justify-between hover:shadow-md hover:-translate-y-1 transition-all duration-300 animate-card" data-floor="{{ $room->floor }}">
                        <div>
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-2xl font-bold text-slate-800">No. {{ $room->room_number }}</h3>
                                
                                @if($room->status == 'dirty')
                                    <span class="bg-rose-100 text-rose-700 px-2.5 py-1 rounded-md text-[11px] font-bold border border-rose-200 animate-pulse">KOTOR</span>
                                @elseif($room->status == 'cleaning')
                                    <span class="bg-blue-100 text-blue-700 px-2.5 py-1 rounded-md text-[11px] font-bold border border-blue-200">DIBERSIHKAN</span>
                                @elseif($room->status == 'available')
                                    <span class="bg-emerald-100 text-emerald-700 px-2.5 py-1 rounded-md text-[11px] font-bold border border-emerald-200">SIAP</span>
                                @elseif($room->status == 'occupied')
                                    <span class="bg-slate-100 text-slate-700 px-2.5 py-1 rounded-md text-[11px] font-bold border border-slate-200">TERISI</span>
                                @endif
                            </div>
                            
                            <div class="mb-6">
                                <p class="text-sm font-semibold text-slate-700">{{ $room->roomType->type_name }}</p>
                                <p class="text-xs text-slate-400 font-medium mt-1">Lantai {{ $room->floor }} • Maks {{ $room->roomType->Max_occupancy }} Orang</p>
                            </div>
                        </div>
                        
                        <div class="border-t border-slate-100 pt-4">
                            @if($room->status == 'dirty')
                                <form action="/hk/room/{{ $room->id }}/start" method="POST">
                                    @csrf
                                    <!-- Tombol Biru untuk Mulai Kerja -->
                                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2.5 rounded-lg text-xs font-bold transition shadow-sm">
                                        🚀 Mulai Bersihkan
                                    </button>
                                </form>
                            @elseif($room->status == 'cleaning')
                                <form action="/hk/room/{{ $room->id }}/finish" method="POST">
                                    @csrf
                                    <!-- Tombol Hijau jika Selesai -->
                                    <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white py-2.5 rounded-lg text-xs font-bold transition shadow-sm">
                                        ✅ Selesai & Kamar Siap
                                    </button>
                                </form>
                            @else
                                <div class="text-center text-xs text-slate-400 font-medium italic py-2">
                                    Tidak ada tugas pembersihan ✓
                                </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>

        </div>
    </main>

    <!-- SCRIPT JAVASCRIPT FILTER LANTAI -->
    <script>
        function filterFloor(floor) {
            const cards = document.querySelectorAll('.room-card');
            const buttons = document.querySelectorAll('.floor-btn');
            
            buttons.forEach(btn => {
                btn.classList.remove('bg-slate-800', 'text-white');
                btn.classList.add('bg-white', 'text-slate-600', 'border', 'border-slate-200');
            });
            event.target.classList.remove('bg-white', 'text-slate-600', 'border', 'border-slate-200');
            event.target.classList.add('bg-slate-800', 'text-white');

            cards.forEach(card => {
                if (floor === 'all' || card.getAttribute('data-floor') === floor) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>