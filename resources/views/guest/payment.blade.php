<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pembayaran - The Beach House</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;500;600&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen py-12 px-4">

    <div class="max-w-3xl mx-auto">
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-6 py-4 rounded-xl mb-6 text-center">
            <p class="font-medium">🎉 Reservasi Berhasil Dibuat!</p>
            <p class="text-sm mt-1">Selesaikan pembayaran agar kamar Anda segera dikonfirmasi.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-slate-800 text-white p-8 text-center border-b-4 border-slate-700">
                <h1 class="text-2xl font-serif mb-1">Invoice Reservasi</h1>
                <p class="text-slate-400 text-sm">Kode: <span class="text-white font-semibold tracking-wider">{{ $reservation->reservation_code }}</span></p>
            </div>

            <div class="p-8 md:p-10">
                <div class="flex flex-col md:flex-row justify-between mb-8 pb-8 border-b border-slate-100 gap-6">
                    <div>
                        <p class="text-sm text-slate-500 mb-1">Kamar Dipesan</p>
                        <p class="font-medium text-slate-800">{{ $reservation->room->roomType->type_name }} (No. {{ $reservation->room->room_number }})</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 mb-1">Jadwal Menginap</p>
                        <p class="font-medium text-slate-800">
                            {{ \Carbon\Carbon::parse($reservation->check_in_date)->format('d M Y') }} - 
                            {{ \Carbon\Carbon::parse($reservation->check_out_date)->format('d M Y') }}
                        </p>
                    </div>
                </div>

                <div class="bg-slate-50 p-6 rounded-xl border border-slate-100 mb-8 text-center">
                    <p class="text-sm text-slate-500 mb-2">Total yang harus dibayar:</p>
                    <p class="text-4xl font-bold text-slate-800 mb-6">Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</p>
                    
                    <div class="inline-block text-left bg-white p-4 rounded-lg shadow-sm border border-slate-100 w-full md:w-auto">
                        <p class="text-xs text-slate-500 uppercase tracking-wider mb-2">Transfer ke Rekening Berikut:</p>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-8 bg-blue-600 rounded flex items-center justify-center text-white font-bold text-xs italic">BCA</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-lg tracking-widest">8765 4321 00</p>
                                <p class="text-xs text-slate-500">a.n. The Beach House Hotel</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 h-full">
                    
                    <form action="/guest/payment/{{ $reservation->id }}" method="POST" enctype="multipart/form-data" class="h-full flex flex-col">
                        @csrf
                        <label class="border-2 border-dashed border-slate-300 rounded-xl p-6 flex flex-col items-center justify-center text-center hover:bg-slate-50 transition cursor-pointer flex-grow relative group h-full">
                            <div class="text-3xl mb-2 group-hover:scale-110 transition-transform">📤</div>
                            <p class="font-medium text-slate-700">Upload Bukti Transfer</p>
                            <p class="text-xs text-slate-400 mt-1 mb-2">Format JPG/PNG, Max 2MB</p>
                            
                            <input type="file" name="proof_image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required 
                                onchange="document.getElementById('file-name').innerText = this.files[0].name; document.getElementById('submit-btn').classList.remove('hidden');">
                            
                            <p id="file-name" class="text-sm text-emerald-600 font-medium truncate w-full px-2"></p>
                        </label>

                        <button type="submit" id="submit-btn" class="hidden w-full bg-slate-800 text-white font-medium py-3 rounded-lg mt-3 hover:bg-slate-900 transition shadow-sm">
                            Kirim Bukti Pembayaran
                        </button>
                    </form>

                    <a href="https://wa.me/628123456789?text=Halo%20The%20Beach%20House,%20saya%20ingin%20mengonfirmasi%20pembayaran%20untuk%20kode%20reservasi:%20{{ $reservation->reservation_code }}" target="_blank" class="bg-[#25D366] text-white rounded-xl p-6 flex flex-col items-center justify-center hover:bg-[#20b858] transition shadow-sm h-full">
                        <div class="text-3xl mb-2">💬</div>
                        <p class="font-medium">Konfirmasi via WhatsApp</p>
                        <p class="text-xs text-white/80 mt-1">Hubungi resepsionis kami</p>
                    </a>

                </div>

            </div>
        </div>
    </div>

</body>
</html>