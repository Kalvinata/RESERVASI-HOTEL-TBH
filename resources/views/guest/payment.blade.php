<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pembayaran - The Beach House</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;500;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-2xl w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100 relative">
        
        <div class="bg-slate-800 text-center py-8 px-6 relative">
            <h2 class="text-2xl font-serif text-white mb-1">Invoice Reservasi</h2>
            <p class="text-sm text-slate-300">Kode: <span class="font-bold text-white">{{ $reservation->reservation_code }}</span></p>
        </div>

        <div class="p-8">
            <div class="flex justify-between items-start border-b border-slate-100 pb-6 mb-6">
                <div>
                    <p class="text-xs text-slate-400 uppercase tracking-wider mb-1">Kamar Dipesan</p>
                    <p class="font-semibold text-slate-800">{{ $reservation->room->roomType->type_name }} (No. {{ $reservation->room->room_number }})</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-slate-400 uppercase tracking-wider mb-1">Jadwal Menginap</p>
                    <p class="font-semibold text-slate-800">
                        {{ \Carbon\Carbon::parse($reservation->check_in_date)->format('d M Y') }} - 
                        {{ \Carbon\Carbon::parse($reservation->check_out_date)->format('d M Y') }}
                    </p>
                </div>
            </div>

            <div class="bg-slate-50 rounded-xl p-8 text-center border border-slate-100 mb-8">
                <p class="text-sm text-slate-500 mb-2">Total yang harus dibayar:</p>
                <p class="text-4xl font-bold text-slate-800 mb-6">Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</p>

                <div class="inline-flex bg-white border border-slate-200 rounded-xl p-4 items-center shadow-sm">
                    <div class="bg-blue-600 text-white font-bold italic px-3 py-1 rounded mr-4 text-sm">BCA</div>
                    <div class="text-left">
                        <p class="font-bold text-slate-800 tracking-wide text-lg">8765 4321 00</p>
                        <p class="text-xs text-slate-500">a.n. The Beach House Hotel</p>
                    </div>
                </div>
            </div>

            <div class="mt-4 flex flex-col gap-3">
                <a href="https://wa.me/6281234567890?text=Halo,%20saya%20ingin%20konfirmasi%20pembayaran%20dengan%20kode%20{{ $reservation->reservation_code }}" target="_blank" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl p-5 flex flex-col items-center justify-center text-center transition shadow-md">
                    <span class="text-3xl mb-2">💬</span>
                    <span class="font-bold text-lg">Konfirmasi via WhatsApp</span>
                    <span class="text-sm text-emerald-100 mt-1">Kirim foto struk transfer ke resepsionis kami</span>
                </a>

                <a href="/guest/history" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 rounded-xl p-4 flex items-center justify-center text-center transition font-semibold">
                    Selesai & Lihat Riwayat Pesanan ➔
                </a>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-100 flex justify-center">
                <form action="/guest/payment/{{ $reservation->id }}/cancel" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?');">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-red-500 hover:text-red-700 transition flex items-center">
                        <span class="mr-2">✕</span> Batalkan Reservasi & Kembali
                    </button>
                </form>
            </div>

        </div>
    </div>

</body>
</html>