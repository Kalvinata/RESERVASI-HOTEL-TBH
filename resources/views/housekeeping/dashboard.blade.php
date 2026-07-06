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

    <aside class="w-64 bg-amber-900 text-white min-h-screen flex flex-col hidden md:flex flex-shrink-0">
        <div class="p-6 border-b border-amber-800">
            <h1 class="text-xl font-bold tracking-wider">TBH Staff</h1>
            <p class="text-xs text-amber-300 mt-1">Panel Housekeeping</p>
        </div>
        <nav class="flex-grow p-4 space-y-2">
            <a href="/hk/dashboard" class="block py-2.5 px-4 rounded transition bg-amber-800 text-amber-200 border-l-4 border-amber-400 font-medium">🧹 Tugas Kebersihan</a>
        </nav>
        <div class="p-4 border-t border-amber-800">
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="w-full text-center block py-2 text-sm text-amber-300 hover:text-white transition font-medium">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-grow p-8 max-w-5xl mx-auto w-full">
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-slate-800">Daftar Kamar Kotor & Pembersihan</h2>
            <p class="text-sm text-slate-500 mt-1 font-medium">Segera bersihkan kamar agar dapat disewakan kembali oleh sistem</p>
        </div>

        @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 flex items-center shadow-sm text-sm font-medium">
            <span class="mr-2">✨</span> {{ session('success') }}
        </div>
        @endif

        @if($rooms->isEmpty())
            <div class="bg-white rounded-2xl border border-emerald-100 p-12 text-center shadow-sm max-w-2xl mx-auto mt-10">
                <div class="text-5xl mb-4">✨</div>
                <h3 class="text-xl font-bold text-slate-800 mb-1">Kerja Bagus!</h3>
                <p class="text-slate-500 text-sm">Semua kamar sudah bersih, rapi, dan siap disewakan.</p>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-600 text-xs font-semibold uppercase border-b border-slate-200">
                                <th class="p-4">Nomor Kamar</th>
                                <th class="p-4">Tipe Kamar</th>
                                <th class="p-4">Status Saat Ini</th>
                                <th class="p-4 text-center">Aksi Kebersihan</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach($rooms as $room)
                            <tr class="border-b border-slate-100 hover:bg-slate-50/80 transition">
                                <td class="p-4 font-bold text-slate-800">
                                    Kamar No. {{ $room->room_number }} (Lantai {{ $room->floor }})
                                </td>
                                <td class="p-4 text-slate-600 font-medium">
                                    {{ $room->roomType->type_name }}
                                </td>
                                <td class="p-4">
                                    @if($room->status == 'dirty')
                                        <span class="inline-block bg-red-50 text-red-600 px-2.5 py-1 rounded-md text-xs font-bold border border-red-100">🛑 Perlu Dibersihkan</span>
                                    @elseif($room->status == 'cleaning')
                                        <span class="inline-block bg-amber-50 text-amber-600 px-2.5 py-1 rounded-md text-xs font-bold border border-amber-100 animate-pulse">🧹 Sedang Dibersihkan</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    @if($room->status == 'dirty')
                                        <form action="/hk/room-start/{{ $room->id }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-amber-600 text-white px-4 py-2 rounded-lg text-xs font-semibold hover:bg-amber-700 transition shadow-sm">
                                                Mulai Bersihkan
                                            </button>
                                        </form>
                                    @elseif($room->status == 'cleaning')
                                        <form action="/hk/room-finish/{{ $room->id }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-xs font-semibold hover:bg-emerald-700 transition shadow-sm">
                                                Tandai Selesai
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </main>

</body>
</html>