<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - The Beach House</title>
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
        
        <div class="bg-slate-800 text-white py-12 px-8 text-center relative overflow-hidden">
            <h2 class="text-3xl font-serif mb-2 relative z-10">Pengaturan Profil</h2>
            <p class="text-slate-300 text-sm relative z-10">Kelola informasi pribadi dan data kontak Anda</p>
        </div>

        <div class="max-w-3xl mx-auto px-8 py-10">
            
            @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 flex items-center">
                <span class="mr-2">✅</span> {{ session('success') }}
            </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-8">
                    <form action="/guest/profile" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="flex items-center gap-6 mb-8 pb-8 border-b border-slate-100">
                            <div class="w-20 h-20 rounded-full bg-slate-800 flex items-center justify-center text-white font-serif text-3xl shadow-lg">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-800">{{ Auth::user()->name }}</h3>
                                <p class="text-slate-500 text-sm">Bergabung sejak {{ Auth::user()->created_at->format('M Y') }}</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Alamat Email</label>
                            <input type="email" value="{{ Auth::user()->email }}" class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-slate-50 text-slate-500 cursor-not-allowed outline-none" readonly>
                            <p class="text-xs text-slate-400 mt-1">Email digunakan untuk login dan tidak dapat diubah.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ Auth::user()->name }}" class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:ring-2 focus:ring-slate-800 outline-none transition-all" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Nomor WhatsApp</label>
                                <input type="text" name="phone" value="{{ Auth::user()->phone }}" class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:ring-2 focus:ring-slate-800 outline-none transition-all" required>
                            </div>
                        </div>

                        <div class="pt-4 flex justify-end">
                            <button type="submit" class="bg-slate-800 text-white px-8 py-3 rounded-xl font-medium hover:bg-slate-900 transition-colors shadow-md">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

</body>
</html>