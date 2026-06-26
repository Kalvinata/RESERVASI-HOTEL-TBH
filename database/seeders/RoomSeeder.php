<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoomType;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Tipe Kamar
        $deluxe = RoomType::create([
            'type_name' => 'Deluxe Room',
            'description' => 'Kamar luas dengan pemandangan taman tropis.',
            'facilities' => 'AC, TV, WiFi, Air Panas, Minibar',
            'Max_occupancy' => 2,
            'base_price' => 750000.00,
        ]);

        $suite = RoomType::create([
            'type_name' => 'Ocean View Suite',
            'description' => 'Suite mewah yang menghadap langsung ke pantai.',
            'facilities' => 'AC, Smart TV, WiFi Cepat, Bathtub, Balkon Pribadi',
            'Max_occupancy' => 4,
            'base_price' => 1500000.00,
        ]);

        // 2. Buat Fisik Kamarnya
        Room::insert([
            ['room_type_id' => $deluxe->id, 'room_number' => 'D-101', 'floor' => '1', 'status' => 'available'],
            ['room_type_id' => $deluxe->id, 'room_number' => 'D-102', 'floor' => '1', 'status' => 'dirty'], // Contoh kamar kotor untuk diuji Housekeeping
            ['room_type_id' => $suite->id, 'room_number' => 'S-201', 'floor' => '2', 'status' => 'available'],
            ['room_type_id' => $suite->id, 'room_number' => 'S-202', 'floor' => '2', 'status' => 'occupied'], // Contoh kamar sedang diisi
        ]);
    }
}