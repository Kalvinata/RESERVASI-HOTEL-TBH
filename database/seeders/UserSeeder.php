<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password123');

        User::insert([
            ['name' => 'Administrator', 'email' => 'admin@beachhouse.com', 'phone' => '081111111', 'password' => $password, 'role' => 'admin'],
            ['name' => 'Resepsionis FO', 'email' => 'fo@beachhouse.com', 'phone' => '082222222', 'password' => $password, 'role' => 'front_office'],
            ['name' => 'Staf Kebersihan', 'email' => 'hk@beachhouse.com', 'phone' => '083333333', 'password' => $password, 'role' => 'housekeeping'],
            ['name' => 'Tamu Contoh', 'email' => 'tamu@gmail.com', 'phone' => '084444444', 'password' => $password, 'role' => 'guest'],
        ]);
    }
}