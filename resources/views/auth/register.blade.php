<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun - The Beach House</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;500&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-xl bg-white rounded-2xl shadow-xl p-8 md:p-12">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-serif text-slate-800 mb-2">The Beach House</h1>
            <p class="text-sm text-slate-500">Pendaftaran Akun Tamu</p>
        </div>

        <form action="/register" method="POST" class="space-y-4">
            @csrf 
            
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:ring-2 focus:ring-slate-800 focus:outline-none" placeholder="Masukkan nama sesuai KTP" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:ring-2 focus:ring-slate-800 focus:outline-none" placeholder="tamu@email.com" required>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Nomor WhatsApp</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:ring-2 focus:ring-slate-800 focus:outline-none" placeholder="08123456789" required>
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Password</label>
                    <input type="password" name="password" class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:ring-2 focus:ring-slate-800 focus:outline-none" placeholder="Minimal 8 karakter" required>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:ring-2 focus:ring-slate-800 focus:outline-none" placeholder="Ulangi password" required>
                </div>
            </div>

            <button type="submit" class="w-full bg-slate-800 text-white font-medium py-3 rounded-lg hover:bg-slate-900 transition-colors mt-6">
                Daftar Sekarang
            </button>
        </form> <p class="text-center text-sm text-slate-600 mt-6">
            Sudah memiliki akun? 
            <a href="/login" class="text-slate-800 font-medium hover:underline">Masuk di sini</a>
        </p>
    </div>

</body>
</html>