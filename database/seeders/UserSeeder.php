<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin (Manajer)
        User::updateOrCreate(
            ['email' => 'admin@hotel.com'], // Patokan agar tidak ganda
            [
                'name' => 'Bapak Manajer',
                'phone' => '08111111111',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
            ]
        );

        // 2. Akun Front Office (Resepsionis)
        User::updateOrCreate(
            ['email' => 'fo@hotel.com'],
            [
                'name' => 'Mbak Resepsionis',
                'phone' => '08222222222',
                'password' => Hash::make('12345678'),
                'role' => 'front_office',
            ]
        );

        // 3. Akun Housekeeping (Kebersihan)
        User::updateOrCreate(
            ['email' => 'hk@hotel.com'],
            [
                'name' => 'Mas Cleaning',
                'phone' => '08333333333',
                'password' => Hash::make('12345678'),
                'role' => 'housekeeping',
            ]
        );

        // 4. Akun Guest (Tamu)
        User::updateOrCreate(
            ['email' => 'tamu@hotel.com'],
            [
                'name' => 'Bapak Tamu',
                'phone' => '08444444444',
                'password' => Hash::make('12345678'),
                'role' => 'guest',
            ]
        );
    }
}