<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - The Beach House</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;500&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center">

    <div class="flex w-full max-w-4xl bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="hidden md:block w-1/2 bg-slate-800">
            <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?q=80&w=1000&auto=format&fit=crop" 
                 alt="Hotel Beach House" class="object-cover w-full h-full opacity-80 hover:opacity-100 transition-opacity duration-500">
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-serif text-slate-800 mb-2">The Beach House</h1>
                <p class="text-sm text-slate-500">Gili Trawangan, Lombok</p>
            </div>

            <h2 class="text-xl font-medium text-slate-700 mb-6">Selamat Datang Kembali</h2>

            <form action="#" method="POST" class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Email</label>
                    <input type="email" name="email" class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:ring-2 focus:ring-slate-800 focus:border-slate-800 outline-none transition-all" placeholder="tamu@email.com" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Password</label>
                    <input type="password" name="password" class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:ring-2 focus:ring-slate-800 focus:border-slate-800 outline-none transition-all" placeholder="••••••••" required>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center text-slate-600 cursor-pointer">
                        <input type="checkbox" class="mr-2 rounded border-slate-300 text-slate-800 focus:ring-slate-800"> Ingat saya
                    </label>
                    <a href="#" class="text-slate-500 hover:text-slate-800 transition-colors">Lupa Password?</a>
                </div>

                <button type="submit" class="w-full bg-slate-800 text-white font-medium py-3 rounded-lg hover:bg-slate-900 transition-colors duration-300">
                    Masuk ke Akun
                </button>
            </form>

            <p class="text-center text-sm text-slate-600 mt-8">
                Belum punya akun? 
                <a href="/register" class="text-slate-800 font-medium hover:underline">Buat Akun Reservasi</a>
            </p>
        </div>
    </div>

</body>
</html>