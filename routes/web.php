<?php
// Tambahkan baris ini di bagian atas (di bawah <?php)
use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontOfficeController;
// ... (route login & register biarkan saja)

// Tambahkan route baru ini
Route::get('/guest', [GuestController::class, 'index']);
Route::get('/guest/book/{id}', [GuestController::class, 'book']);
Route::get('/guest/book/{id}', [GuestController::class, 'book']);
// Tambahkan baris ini untuk menangkap data dari formulir
Route::post('/guest/book/{id}', [GuestController::class, 'store']);
Route::get('/guest/payment/{id}', [GuestController::class, 'payment']);
Route::post('/guest/payment/{id}', [GuestController::class, 'uploadProof']);
Route::get('/fo/dashboard', [FrontOfficeController::class, 'index']);
Route::post('/fo/verify/{id}', [FrontOfficeController::class, 'verify']);



Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});