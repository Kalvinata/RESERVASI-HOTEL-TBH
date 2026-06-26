<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    // Tambahkan fungsi ini agar Room terhubung ke RoomType
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }
}