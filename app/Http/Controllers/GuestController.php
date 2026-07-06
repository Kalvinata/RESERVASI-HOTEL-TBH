<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room; 
use App\Models\Reservation; 
use App\Models\Payment;     
use Illuminate\Support\Str; 
use Carbon\Carbon;          
use Illuminate\Support\Facades\Auth;

class GuestController extends Controller
{
    // ==========================================
    // 1. FITUR RESERVASI KAMAR
    // ==========================================
    public function index()
    {
        $rooms = Room::with('roomType')->where('status', 'available')->get();
        return view('guest.index', compact('rooms'));
    }

    public function book($id)
    {
        $room = Room::with('roomType')->findOrFail($id);
        return view('guest.book', compact('room'));
    }

    public function store(Request $request, $id)
    {
        $room = Room::with('roomType')->findOrFail($id);
        $checkIn = Carbon::parse($request->check_in_date);
        $checkOut = Carbon::parse($request->check_out_date);
        $days = $checkIn->diffInDays($checkOut);
        
        if ($days == 0) { $days = 1; }

        // LOGIKA BARU: Cek apakah tamu menyertakan sarapan (dari input hidden di form)
        $pricePerNight = $room->roomType->base_price;
        if ($request->has_breakfast == 1) {
            $pricePerNight += 50000;
        }
        
        // Total harga sekarang sudah akurat!
        $totalPrice = $days * $pricePerNight;
        $reservationCode = 'TBH-' . strtoupper(Str::random(5));

        $reservation = Reservation::create([
            'user_id' => Auth::id(), 
            'room_id' => $room->id,
            'reservation_code' => $reservationCode,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        Payment::create([
            'reservation_id' => $reservation->id,
            'method' => 'Transfer Bank',
            'amount' => $totalPrice,
            'status' => 'pending',
        ]);

        return redirect('/guest/payment/' . $reservation->id);
    }

    // ==========================================
    // 2. FITUR PEMBAYARAN & PEMBATALAN
    // ==========================================
    public function payment($id)
    {
        $reservation = Reservation::with(['room.roomType', 'payment'])->findOrFail($id);
        return view('guest.payment', compact('reservation'));
    }

    public function uploadProof(Request $request, $id)
    {
        $request->validate([
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $reservation = Reservation::findOrFail($id);
        $path = $request->file('proof_image')->store('payments', 'public');

        $reservation->payment()->update([
            'proof_image_path' => $path,
            'uploaded_at' => Carbon::now(), 
        ]);

        return redirect('/guest/history')->with('success', 'Bukti pembayaran berhasil diunggah!');
    }

    // FUNGSI BARU: Membatalkan Reservasi & Menghapus Data
    public function cancel($id)
    {
        $reservation = Reservation::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->where('status', 'pending')
                        ->firstOrFail();

        // Hapus data pembayaran terlebih dahulu
        if ($reservation->payment) {
            $reservation->payment()->delete();
        }
        
        // Hapus data reservasi
        $reservation->delete();

        return redirect('/guest')->with('success', 'Reservasi berhasil dibatalkan.');
    }

    // ==========================================
    // 3. FITUR PROFIL TAMU
    // ==========================================
    public function profile()
    {
        return view('guest.profile');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Data profil berhasil diperbarui!');
    }

    // ==========================================
    // 4. FITUR RIWAYAT PEMESANAN
    // ==========================================
    public function history()
    {
        $reservations = Reservation::with(['room.roomType', 'payment'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('guest.history', compact('reservations'));
    }

    // ==========================================
    // 5. FITUR DETAIL KAMAR
    // ==========================================
    public function roomDetail($id)
    {
        $room = Room::with('roomType')->findOrFail($id);
        return view('guest.detail', compact('room'));
    }
}