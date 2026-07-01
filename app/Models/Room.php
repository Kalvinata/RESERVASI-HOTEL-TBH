<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    // Tambahkan baris ini agar status kamar diizinkan untuk di-update
    protected $guarded = []; 

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }
}