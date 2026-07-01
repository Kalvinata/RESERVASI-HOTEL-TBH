<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Kamar - FO The Beach House</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex">

    <aside class="w-64 bg-slate-900 text-white min-h-screen flex flex-col hidden md:flex">
        <div class="p-6 border-b border-slate-800">
            <h1 class="text-xl font-semibold tracking-wider">Front Office</h1>
            <p class="text-xs text-slate-400 mt-1">Panel Reservasi</p>
        </div>
        <nav class="flex-grow p-4 space-y-2">
            <a href="/fo/dashboard" class="block py-2.5 px-4 rounded transition hover:bg-slate-800 text-slate-300">📊 Data Reservasi</a>
            <a href="/fo/rooms" class="block py-2.5 px-4 rounded transition bg-slate-800 text-emerald-400 border-l-4 border-emerald-400">🛏️ Status Kamar</a>
        </nav>
        <div class="p-4 border-t border-slate-800">
            <a href="/login" class="block py-2 text-center text-sm text-slate-400 hover:text-white transition">Logout</a>
        </div>
    </aside>

    <main class="flex-grow p-8 max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-semibold text-slate-800">Pemantauan Status Kamar</h2>
                <p class="text-sm text-slate-500 mt-1">Pantau ketersediaan dan kebersihan kamar secara real-time</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($rooms as $room)
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex flex-col justify-between hover:shadow-md transition">
                <div>
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-2xl font-bold text-slate-800">{{ $room->room_number }}</h3>
                        
                        @if($room->status == 'available')
                            <span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded text-xs font-semibold">Tersedia</span>
                        @elseif($room->status == 'occupied')
                            <span class="bg-rose-100 text-rose-700 px-2 py-1 rounded text-xs font-semibold">Terisi</span>
                        @elseif($room->status == 'dirty')
                            <span class="bg-amber-100 text-amber-700 px-2 py-1 rounded text-xs font-semibold">Kotor</span>
                        @elseif($room->status == 'cleaning')
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-semibold">Dibersihkan</span>
                        @endif
                    </div>
                    <p class="text-sm font-medium text-slate-700">{{ $room->roomType->type_name }}</p>
                    <p class="text-xs text-slate-500 mt-1">Lantai {{ $room->floor }} • Kapasitas: {{ $room->roomType->Max_occupancy }}</p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100">
                    @if($room->status == 'occupied')
                        <form action="/fo/rooms/{{ $room->id }}/checkout" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-rose-50 text-rose-600 border border-rose-200 py-2 rounded-lg text-sm font-medium hover:bg-rose-600 hover:text-white transition">
                                Proses Check-out
                            </button>
                        </form>
                    @elseif($room->status == 'available')
                        <p class="text-xs text-center text-slate-400">Siap menerima tamu</p>
                    @elseif($room->status == 'dirty')
                        <p class="text-xs text-center text-amber-500 font-medium">Menunggu Housekeeping</p>
                    @elseif($room->status == 'cleaning')
                        <p class="text-xs text-center text-blue-500 font-medium">Sedang dibersihkan...</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </main>

</body>
</html>