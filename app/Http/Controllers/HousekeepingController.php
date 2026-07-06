<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room; // Wajib dipanggil agar tidak error seperti sebelumnya

class HousekeepingController extends Controller
{
    // 1. Tampilkan halaman dashboard HK
    public function index()
    {
        // Hanya ambil kamar yang berstatus kotor atau sedang dibersihkan
        $rooms = Room::with('roomType')->whereIn('status', ['dirty', 'cleaning'])->orderBy('room_number', 'asc')->get();
        return view('housekeeping.dashboard', compact('rooms'));
    }

    // 2. Ubah status kamar menjadi "Sedang Dibersihkan"
    public function startCleaning($id)
    {
        $room = Room::findOrFail($id);
        $room->update(['status' => 'cleaning']);
        
        return back()->with('success', 'Mulai membersihkan kamar.');
    }

    // 3. Ubah status kamar kembali menjadi "Tersedia"
    public function finishCleaning($id)
    {
        $room = Room::findOrFail($id);
        $room->update(['status' => 'available']);
        
        return back()->with('success', 'Kamar selesai dibersihkan dan siap dijual.');
    }
}