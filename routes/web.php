<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\BusanaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransaksiController;



// Route::get('/', function () {
//     return view('welcome');
// });


Route::middleware(['preventBackHistory'])->group(function () {
    Route::get('/', [BusanaController::class, 'index'])->name('busana.index');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
});


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');

Route::get('/debug', function () {
    return view('debug');
});
