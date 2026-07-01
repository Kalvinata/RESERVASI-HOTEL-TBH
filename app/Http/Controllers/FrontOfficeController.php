<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Room; // Ini baris yang ditambahkan agar tidak error

class FrontOfficeController extends Controller
{
    public function index()
    {
        // Ambil semua reservasi, urutkan dari yang paling baru
        // Tarik juga relasi kamar dan pembayarannya
        $reservations = Reservation::with(['room.roomType', 'payment'])->orderBy('created_at', 'desc')->get();
        
        return view('front_office.dashboard', compact('reservations'));
    }

    public function verify($id)
    {
        // 1. Ambil data reservasi beserta pembayarannya
        $reservation = Reservation::with('payment')->findOrFail($id);

        // 2. Update status reservasi jadi confirmed
        $reservation->update(['status' => 'confirmed']);

        // 3. Update status pembayaran jadi paid
        $reservation->payment->update(['status' => 'paid']);

        // 4. Kembali ke dashboard dengan pesan sukses
        return redirect('/fo/dashboard')->with('success', 'Reservasi berhasil diverifikasi!');
    }

    public function checkIn($id)
    {
        // Temukan reservasi
        $reservation = Reservation::findOrFail($id);
        
        // Ubah status kamar menjadi 'occupied'
        $reservation->room->update(['status' => 'occupied']);
        
        // Opsional: Ubah status reservasi agar tidak bisa diverifikasi lagi
        $reservation->update(['status' => 'checked_in']);

        return redirect('/fo/dashboard')->with('success', 'Tamu berhasil Check-in!');
    }

    // Fungsi untuk menampilkan halaman Status Kamar
    public function rooms()
    {
        // Ambil semua data kamar urut berdasarkan nomor kamar
        $rooms = Room::with('roomType')->orderBy('room_number', 'asc')->get();
        return view('front_office.rooms', compact('rooms'));
    }

    // Fungsi untuk proses Check-out (Mengubah status kamar jadi kotor)
    public function checkoutRoom($id)
    {
        $room = Room::findOrFail($id);
        $room->update(['status' => 'dirty']);
        
        return back()->with('success', 'Kamar berhasil di-checkout dan sekarang berstatus kotor.');
    }
}