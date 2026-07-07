<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\CleaningLog; // Opsional jika kamu menggunakan log kebersihan
use Carbon\Carbon;

class HousekeepingController extends Controller
{
    // 1. Tampilan Utama & Perhitungan Statistik Widget
    public function index()
    {
        // Ambil semua kamar beserta tipe kamarnya
        $rooms = Room::with('roomType')->orderBy('room_number', 'asc')->get();

        // Hitung statistik secara real-time untuk Widget atas
        $dirtyCount = Room::where('status', 'dirty')->count();
        $cleaningCount = Room::where('status', 'cleaning')->count();
        $readyCount = Room::whereIn('status', ['available', 'occupied'])->count();

        return view('housekeeping.dashboard', compact('rooms', 'dirtyCount', 'cleaningCount', 'readyCount'));
    }

    // 2. Langkah 1: Mulai Bersihkan Kamar (Dirty -> Cleaning)
    public function startCleaning($id)
    {
        $room = Room::findOrFail($id);
        
        // Pastikan hanya kamar kotor yang bisa mulai dibersihkan
        if ($room->status == 'dirty') {
            $room->update(['status' => 'cleaning']);
            return redirect('/hk/dashboard')->with('success', 'Kamar ' . $room->room_number . ' mulai dibersihkan.');
        }

        return redirect('/hk/dashboard')->with('error', 'Kamar tidak dalam status kotor.');
    }

    // 3. Langkah 2: Selesai Bersihkan Kamar (Cleaning -> Available)
    public function finishCleaning($id)
    {
        $room = Room::findOrFail($id);
        
        // Pastikan hanya kamar yang sedang dibersihkan yang bisa diselesaikan
        if ($room->status == 'cleaning') {
            $room->update(['status' => 'available']);
            return redirect('/hk/dashboard')->with('success', 'Kamar ' . $room->room_number . ' sudah bersih dan siap digunakan!');
        }

        return redirect('/hk/dashboard')->with('error', 'Kamar tidak sedang dalam pembersihan.');
    }
}