<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

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
}