<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Housekeeping - The Beach House</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex">

    <aside class="w-64 bg-amber-900 text-white min-h-screen flex flex-col hidden md:flex">
        <div class="p-6 border-b border-amber-800">
            <h1 class="text-xl font-semibold tracking-wider">TBH Staff</h1>
            <p class="text-xs text-amber-400 mt-1">Panel Housekeeping</p>
        </div>
        <nav class="flex-grow p-4 space-y-2">
            <a href="/hk/dashboard" class="block py-2.5 px-4 rounded transition bg-amber-800 text-amber-300 border-l-4 border-amber-400">🧹 Tugas Kebersihan</a>
        </nav>
        <div class="p-4 border-t border-amber-800">
            <a href="/login" class="block py-2 text-center text-sm text-amber-400 hover:text-white transition">Logout</a>
        </div>
    </aside>

    <main class="flex-grow p-8 max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-semibold text-slate-800">Daftar Kamar Kotor</h2>
                <p class="text-sm text-slate-500 mt-1">Segera bersihkan kamar agar dapat disewakan kembali</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($rooms as $room)
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex flex-col justify-between hover:shadow-md transition">
                <div>
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-2xl font-bold text-slate-800">Kamar {{ $room->room_number }}</h3>
                        
                        @if($room->status == 'dirty')
                            <span class="bg-amber-100 text-amber-700 px-2 py-1 rounded text-xs font-semibold animate-pulse">Perlu Dibersihkan</span>
                        @elseif($room->status == 'cleaning')
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-semibold">Proses Pengerjaan</span>
                        @endif
                    </div>
                    <p class="text-sm font-medium text-slate-700">{{ $room->roomType->type_name }}</p>
                    <p class="text-xs text-slate-500 mt-1">Lantai {{ $room->floor }}</p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100">
                    @if($room->status == 'dirty')
                        <form action="/hk/rooms/{{ $room->id }}/start" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-amber-500 text-white py-2.5 rounded-lg text-sm font-medium hover:bg-amber-600 transition shadow-sm">
                                Ambil Tugas & Bersihkan
                            </button>
                        </form>
                    @elseif($room->status == 'cleaning')
                        <form action="/hk/rooms/{{ $room->id }}/finish" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow-sm">
                                Tandai Selesai (Tersedia)
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-full bg-emerald-50 border border-emerald-200 text-emerald-700 p-8 rounded-xl text-center">
                <div class="text-4xl mb-3">✨</div>
                <p class="font-medium text-lg">Kerja Bagus!</p>
                <p class="text-sm mt-1">Semua kamar sudah bersih dan siap disewakan.</p>
            </div>
            @endforelse
        </div>
    </main>

</body>
</html>