<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Kamar - The Beach House</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;500&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen">

    <nav class="bg-white shadow-sm py-4 px-8 flex justify-between items-center mb-8">
        <h1 class="text-2xl font-serif text-slate-800">The Beach House</h1>
        <a href="/guest" class="text-sm text-slate-600 hover:text-slate-900 transition">← Kembali ke Daftar Kamar</a>
    </nav>

    <div class="max-w-5xl mx-auto px-4 pb-12">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row">
            
            <div class="md:w-5/12 bg-slate-800 text-white p-8 md:p-10 flex flex-col justify-between">
                <div>
                    <h2 class="text-sm text-slate-300 uppercase tracking-wider mb-2">Ringkasan Pesanan</h2>
                    <h3 class="text-3xl font-serif mb-2">{{ $room->roomType->type_name }}</h3>
                    <p class="inline-block bg-slate-700 text-slate-200 px-3 py-1 rounded text-sm mb-6">Kamar No. {{ $room->room_number }}</p>
                    
                    <ul class="space-y-4 text-sm text-slate-300">
                        <li class="flex items-center gap-3">
                            <span class="text-xl">👥</span> Maksimal {{ $room->roomType->Max_occupancy }} Orang
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-xl">✨</span> 
                            <span>Fasilitas: <br>{{ $room->roomType->facilities }}</span>
                        </li>
                    </ul>
                </div>
                
                <div class="mt-12 pt-6 border-t border-slate-700">
                    <p class="text-sm text-slate-400">Harga per malam</p>
                    <p class="text-2xl font-semibold">Rp {{ number_format($room->roomType->base_price, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="md:w-7/12 p-8 md:p-10">
                <h3 class="text-xl font-medium text-slate-800 mb-6">Detail Reservasi</h3>
                
                <form action="/guest/book/{{ $room->id }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Tanggal Check-in</label>
                            <input type="date" name="check_in_date" class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:ring-2 focus:ring-slate-800 focus:outline-none" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Tanggal Check-out</label>
                            <input type="date" name="check_out_date" class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:ring-2 focus:ring-slate-800 focus:outline-none" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Catatan Tambahan (Opsional)</label>
                        <textarea name="notes" rows="3" class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:ring-2 focus:ring-slate-800 focus:outline-none" placeholder="Misal: Mohon siapkan ekstra bantal..."></textarea>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-lg border border-slate-100 mt-6">
                        <p class="text-sm text-slate-600 mb-2">Total Pembayaran Estimasi:</p>
                        <p class="text-2xl font-bold text-slate-800" id="total_price">-</p>
                    </div>

                    <button type="submit" class="w-full bg-slate-800 text-white font-medium py-3.5 rounded-lg hover:bg-slate-900 transition-colors mt-4">
                        Lanjut ke Pembayaran
                    </button>
                </form>
            </div>

        </div>
    </div>

</body>
</html>