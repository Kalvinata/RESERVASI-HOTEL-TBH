<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kamar - The Beach House</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap');
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
                <a href="/guest" class="flex items-center px-4 py-3 rounded-xl transition-all font-medium border {{ request()->is('guest') || request()->is('guest/room/*') ? 'bg-slate-100 text-slate-800 border-slate-200 shadow-sm' : 'border-transparent text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
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

    <main class="flex-1 overflow-y-auto bg-slate-50 relative">
        
        <div class="sticky top-0 z-20 bg-white/80 backdrop-blur-md border-b border-slate-200 px-8 py-4 flex items-center">
            <a href="/guest" class="flex items-center text-slate-500 hover:text-slate-800 transition-colors text-sm font-medium">
                <span class="mr-2">←</span> Kembali ke Daftar Kamar
            </a>
        </div>

        <div class="max-w-5xl mx-auto px-8 py-10">
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                
                <div>
                    <div class="rounded-2xl overflow-hidden shadow-lg h-[400px]">
                        <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?q=80&w=1000&auto=format&fit=crop" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700" alt="Detail Kamar">
                    </div>
                    
                    <div class="grid grid-cols-3 gap-4 mt-6">
                        <div class="bg-white p-4 rounded-xl border border-slate-100 text-center shadow-sm">
                            <p class="text-2xl mb-1">🏢</p>
                            <p class="text-xs text-slate-500 font-medium">Lantai {{ $room->floor }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-xl border border-slate-100 text-center shadow-sm">
                            <p class="text-2xl mb-1">👥</p>
                            <p class="text-xs text-slate-500 font-medium">Maks. {{ $room->roomType->Max_occupancy }} Org</p>
                        </div>
                        <div class="bg-white p-4 rounded-xl border border-slate-100 text-center shadow-sm">
                            <p class="text-2xl mb-1">🔑</p>
                            <p class="text-xs text-slate-500 font-medium">No. {{ $room->room_number }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col justify-between">
                    <div>
                        <div class="mb-2">
                            <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold tracking-wide">TERSEDIA</span>
                        </div>
                        <h2 class="text-4xl font-serif font-bold text-slate-800 mb-4">{{ $room->roomType->type_name }}</h2>
                        
                        <div class="prose prose-slate prose-sm text-slate-600 mb-8 leading-relaxed">
                            <p>
                                Nikmati kenyamanan istirahat Anda di {{ $room->roomType->type_name }}. Kamar ini didesain khusus untuk memberikan pengalaman menginap yang tenang dan mewah selama Anda berada di Gili Trawangan. Dilengkapi dengan perabotan modern dan sentuhan tropis yang khas.
                            </p>
                        </div>

                        <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
                            <span class="w-1 h-5 bg-slate-800 rounded-full mr-2"></span> Fasilitas Kamar
                        </h3>
                        <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm mb-6">
                            <p class="text-sm text-slate-600 leading-relaxed">
                                {{ $room->roomType->facilities ?? 'AC, TV Kabel, Wi-Fi Gratis, Kamar Mandi Dalam, Air Panas & Dingin, Perlengkapan Mandi.' }}
                            </p>
                        </div>

                        <div class="mb-8 p-4 border border-slate-200 rounded-xl bg-white shadow-sm flex items-center justify-between hover:border-emerald-300 transition-colors">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" id="breakfast-checkbox" class="w-5 h-5 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500 cursor-pointer">
                                <label for="breakfast-checkbox" class="font-medium text-slate-700 cursor-pointer flex flex-col">
                                    <span class="font-bold text-slate-800">Include Breakfast (Sarapan)</span>
                                    <span class="text-xs text-slate-500">+ Rp 50.000 / malam</span>
                                </label>
                            </div>
                            <div class="text-2xl">🍳</div>
                        </div>

                    </div>

                    <div class="bg-slate-800 p-6 rounded-2xl text-white shadow-xl flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-300 uppercase tracking-wider mb-1">Harga per Malam</p>
                            <p class="text-2xl font-bold" id="display-price">Rp {{ number_format($room->roomType->base_price, 0, ',', '.') }}</p>
                        </div>
                        <a href="/guest/book/{{ $room->id }}" id="btn-pesan" class="bg-white text-slate-800 font-bold px-6 py-3 rounded-xl hover:bg-slate-100 transition-colors shadow-md text-sm">
                            Pesan Sekarang
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('breakfast-checkbox');
            const priceDisplay = document.getElementById('display-price');
            const btnPesan = document.getElementById('btn-pesan');

            // Ambil harga dasar dari database Laravel
            const basePrice = {{ $room->roomType->base_price }};
            const breakfastPrice = 50000;
            
            // Simpan URL asli
            const baseUrl = '/guest/book/{{ $room->id }}';

            checkbox.addEventListener('change', function() {
                let total = basePrice;
                let currentUrl = baseUrl;

                if (this.checked) {
                    total += breakfastPrice;
                    currentUrl += '?breakfast=1'; // Bawa data sarapan ke form pesanan
                }

                // Ubah format angka menjadi format ribuan Rupiah
                const formattedPrice = total.toLocaleString('id-ID');
                
                priceDisplay.textContent = 'Rp ' + formattedPrice;
                btnPesan.href = currentUrl;
            });
        });
    </script>
</body>
</html>