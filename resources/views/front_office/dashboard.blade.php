<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard FO - The Beach House</title>
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
            <a href="/fo/dashboard" class="block py-2.5 px-4 rounded transition bg-slate-800 text-emerald-400 border-l-4 border-emerald-400">📊 Data Reservasi</a>
            <a href="/fo/rooms" class="block py-2.5 px-4 rounded transition hover:bg-slate-800 text-slate-300">🛏️ Status Kamar</a>
        </nav>
        <div class="p-4 border-t border-slate-800">
            <a href="/login" class="block py-2 text-center text-sm text-slate-400 hover:text-white transition">Logout</a>
        </div>
    </aside>

    <main class="flex-grow p-8 max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-semibold text-slate-800">Daftar Reservasi Masuk</h2>
                <p class="text-sm text-slate-500 mt-1">Kelola konfirmasi dan pembayaran tamu</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600 text-sm border-b border-slate-200">
                            <th class="p-4 font-medium">Kode / Tanggal</th>
                            <th class="p-4 font-medium">Kamar</th>
                            <th class="p-4 font-medium">Status Bayar</th>
                            <th class="p-4 font-medium">Status Reservasi</th>
                            <th class="p-4 font-medium text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach($reservations as $res)
                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                            <td class="p-4">
                                <p class="font-semibold text-slate-800">{{ $res->reservation_code }}</p>
                                <p class="text-xs text-slate-500 mt-1">{{ \Carbon\Carbon::parse($res->check_in_date)->format('d M') }} - {{ \Carbon\Carbon::parse($res->check_out_date)->format('d M Y') }}</p>
                            </td>
                            <td class="p-4">
                                <p class="font-medium text-slate-700">{{ $res->room->roomType->type_name }}</p>
                                <p class="text-xs text-slate-500">Kamar No. {{ $res->room->room_number }}</p>
                            </td>
                            <td class="p-4">
                                @if($res->payment && $res->payment->proof_image_path)
                                    <span class="inline-block bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-medium border border-blue-200">Ada Bukti</span>
                                @else
                                    <span class="inline-block bg-orange-100 text-orange-700 px-2 py-1 rounded text-xs font-medium border border-orange-200">Menunggu</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <span class="inline-block bg-slate-100 text-slate-600 px-2 py-1 rounded text-xs font-medium uppercase tracking-wider">{{ $res->status }}</span>
                            </td>
                            <td class="p-4 text-center">
                                @if($res->status == 'confirmed')
                                <form action="/fo/room-checkin/{{ $res->id }}" method="POST">
                                      @csrf
                                     <button type="submit" class="bg-blue-600 text-white px-3 py-1.5 rounded text-xs font-medium hover:bg-blue-700 transition">
                                           Check-in
                                        </button>
                                         </form>
                                           @elseif($res->status == 'checked_in')
                                             <span class="text-blue-600 font-bold text-xs">✓ Tamu di Kamar</span>
                                                 @else
                                                     <form action="/fo/verify/{{ $res->id }}" method="POST">
                                               @csrf
                                             <button type="submit" class="bg-emerald-600 text-white px-3 py-1.5 rounded text-xs font-medium hover:bg-emerald-700 transition">
                                          Verifikasi
                                        </button>
                                        </form>
                                        @endif
                                    </td>
                                 </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($reservations->isEmpty())
            <div class="p-8 text-center text-slate-500">
                Belum ada data reservasi yang masuk.
            </div>
            @endif
        </div>
    </main>

</body>
</html>