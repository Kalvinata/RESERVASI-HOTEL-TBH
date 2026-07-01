<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room; 
use App\Models\Reservation; 
use App\Models\Payment;     
use Illuminate\Support\Str; 
use Carbon\Carbon;          

class GuestController extends Controller
{
    // 1. Fungsi Tampil Daftar Kamar
    public function index()
    {
        $rooms = Room::with('roomType')->where('status', 'available')->get();
        return view('guest.index', compact('rooms'));
    }

    // 2. Fungsi Tampil Form Reservasi
    public function book($id)
    {
        $room = Room::with('roomType')->findOrFail($id);
        return view('guest.book', compact('room'));
    }

    // 3. Fungsi Simpan Data Reservasi ke Database
    public function store(Request $request, $id)
    {
        // Ambil data kamar
        $room = Room::with('roomType')->findOrFail($id);

        // Hitung selisih hari (Check Out - Check In)
        $checkIn = Carbon::parse($request->check_in_date);
        $checkOut = Carbon::parse($request->check_out_date);
        $days = $checkIn->diffInDays($checkOut);
        
        // Jika tamu check-out di hari yang sama, hitung minimal 1 malam
        if ($days == 0) { $days = 1; }

        // Hitung total harga
        $totalPrice = $days * $room->roomType->base_price;

        // Generate Kode Reservasi Unik
        $reservationCode = 'TBH-' . strtoupper(Str::random(5));

        // Simpan ke tabel reservations
        $reservation = Reservation::create([
            'user_id' => 4, // Sementara pakai ID 4 (Tamu Contoh dari Seeder)
            'room_id' => $room->id,
            'reservation_code' => $reservationCode,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        // Buat tagihan awal di tabel payments
        Payment::create([
            'reservation_id' => $reservation->id,
            'method' => 'Transfer Bank',
            'amount' => $totalPrice,
            'status' => 'pending',
        ]);

        // Beri respon sukses
       // Arahkan ke halaman invoice berdasarkan ID reservasi yang baru dibuat
        return redirect('/guest/payment/' . $reservation->id);
    }
    // Fungsi untuk menampilkan halaman Invoice dan Upload Bukti
    public function payment($id)
    {
        $reservation = Reservation::with(['room.roomType', 'payment'])->findOrFail($id);
        return view('guest.payment', compact('reservation'));
    }
    // Fungsi untuk memproses gambar bukti pembayaran
    public function uploadProof(Request $request, $id)
    {
        // 1. Validasi file (Maksimal 2MB dan harus berupa gambar)
        $request->validate([
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $reservation = Reservation::findOrFail($id);

        // 2. Simpan gambar ke folder "storage/app/public/payments"
        $path = $request->file('proof_image')->store('payments', 'public');

        // 3. Update data di tabel payments
        $reservation->payment()->update([
            'proof_image_path' => $path,
            'uploaded_at' => Carbon::now(), // Menggunakan Carbon yang sudah kita import sebelumnya
            // Status dibiarkan 'pending' sampai diverifikasi oleh Front Office
        ]);

        // 4. Beri notifikasi sukses sederhana menggunakan dd() untuk debugging
        dd("BERHASIL! Gambar tersimpan di path: " . $path . ". Silakan cek folder storage/app/public/payments di VS Code.");
    }
}