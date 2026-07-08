<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\FrontOfficeController;
use App\Http\Controllers\HousekeepingController;
use App\Http\Controllers\AdminController;

// ==========================================
// 1. RUTE PUBLIC (Bisa diakses siapa saja)
// ==========================================
Route::get('/', function () {
    return redirect('/login');
});

// Ini rute GET yang tadi hilang untuk menampilkan form login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'registerPost']);


// ==========================================
// 2. RUTE TERLINDUNG (Wajib Login)
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    // Rute Logout (Semua role bisa akses selama sudah login)
    Route::post('/logout', [AuthController::class, 'logout']);

    // ------------------------------------------
    // A. KAMAR KHUSUS ADMIN
    // ------------------------------------------
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index']);
        Route::get('/admin/room-types', [AdminController::class, 'roomTypes']);
        Route::post('/admin/room-types', [AdminController::class, 'storeRoomType']);
        Route::get('/admin/rooms', [AdminController::class, 'rooms']);
        Route::post('/admin/rooms', [AdminController::class, 'storeRoom']);
        Route::get('/admin/users', [AdminController::class, 'users']);
        Route::post('/admin/users', [AdminController::class, 'storeUser']);
        // Kelola Tipe Kamar
    Route::get('/admin/room-types', [AdminController::class, 'roomTypes']);
    Route::post('/admin/room-types', [AdminController::class, 'storeRoomType']);
    
    // --- TAMBAHKAN 3 BARIS INI UNTUK EDIT & HAPUS ---
    Route::get('/admin/room-types/{id}/edit', [AdminController::class, 'editRoomType']);
    Route::put('/admin/room-types/{id}', [AdminController::class, 'updateRoomType']);
    Route::delete('/admin/room-types/{id}', [AdminController::class, 'destroyRoomType']);
    Route::get('/admin/room-types/{id}/edit', [AdminController::class, 'editRoomType']);
    Route::put('/admin/room-types/{id}', [AdminController::class, 'updateRoomType']);
    Route::delete('/admin/room-types/{id}', [AdminController::class, 'destroyRoomType']);
    Route::get('/admin/rooms/{id}/edit', [AdminController::class, 'editRoom']);
    Route::put('/admin/rooms/{id}', [AdminController::class, 'updateRoom']);
    Route::delete('/admin/rooms/{id}', [AdminController::class, 'destroyRoom']);
    Route::get('/admin/users', [AdminController::class, 'users']);
        Route::post('/admin/users', [AdminController::class, 'storeUser']);
        
        // --- TAMBAHKAN 3 BARIS INI UNTUK EDIT & HAPUS PENGGUNA ---
        Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser']);
        Route::put('/admin/users/{id}', [AdminController::class, 'updateUser']);
        Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser']);
    });

    // ------------------------------------------
    // B. KAMAR KHUSUS FRONT OFFICE
    // ------------------------------------------
    Route::middleware(['role:front_office'])->group(function () {
        Route::get('/fo/dashboard', [FrontOfficeController::class, 'index']);
        Route::post('/fo/verify/{id}', [FrontOfficeController::class, 'verify']);
        Route::post('/fo/room-checkin/{id}', [FrontOfficeController::class, 'checkIn']);
        Route::post('/fo/rooms/{id}/checkout', [FrontOfficeController::class, 'checkoutRoom']);
        Route::get('/fo/rooms', [FrontOfficeController::class, 'rooms']);
        
        // TAMBAHKAN DUA BARIS INI
        Route::get('/fo/inhouse', [FrontOfficeController::class, 'inhouse']);
        Route::get('/fo/history', [FrontOfficeController::class, 'history']);
    });

    // ------------------------------------------
    // C. KAMAR KHUSUS HOUSEKEEPING
    // ------------------------------------------
    Route::middleware(['role:housekeeping'])->group(function () {
        Route::get('/hk/dashboard', [HousekeepingController::class, 'index']);
        Route::post('/hk/room-start/{id}', [HousekeepingController::class, 'startCleaning']);
        Route::post('/hk/room-finish/{id}', [HousekeepingController::class, 'finishCleaning']);
    });

    // ------------------------------------------
    // D. KAMAR KHUSUS GUEST (TAMU)
    // ------------------------------------------
    Route::middleware(['role:guest'])->group(function () {
        Route::get('/guest', [GuestController::class, 'index']);
        Route::get('/guest/room/{id}', [GuestController::class, 'roomDetail']);
        Route::get('/guest/book/{id}', [GuestController::class, 'book']);
        Route::post('/guest/book/{id}', [GuestController::class, 'store']);
        
        Route::get('/guest/payment/{id}', [GuestController::class, 'payment']);
        
        // ---> INI RUTE BARU UNTUK FITUR BATALKAN RESERVASI <---
        Route::post('/guest/payment/{id}/cancel', [GuestController::class, 'cancel']);
        
        Route::get('/guest/profile', [GuestController::class, 'profile']);
        Route::post('/guest/profile', [GuestController::class, 'updateProfile']);
        
        Route::get('/guest/history', [GuestController::class, 'history']);
    });
// ------------------------------------------
// C. AREA KERJA HOUSEKEEPING (HK)
// ------------------------------------------
Route::middleware(['role:housekeeping'])->group(function () {
    // Halaman Utama Dashboard HK
    Route::get('/hk/dashboard', [HousekeepingController::class, 'index']);
    
    // Langkah 1: Mengubah status Kamar dari Kotor (dirty) -> Sedang Dibersihkan (cleaning)
    Route::post('/hk/room/{id}/start', [HousekeepingController::class, 'startCleaning']);
    
    // Langkah 2: Mengubah status Kamar dari Sedang Dibersihkan (cleaning) -> Tersedia/Siap (available)
    Route::post('/hk/room/{id}/finish', [HousekeepingController::class, 'finishCleaning']);
});

});