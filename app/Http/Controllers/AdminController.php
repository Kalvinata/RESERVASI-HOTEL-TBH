<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Reservation;
use App\Models\User; // Tambahkan ini
use Illuminate\Support\Facades\Hash; // Tambahkan ini

class AdminController extends Controller
{
    public function index()
    {
        // Menghitung rekapitulasi data untuk dashboard
        $totalRooms = Room::count();
        $totalTypes = RoomType::count();
        
        // Menghitung total reservasi yang sudah confirmed, checked_in, atau selesai
        $totalReservations = Reservation::whereIn('status', ['confirmed', 'checked_in', 'completed'])->count();
        
        // Menghitung estimasi pendapatan dari reservasi yang sudah diverifikasi/dibayar
        $totalRevenue = Reservation::whereHas('payment', function($query) {
            $query->where('status', 'paid');
        })->sum('total_price');

        return view('admin.dashboard', compact('totalRooms', 'totalTypes', 'totalReservations', 'totalRevenue'));
    }
    // Fungsi untuk menampilkan halaman Tipe Kamar
    public function roomTypes()
    {
        $roomTypes = RoomType::orderBy('created_at', 'desc')->get();
        return view('admin.room_types', compact('roomTypes'));
    }

    // Fungsi untuk menyimpan Tipe Kamar baru ke database
    public function storeRoomType(Request $request)
    {
        RoomType::create([
            'type_name' => $request->type_name,
            'base_price' => $request->base_price,
            'Max_occupancy' => $request->Max_occupancy,
            'facilities' => $request->facilities,
        ]);

        return redirect('/admin/room-types')->with('success', 'Tipe kamar baru berhasil ditambahkan!');
    }
    // Fungsi untuk menampilkan halaman Kelola Kamar
    public function rooms()
    {
        // Ambil data kamar beserta relasi tipe kamarnya
        $rooms = Room::with('roomType')->orderBy('room_number', 'asc')->get();
        
        // Ambil semua tipe kamar untuk ditampilkan di pilihan dropdown (select)
        $roomTypes = RoomType::all(); 
        
        return view('admin.rooms', compact('rooms', 'roomTypes'));
    }

    // Fungsi untuk menyimpan data Kamar baru
    public function storeRoom(Request $request)
    {
        Room::create([
            'room_number' => $request->room_number,
            'room_type_id' => $request->room_type_id,
            'floor' => $request->floor,
            'status' => 'available', // Kamar baru otomatis berstatus tersedia
        ]);

        return redirect('/admin/rooms')->with('success', 'Kamar fisik baru berhasil ditambahkan!');
    }
    // Fungsi untuk menampilkan halaman Kelola Pengguna
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users', compact('users'));
    }

    // Fungsi untuk menyimpan Pengguna baru
    public function storeUser(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password otomatis
            'role' => $request->role,
        ]);

        return redirect('/admin/users')->with('success', 'Akun pengguna baru berhasil ditambahkan!');
    }
}