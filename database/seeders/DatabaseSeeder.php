<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Panggil kedua seeder yang baru kita buat
        $this->call([
            UserSeeder::class,
            RoomSeeder::class,
        ]);
    }
}