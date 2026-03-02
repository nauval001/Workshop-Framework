<?php

use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
});

Auth::routes();

use App\Http\Controllers\Auth\GoogleAuthController;

Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);
Route::get('/otp-verification', [GoogleAuthController::class, 'otpForm'])->name('otp.form');
Route::post('/otp-verification', [GoogleAuthController::class, 'verifyOtp'])->name('otp.verify');

Route::middleware(['auth'])->group(function () {
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::resource('kategori', App\Http\Controllers\KategoriController::class);
Route::resource('buku', App\Http\Controllers\BukuController::class);
});

Route::middleware('auth')->group(function () {
Route::get('/dashboard', function () {
    return view('dashboard');
    })->name('dashboard');
    
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/generate-sertifikat', [PdfController::class, 'sertifikat'])->name('pdf.sertifikat');
Route::get('/generate-undangan', [PdfController::class, 'undangan'])->name('pdf.undangan');