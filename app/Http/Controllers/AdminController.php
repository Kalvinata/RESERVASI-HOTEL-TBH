<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // ==========================================
    // 1. HALAMAN DASHBOARD ADMIN
    // ==========================================
    public function index()
    {
        $totalKamar = Room::count();
        $totalTipeKamar = RoomType::count();
        
        $reservasiAktif = Reservation::whereIn('status', ['pending', 'confirmed', 'checked_in'])->count();
        $totalPendapatan = Payment::where('status', 'paid')->sum('amount');

        $latestReservations = Reservation::with(['user', 'room.roomType', 'payment'])
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();

        return view('admin.dashboard', compact(
            'totalKamar', 
            'totalTipeKamar', 
            'reservasiAktif', 
            'totalPendapatan', 
            'latestReservations'
        ));
    }

    // ==========================================
    // 2. KELOLA TIPE KAMAR (CRUD)
    // ==========================================
    public function roomTypes()
    {
        $roomTypes = RoomType::orderBy('created_at', 'desc')->get();
        return view('admin.room_types', compact('roomTypes'));
    }

    public function storeRoomType(Request $request)
    {
        // Validasi data
        $request->validate([
            'type_name' => 'required|string|max:255',
            'base_price' => 'required|numeric',
            'Max_occupancy' => 'required|integer',
            'facilities' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', 
        ], [
            'image.required' => 'Foto kamar wajib diunggah!',
            'image.image' => 'File yang diunggah harus berupa gambar!',
            'image.mimes' => 'Format gambar harus berupa JPG, JPEG, PNG, atau WEBP!',
            'image.max' => 'Ukuran gambar terlalu besar! Maksimal 2MB.'
        ]);
        

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('room_images', 'public');
        }

        RoomType::create([
            'type_name' => $request->type_name,
            'base_price' => $request->base_price,
            'Max_occupancy' => $request->Max_occupancy,
            'facilities' => $request->facilities,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect('/admin/room-types')->with('success', 'Tipe kamar berhasil ditambahkan!');
    }
   public function editRoom($id)
    {
        $room = Room::findOrFail($id);
        $roomTypes = RoomType::all();
        return view('admin.edit_room', compact('room', 'roomTypes'));
    }

    public function updateRoom(Request $request, $id)
    {
        $request->validate([
            'room_number' => 'required|string|max:255',
            'room_type_id' => 'required',
            'floor' => 'required|integer',
        ]);

        $room = Room::findOrFail($id);
        $room->update([
            'room_number' => $request->room_number,
            'room_type_id' => $request->room_type_id,
            'floor' => $request->floor,
        ]);

        return redirect('/admin/rooms')->with('success', 'Data kamar berhasil diperbarui!');
    }

    public function destroyRoom($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return redirect('/admin/rooms')->with('success', 'Kamar berhasil dihapus secara permanen!');
    }

    public function editRoomType($id)
    {
        $roomType = RoomType::findOrFail($id);
        return view('admin.edit_room_type', compact('roomType'));
    }

    public function updateRoomType(Request $request, $id)
    {
        $roomType = RoomType::findOrFail($id);

        $request->validate([
            'type_name' => 'required|string|max:255',
            'base_price' => 'required|numeric',
            'Max_occupancy' => 'required|integer',
            'facilities' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'image.image' => 'File harus berupa gambar!',
            'image.mimes' => 'Format gambar harus JPG, PNG, atau WEBP!',
            'image.max' => 'Ukuran maksimal 2MB!'
        ]);

        if ($request->hasFile('image')) {
            if ($roomType->image) {
                Storage::disk('public')->delete($roomType->image);
            }
            $imagePath = $request->file('image')->store('room_images', 'public');
            $roomType->image = $imagePath;
        }

        $roomType->update([
            'type_name' => $request->type_name,
            'base_price' => $request->base_price,
            'Max_occupancy' => $request->Max_occupancy,
            'facilities' => $request->facilities,
            'description' => $request->description,
            'image' => $roomType->image,
        ]);

        return redirect('/admin/room-types')->with('success', 'Data tipe kamar berhasil diperbarui!');
    }

    public function destroyRoomType($id)
    {
        $roomType = RoomType::findOrFail($id);
        
        if ($roomType->image) {
            Storage::disk('public')->delete($roomType->image);
        }
        $roomType->delete();

        return redirect('/admin/room-types')->with('success', 'Tipe kamar berhasil dihapus!');
    }

    // ==========================================
    // 3. KELOLA KAMAR FISIK
    // ==========================================
    public function rooms()
    {
        $rooms = Room::with('roomType')->orderBy('room_number', 'asc')->get();
        $roomTypes = RoomType::all(); 
        
        return view('admin.rooms', compact('rooms', 'roomTypes'));
    }

    public function storeRoom(Request $request)
    {
        Room::create([
            'room_number' => $request->room_number,
            'room_type_id' => $request->room_type_id,
            'floor' => $request->floor,
            'status' => 'available', 
        ]);

        return redirect('/admin/rooms')->with('success', 'Kamar fisik baru berhasil ditambahkan!');
    }

    // ==========================================
    // 4. KELOLA PENGGUNA (USERS)
    // ==========================================
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users', compact('users'));
    }

    public function storeUser(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            'role' => $request->role,
        ]);

        return redirect('/admin/users')->with('success', 'Akun pengguna baru berhasil ditambahkan!');
    }
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit_user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required'
        ];

        // Jika password diisi, maka divalidasi. Jika kosong, biarkan password lama.
        if($request->filled('password')){
            $rules['password'] = 'min:8';
        }

        $request->validate($rules);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        
        if($request->filled('password')){
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect('/admin/users')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function destroyUser($id)
    {
        // Mencegah admin menghapus akunnya sendiri (biar tidak error)
        if(auth()->id() == $id) {
            return redirect('/admin/users')->with('error', 'Anda tidak bisa menghapus akun Anda sendiri!');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/admin/users')->with('success', 'Akun pengguna berhasil dihapus!');
    }
}