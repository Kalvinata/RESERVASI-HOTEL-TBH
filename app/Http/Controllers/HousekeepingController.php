<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use Carbon\Carbon;

class HousekeepingController extends Controller
{
    // 1. Tampilkan Kamar yang Perlu atau Sedang Dibersihkan
    public function index()
    {
        // Menampilkan kamar yang berstatus 'dirty' atau 'cleaning'
        $rooms = Room::with('roomType')
            ->whereIn('status', ['dirty', 'cleaning'])
            ->orderBy('room_number', 'asc')
            ->get();

        return view('housekeeping.dashboard', compact('rooms'));
    }

    // 2. Tahap 1: Mulai Proses Pembersihan
    public function startCleaning($id)
    {
        $room = Room::findOrFail($id);
        
        // Ubah status kamar menjadi sedang dibersihkan
        $room->update([
            'status' => 'cleaning'
        ]);

        return back()->with('success', 'Kamar No. ' . $room->room_number . ' mulai dibersihkan.');
    }

    // 3. Tahap 2: Selesai Pembersihan (Kamar Siap Dijual Kembali)
    public function finishCleaning($id)
    {
        $room = Room::findOrFail($id);
        
        // Kembalikan status kamar menjadi tersedia/available
        $room->update([
            'status' => 'available'
        ]);

        return back()->with('success', 'Kamar No. ' . $room->room_number . ' selesai dibersihkan dan siap digunakan.');
    }
}