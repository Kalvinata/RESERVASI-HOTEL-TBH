<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;

class FrontOfficeController extends Controller
{
    // ==========================================
    // 1. HALAMAN DASHBOARD UTAMA
    // ==========================================
    public function index()
    {
        $reservations = Reservation::with(['user', 'room.roomType', 'payment'])
            // REVISI: Sembunyikan tamu yang sudah check-out dari dasbor utama
            ->where('status', '!=', 'checked_out')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('front_office.dashboard', compact('reservations'));
    }

    // ==========================================
    // 2. VERIFIKASI PEMBAYARAN
    // ==========================================
    public function verify($id)
    {
        $reservation = Reservation::findOrFail($id);
        if ($reservation->payment) {
            $reservation->payment->update(['status' => 'paid']);
        }
        return back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    // ==========================================
    // 3. PROSES CHECK-IN
    // ==========================================
    public function checkIn($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->update(['status' => 'checked_in']);
        
        if ($reservation->room) {
            $reservation->room->update(['status' => 'occupied']);
        }
        return back()->with('success', 'Tamu berhasil Check-in.');
    }

    // ==========================================
    // 4. PROSES CHECK-OUT
    // ==========================================
    public function checkoutRoom($id)
    {
        $reservation = Reservation::findOrFail($id);
        
        $reservation->update(['status' => 'checked_out']);
        
        if ($reservation->room) {
            $reservation->room->update(['status' => 'dirty']);
        }
        
        return back()->with('success', 'Tamu berhasil Check-out. Info telah dikirim ke Housekeeping.');
    }

    // ==========================================
    // 5. HALAMAN: TAMU SEDANG MENGINAP
    // ==========================================
    public function inhouse(Request $request)
    {
        $query = Reservation::with(['user', 'room.roomType', 'payment'])
                    ->where('status', 'checked_in');

        if ($request->filled('tanggal')) {
            $query->whereDate('check_in_date', $request->input('tanggal'));
        }

        $reservations = $query->orderBy('check_in_date', 'asc')->get();
        return view('front_office.inhouse', compact('reservations'));
    }

    // ==========================================
    // 6. HALAMAN: RIWAYAT CHECK-OUT
    // ==========================================
    public function history(Request $request)
    {
        $query = Reservation::with(['user', 'room.roomType', 'payment'])
                    ->where('status', 'checked_out');

        if ($request->filled('tanggal')) {
            $query->whereDate('check_out_date', $request->input('tanggal'));
        }

        $reservations = $query->orderBy('updated_at', 'desc')->get();
        return view('front_office.history', compact('reservations'));
    }

    // ==========================================
    // 7. HALAMAN: STATUS KAMAR
    // ==========================================
    public function rooms()
    {
        $rooms = Room::with('roomType')->get();
        return view('front_office.rooms', compact('rooms'));
    }
}