<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kamar - The Beach House</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;500&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-slate-50">

    <nav class="bg-white shadow-sm py-4 px-8 flex justify-between items-center">
        <h1 class="text-2xl font-serif text-slate-800">The Beach House</h1>
        <div class="space-x-4 flex items-center">
            <span class="text-sm text-slate-600">Halo, Guest</span>
            <a href="/login" class="text-sm bg-slate-100 text-slate-600 px-4 py-2 rounded hover:bg-slate-200 transition">Keluar</a>
        </div>
    </nav>

    <div class="bg-slate-800 text-white py-16 px-8 text-center">
        <h2 class="text-3xl font-serif mb-3">Temukan Kenyamanan Anda</h2>
        <p class="text-slate-300 max-w-2xl mx-auto text-sm">Kamar eksklusif kami dirancang untuk memberikan pengalaman menginap yang tak terlupakan di Gili Trawangan.</p>
    </div>

    <div class="max-w-6xl mx-auto px-4 py-12">
        <h3 class="text-xl font-medium text-slate-800 mb-6 border-l-4 border-slate-800 pl-3">Kamar Tersedia</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($rooms as $room)
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl overflow-hidden flex flex-col md:flex-row transition-all duration-300">
                <div class="md:w-2/5 h-48 md:h-auto bg-slate-200">
                    <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?q=80&w=1000&auto=format&fit=crop" class="w-full h-full object-cover" alt="Room Image">
                </div>
                
                <div class="p-6 md:w-3/5 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-1">
                            <h4 class="text-xl font-serif text-slate-800">{{ $room->roomType->type_name }}</h4>
                            <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs px-2 py-1 rounded-md font-medium">No. {{ $room->room_number }}</span>
                        </div>
                        <p class="text-sm text-slate-500 mb-3 line-clamp-2">{{ $room->roomType->description }}</p>
                        
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="text-[11px] bg-slate-100 text-slate-600 px-2 py-1 rounded border border-slate-200">👥 Max {{ $room->roomType->Max_occupancy }} Org</span>
                            <span class="text-[11px] bg-slate-100 text-slate-600 px-2 py-1 rounded border border-slate-200">🏢 Lantai {{ $room->floor }}</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-end mt-4 pt-4 border-t border-slate-100">
                        <div>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider">Mulai Dari</p>
                            <p class="text-lg font-semibold text-slate-800">Rp {{ number_format($room->roomType->base_price, 0, ',', '.') }}<span class="text-xs font-normal text-slate-500">/mlm</span></p>
                        </div>
                        <a href="/guest/book/{{ $room->id }}" class="bg-slate-800 text-white text-sm px-5 py-2 rounded-lg hover:bg-slate-900 transition shadow-md inline-block">
                             Pilih Kamar
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
            </div>
    </div>

</body>
</html>