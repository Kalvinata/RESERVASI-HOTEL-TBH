<?php
// Tambahkan baris ini di bagian atas (di bawah <?php)
use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontOfficeController;
use App\Http\Controllers\HousekeepingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
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
Route::post('/fo/room-checkin/{id}', [FrontOfficeController::class, 'checkIn']);
Route::get('/fo/rooms', [FrontOfficeController::class, 'rooms']);
Route::post('/fo/rooms/{id}/checkout', [FrontOfficeController::class, 'checkoutRoom']);
Route::get('/hk/dashboard', [HousekeepingController::class, 'index']);
Route::post('/hk/rooms/{id}/start', [HousekeepingController::class, 'startCleaning']);
Route::post('/hk/rooms/{id}/finish', [HousekeepingController::class, 'finishCleaning']);
Route::get('/admin/dashboard', [AdminController::class, 'index']);
Route::get('/admin/room-types', [AdminController::class, 'roomTypes']);
Route::post('/admin/room-types', [AdminController::class, 'storeRoomType']);
Route::get('/admin/rooms', [AdminController::class, 'rooms']);
Route::post('/admin/rooms', [AdminController::class, 'storeRoom']);
Route::get('/admin/users', [AdminController::class, 'users']);
Route::post('/admin/users', [AdminController::class, 'storeUser']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'registerPost']);
// Tambahkan ini di bawah Route::get('/login', ...) atau Route::post('/register', ...)
Route::post('/login', [AuthController::class, 'loginPost']);
Route::post('/logout', [AuthController::class, 'logout']);


Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});