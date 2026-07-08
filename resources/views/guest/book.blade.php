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

    @php
        // Mengecek apakah ada ?breakfast=1 di URL
        $hasBreakfast = request('breakfast') == 1;
        $breakfastPrice = 50000;
        $basePrice = $room->roomType->base_price;
        
        // Harga final per malam yang akan dikalikan dengan jumlah hari
        $finalPricePerNight = $hasBreakfast ? ($basePrice + $breakfastPrice) : $basePrice;
    @endphp

    <nav class="bg-white shadow-sm py-4 px-8 flex justify-between items-center mb-8">
        <h1 class="text-2xl font-serif text-slate-800">The Beach House</h1>
        <a href="/guest/room/{{ $room->id }}" class="text-sm text-slate-600 hover:text-slate-900 transition">← Kembali ke Detail Kamar</a>
    </nav>

    <div class="max-w-5xl mx-auto px-4 pb-12">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row">
            
            <div class="md:w-5/12 bg-slate-800 text-white p-8 md:p-10 flex flex-col justify-between relative">
                <div>
                    <h2 class="text-sm text-slate-300 uppercase tracking-wider mb-2">Ringkasan Pesanan</h2>
                    <h3 class="text-3xl font-serif mb-4">{{ $room->roomType->type_name }}</h3>
                    
                    <div class="mb-8 flex flex-col gap-3">
                        <span class="inline-block bg-slate-700 text-slate-200 px-3 py-1.5 rounded text-sm w-max font-medium shadow-sm">
                            Kamar No. {{ $room->room_number }}
                        </span>
                        
                        @if($hasBreakfast)
                            <span class="inline-block bg-emerald-600 text-white px-3 py-1.5 rounded text-sm font-bold shadow-sm w-max border border-emerald-500">
                                🍳 Termasuk Sarapan
                            </span>
                        @else
                            <span class="inline-block bg-slate-700/50 border border-slate-600 text-slate-400 px-3 py-1.5 rounded text-sm font-medium shadow-sm w-max">
                                ❌ Tanpa Sarapan
                            </span>
                        @endif
                    </div>
                    
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
                
                <div class="mt-10 pt-5 border-t border-slate-700">
                    <p class="text-xs text-slate-400 uppercase tracking-wider mb-3 font-semibold">Rincian per Malam</p>
                    
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-slate-300">Harga Kamar</span>
                        <span class="text-sm text-slate-300">Rp {{ number_format($basePrice, 0, ',', '.') }}</span>
                    </div>
                    
                    @if($hasBreakfast)
                    <div class="flex justify-between items-center mb-3 pb-3 border-b border-slate-600">
                        <span class="text-sm text-emerald-400 font-medium">Tambahan Sarapan</span>
                        <span class="text-sm text-emerald-400 font-medium">+ Rp 50.000</span>
                    </div>
                    @else
                    <div class="flex justify-between items-center mb-3 pb-3 border-b border-slate-600">
                        <span class="text-sm text-slate-500">Tambahan Sarapan</span>
                        <span class="text-sm text-slate-500">Rp 0</span>
                    </div>
                    @endif
                    
                    <div class="flex justify-between items-end mt-3">
                        <p class="text-sm text-slate-200 font-medium">Total per Malam</p>
                        <p class="text-2xl font-bold text-white">Rp {{ number_format($finalPricePerNight, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="md:w-7/12 p-8 md:p-10">
                <h3 class="text-xl font-medium text-slate-800 mb-6">Detail Reservasi</h3>
                
                <form action="/guest/book/{{ $room->id }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <input type="hidden" name="has_breakfast" value="{{ $hasBreakfast ? 1 : 0 }}">
                    <input type="hidden" name="total_price" id="hidden_total_price" value="">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Tanggal Check-in</label>
                            <input type="date" name="check_in_date" id="check_in_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1">Tanggal Check-out</label>
                            <input type="date" name="check_out_date" id="check_out_date" class="w-full text-sm px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50" required disabled>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-5 rounded-xl border border-slate-200 mt-6 flex justify-between items-center shadow-sm">
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total Biaya</p>
                            <div class="flex items-end gap-2">
                                <span class="text-2xl font-bold text-emerald-600" id="total_price_display">Rp 0</span>
                                <span class="text-sm font-medium text-slate-400 mb-1" id="malam_display"></span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" id="btn_submit" class="w-full bg-slate-800 text-white font-semibold py-4 rounded-xl hover:bg-slate-900 transition-colors mt-6 shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                        Lanjut ke Pembayaran
                    </button>
                </form>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkInInput = document.getElementById('check_in_date');
            const checkOutInput = document.getElementById('check_out_date');
            const submitBtn = document.getElementById('btn_submit');
            
            const totalDisplay = document.getElementById('total_price_display');
            const malamDisplay = document.getElementById('malam_display');
            const hiddenTotal = document.getElementById('hidden_total_price');
            
            // Mengambil Harga Final (Tergantung status sarapan dari PHP)
            const pricePerNight = {{ $finalPricePerNight }};

            function calculateTotal() {
                const checkInVal = checkInInput.value;
                const checkOutVal = checkOutInput.value;

                if (checkInVal && checkOutVal) {
                    const checkInDate = new Date(checkInVal);
                    const checkOutDate = new Date(checkOutVal);

                    const diffTime = checkOutDate - checkInDate;
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                    if (diffDays > 0) {
                        const total = diffDays * pricePerNight;
                        
                        totalDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
                        malamDisplay.textContent = '(' + diffDays + ' Malam)';
                        hiddenTotal.value = total;
                        
                        submitBtn.disabled = false; // Aktifkan tombol jika valid
                    } else {
                        totalDisplay.textContent = 'Tidak Valid';
                        malamDisplay.textContent = '';
                        hiddenTotal.value = '';
                        submitBtn.disabled = true;
                    }
                } else {
                    totalDisplay.textContent = 'Rp 0';
                    malamDisplay.textContent = '';
                    hiddenTotal.value = '';
                    submitBtn.disabled = true;
                }
            }

            checkInInput.addEventListener('change', function() {
                if (this.value) {
                    checkOutInput.disabled = false;
                    
                    const date = new Date(this.value);
                    date.setDate(date.getDate() + 1);
                    const nextDay = date.toISOString().split('T')[0];
                    
                    checkOutInput.min = nextDay;
                    
                    if(checkOutInput.value && checkOutInput.value <= this.value) {
                        checkOutInput.value = '';
                        totalDisplay.textContent = 'Rp 0';
                        malamDisplay.textContent = '';
                        submitBtn.disabled = true;
                    }
                } else {
                    checkOutInput.disabled = true;
                    checkOutInput.value = '';
                }
                calculateTotal();
            });

            checkOutInput.addEventListener('change', calculateTotal);
        });
    </script>
</body>
</html>