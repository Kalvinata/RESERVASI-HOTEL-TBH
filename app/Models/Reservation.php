<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    // Mengizinkan Controller untuk menyimpan data ke tabel ini
    protected $guarded = []; 

    // Relasi ke Kamar
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    // Relasi ke Pembayaran (1 Reservasi = 1 Pembayaran)
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}