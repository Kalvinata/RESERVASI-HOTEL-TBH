<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Tamu - The Beach House</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;500&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden">

   <aside class="w-64 bg-white border-r border-slate-200 flex flex-col justify-between hidden md:flex z-10 shadow-sm flex-shrink-0">
        
        <div>
            <div class="h-20 flex items-center px-6 border-b border-slate-100 bg-slate-800">
                <h1 class="text-2xl font-serif text-white font-bold">The Beach House</h1>
            </div>

            <nav class="p-4 space-y-3 mt-2">
                
                <a href="/guest" class="flex items-center px-4 py-3 rounded-xl transition-all font-medium border {{ request()->is('guest') ? 'bg-slate-100 text-slate-800 border-slate-200 shadow-sm' : 'border-transparent text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                    <span class="mr-3 text-lg">🛏️</span>
                    <span class="text-sm">Pesan Kamar</span>
                </a>
                
                <a href="/guest/profile" class="flex items-center px-4 py-3 rounded-xl transition-all font-medium border {{ request()->is('guest/profile') ? 'bg-slate-100 text-slate-800 border-slate-200 shadow-sm' : 'border-transparent text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                    <span class="mr-3 text-lg">👤</span>
                    <span class="text-sm">Profil Saya</span>
                </a>
                
                <a href="/guest/history" class="flex items-center px-4 py-3 rounded-xl transition-all font-medium border {{ request()->is('guest/history') ? 'bg-slate-100 text-slate-800 border-slate-200 shadow-sm' : 'border-transparent text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                    <span class="mr-3 text-lg">📜</span>
                    <span class="text-sm">Riwayat Pemesanan</span>
                </a>

            </nav>
        </div>

        <div class="p-5 border-t border-slate-100 bg-slate-50/50">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-white font-bold text-lg mr-3 shadow-inner">
                    {{ Auth::check() ? substr(Auth::user()->name, 0, 1) : 'G' }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-bold text-slate-800 truncate">{{ Auth::check() ? Auth::user()->name : 'Tamu' }}</p>
                    <p class="text-[11px] text-slate-500 truncate">Akun Guest</p>
                </div>
            </div>
            
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center px-4 py-2.5 border border-red-200 text-red-600 bg-white rounded-lg hover:bg-red-50 hover:border-red-300 transition-colors text-sm font-semibold">
                    Keluar Akun
                </button>
            </form>
        </div>
    </aside>


    <main class="flex-1 overflow-y-auto bg-slate-50">
        
        <div class="bg-slate-800 text-white py-16 px-8 text-center relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-3xl font-serif mb-3">Temukan Kenyamanan Anda</h2>
                <p class="text-slate-300 max-w-2xl mx-auto text-sm leading-relaxed">Kamar eksklusif kami dirancang untuk memberikan pengalaman menginap yang tak terlupakan di Gili Trawangan.</p>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-8 py-10">
            <div class="flex items-center mb-6">
                <div class="w-1.5 h-6 bg-slate-800 mr-3 rounded-full"></div>
                <h3 class="text-xl font-bold text-slate-800">Kamar Tersedia</h3>
            </div>
            
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                @foreach($rooms as $room)
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 hover:shadow-lg overflow-hidden flex flex-col md:flex-row transition-all duration-300 group">
                    
                    <a href="/guest/room/{{ $room->id }}" class="md:w-2/5 h-56 md:h-auto overflow-hidden relative bg-slate-200 block cursor-pointer group-hover:shadow-inner">
                         <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?q=80&w=1000&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="Room Image">
    
                                     <div class="absolute inset-0 bg-slate-900 bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                         <span class="bg-white text-slate-800 text-sm font-bold px-4 py-2 rounded-lg opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 shadow-lg">
                     Lihat Detail
                 </span>
                 </div>
                </a>
                    
                    <div class="p-6 md:w-3/5 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="text-xl font-serif text-slate-800 font-bold">{{ $room->roomType->type_name }}</h4>
                                <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs px-2.5 py-1 rounded-md font-bold">No. {{ $room->room_number }}</span>
                            </div>
                            <p class="text-sm text-slate-500 mb-4 line-clamp-2">{{ $room->roomType->description ?? 'Fasilitas premium menanti Anda.' }}</p>
                            
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="text-[11px] font-medium bg-slate-50 text-slate-600 px-2 py-1 rounded border border-slate-200 flex items-center">
                                    👥 Max {{ $room->roomType->Max_occupancy }} Org
                                </span>
                                <span class="text-[11px] font-medium bg-slate-50 text-slate-600 px-2 py-1 rounded border border-slate-200 flex items-center">
                                    🏢 Lantai {{ $room->floor }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-end mt-4 pt-4 border-t border-slate-100">
                            <div>
                                <p class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold mb-0.5">Mulai Dari</p>
                                <p class="text-lg font-bold text-slate-800">Rp {{ number_format($room->roomType->base_price, 0, ',', '.') }}<span class="text-xs font-normal text-slate-500">/mlm</span></p>
                            </div>
                            
                            <a href="/guest/book/{{ $room->id }}" class="bg-slate-800 text-white text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-slate-900 transition-colors shadow-md inline-block">
                                Pilih Kamar
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>

</body>
</html>