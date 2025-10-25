<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Ini adalah routing utama untuk website AlRent.
| Termasuk: Home, Daftar HT, Auth (Login/Register), dan fitur Keranjang.
|
*/

// 🏠 Halaman Utama
Route::get('/', function () {
    return view('home');
})->name('landing');

// 📻 Daftar HT
Route::get('/ht', function () {
    return view('ht');
})->name('ht');

// 🔐 Autentikasi (Register, Login, Logout)
Auth::routes();

// ⚙️ ROUTE DEBUG — pindahkan ke luar agar tidak butuh login
Route::get('/ping', function () {
    return 'pong';
});

Route::get('/run-migrate', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return '✅ Migrasi berhasil dijalankan di server!<br>' . Artisan::output();
    } catch (Exception $e) {
        return '❌ Error: ' . $e->getMessage();
    }
});

// 🛒 ROUTE KERANJANG (CRUD) — hanya bisa diakses jika sudah login
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('/checkout-success', function () {
        return view('checkout-success');
    })->middleware('auth')->name('checkout.success');
});
