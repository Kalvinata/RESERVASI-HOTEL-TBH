<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pemesanan - The Beach House</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        @keyframes slideUpFade {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-row {
            animation: slideUpFade 0.5s ease-out forwards;
            opacity: 0;
        }
    </style>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden text-slate-800">

    <aside class="w-64 bg-white border-r border-slate-200 flex flex-col justify-between hidden md:flex z-20 flex-shrink-0 shadow-sm">
        <div>
            <div class="h-20 flex flex-col justify-center px-6 bg-slate-900">
                <h1 class="text-2xl font-serif font-bold text-white tracking-wide">The Beach<br>House</h1>
            </div>
            <nav class="p-4 space-y-2 mt-2">
                <a href="/guest" class="flex items-center px-4 py-3 text-slate-500 hover:text-slate-800 hover:bg-slate-50 rounded-xl font-medium transition-all">
                    <span class="mr-3 text-lg">🛏️</span> <span class="text-sm">Pesan Kamar</span>
                </a>
                <a href="/guest/profile" class="flex items-center px-4 py-3 text-slate-500 hover:text-slate-800 hover:bg-slate-50 rounded-xl font-medium transition-all">
                    <span class="mr-3 text-lg">👤</span> <span class="text-sm">Profil Saya</span>
                </a>
                <a href="/guest/history" class="flex items-center px-4 py-3 bg-slate-100 text-slate-800 rounded-xl font-bold transition-all shadow-sm border border-slate-200">
                    <span class="mr-3 text-lg">📜</span> <span class="text-sm">Riwayat Pemesanan</span>
                </a>
            </nav>
        </div>
        <div class="p-5 border-t border-slate-100">
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center px-4 py-2 border border-red-200 text-red-600 rounded-lg hover:bg-red-50 hover:border-red-300 transition-colors text-xs font-semibold">Keluar Akun</button>
            </form>
        </div>
    </aside>

    <main class="flex-1 overflow-y-auto bg-slate-50 flex flex-col relative">
        
        <header class="bg-slate-900 px-8 py-8 sticky top-0 z-10 shadow-md flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-serif font-bold text-white tracking-wide">Riwayat Pemesanan</h2>
                <p class="text-sm text-slate-300 mt-2">Daftar kamar yang pernah atau sedang Anda pesan.</p>
            </div>
            <div class="hidden md:block">
                <span class="bg-white/10 text-white px-5 py-2.5 rounded-full text-xs font-semibold border border-white/20 backdrop-blur-sm shadow-inner">
                    Total: {{ count($reservations) }} Reservasi
                </span>
            </div>
        </header>

        <div class="p-8">
            <table class="w-full text-left border-separate" style="border-spacing: 0 12px;">
                <thead>
                    <tr class="text-xs uppercase text-slate-400 tracking-wider">
                        <th class="px-6 py-2 font-semibold">Kode Reservasi</th>
                        <th class="px-6 py-2 font-semibold">Kamar</th>
                        <th class="px-6 py-2 font-semibold">Jadwal Menginap</th>
                        <th class="px-6 py-2 font-semibold text-center">Status</th>
                        <th class="px-6 py-2 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $res)
                    <tr class="bg-white animate-row shadow-sm hover:shadow-md transition-all duration-300 ease-in-out transform hover:-translate-y-1 rounded-xl cursor-default" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                        <td class="px-6 py-5 border-y border-l border-slate-100 rounded-l-xl">
                            <span class="font-bold text-slate-800 bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-200 tracking-wide">{{ $res->reservation_code }}</span>
                        </td>
                        <td class="px-6 py-5 border-y border-slate-100">
                            <p class="font-bold text-slate-700 text-base">{{ $res->room->roomType->type_name }}</p>
                            <p class="text-xs text-slate-500 font-medium mt-0.5">Kamar No. <span class="text-slate-700 font-bold">{{ $res->room->room_number }}</span></p>
                        </td>
                        <td class="px-6 py-5 border-y border-slate-100 text-sm font-medium text-slate-600">
                            <div class="flex flex-col">
                                <span>Masuk: <span class="text-slate-800">{{ \Carbon\Carbon::parse($res->check_in_date)->format('d M Y') }}</span></span>
                                <span>Keluar: <span class="text-slate-800">{{ \Carbon\Carbon::parse($res->check_out_date)->format('d M Y') }}</span></span>
                            </div>
                        </td>
                        <td class="px-6 py-5 border-y border-slate-100 text-center">
                            @if($res->status == 'pending')
                                <span class="inline-flex items-center bg-amber-50 text-amber-600 px-3 py-1.5 rounded-md text-xs font-bold border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-2 animate-pulse"></span> Menunggu Bayar
                                </span>
                            @elseif($res->status == 'confirmed')
                                <span class="inline-flex items-center bg-blue-50 text-blue-600 px-3 py-1.5 rounded-md text-xs font-bold border border-blue-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2"></span> Dikonfirmasi
                                </span>
                            @elseif($res->status == 'checked_in')
                                <span class="inline-flex items-center bg-emerald-50 text-emerald-600 px-3 py-1.5 rounded-md text-xs font-bold border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2"></span> Sedang Menginap
                                </span>
                            @elseif($res->status == 'checked_out')
                                <span class="inline-flex items-center bg-slate-100 text-slate-500 px-3 py-1.5 rounded-md text-xs font-bold border border-slate-200">
                                    <span class="mr-1">✓</span> Selesai
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-5 border-y border-r border-slate-100 rounded-r-xl text-right">
                            @if($res->status == 'pending')
                                <a href="/guest/payment/{{ $res->id }}" class="inline-block bg-slate-800 hover:bg-slate-900 text-white px-5 py-2.5 rounded-lg text-xs font-bold transition-colors shadow-sm">
                                    Lihat Tagihan ➔
                                </a>
                            @else
                                <span class="text-xs text-slate-400 font-medium italic">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>