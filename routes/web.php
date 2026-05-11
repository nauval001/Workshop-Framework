<?php

use App\Http\Controllers\JsController;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\CustomerController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
});

Auth::routes();

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

Route::get('/generate-sertifikat', [PdfController::class, 'sertifikat'])->name('pdf.sertifikat');
Route::get('/generate-undangan', [PdfController::class, 'undangan'])->name('pdf.undangan');

Route::resource('barang', BarangController::class);
Route::post('/barang/cetak-label', [BarangController::class, 'cetakLabel'])->name('barang.cetak');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.updatePhoto');

Route::prefix('js')->group(function () {
Route::get('/html-table', [JsController::class, 'htmlTable'])->name('js.html');
Route::get('/datatables', [JsController::class, 'datatables'])->name('js.dt');
Route::get('/select', [JsController::class, 'select'])->name('js.select');

Route::get('/ajax/wilayah', [AjaxController::class, 'wilayah'])->name('ajax.wilayah');
Route::get('/ajax/pos', [PosController::class, 'index'])->name('ajax.pos');
Route::post('/ajax/pos/cari', [PosController::class, 'cariBarang'])->name('ajax.pos.cari');
Route::post('/ajax/pos/bayar', [PosController::class, 'bayar'])->name('ajax.pos.bayar');

Route::prefix('vendor')->group(function () {
    Route::get('/', [VendorController::class, 'index'])->name('vendor.index');
    Route::post('/menu', [VendorController::class, 'storeMenu'])->name('vendor.storeMenu');
});

Route::prefix('customer')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/get-menus/{idvendor}', [CustomerController::class, 'getMenus'])->name('customer.getMenus'); 
    Route::post('/checkout', [CustomerController::class, 'checkout'])->name('customer.checkout');
});
    Route::post('/payment-success', [CustomerController::class, 'paymentSuccess'])->name('customer.paymentSuccess');

Route::get('/vendor/menu/{id}/edit', [App\Http\Controllers\VendorController::class, 'edit'])->name('vendor.menu.edit');
Route::put('/vendor/menu/{id}', [App\Http\Controllers\VendorController::class, 'update'])->name('vendor.menu.update');
Route::delete('/vendor/menu/{id}', [App\Http\Controllers\VendorController::class, 'destroy'])->name('vendor.menu.destroy');

Route::prefix('data-customer')->group(function () {
    Route::get('/', [App\Http\Controllers\DataCustomerController::class, 'index'])->name('customer.data');
    Route::get('/tambah-1', [App\Http\Controllers\DataCustomerController::class, 'createBlob'])->name('customer.tambah1');
    Route::post('/tambah-1', [App\Http\Controllers\DataCustomerController::class, 'storeBlob'])->name('customer.store1');

    Route::get('/tambah-2', [App\Http\Controllers\DataCustomerController::class, 'createPath'])->name('customer.tambah2');
    Route::post('/tambah-2', [App\Http\Controllers\DataCustomerController::class, 'storePath'])->name('customer.store2');
});

Route::get('/scan-barang', function () {
    return view('scanner.barcode');
});

Route::get('/api/barang/{id}', function ($id) {
    $barang = \App\Models\Barang::where('id_barang', $id)->first();
    return response()->json($barang);
});
Route::get('/customer/riwayat', [App\Http\Controllers\CustomerController::class, 'riwayat'])->name('customer.riwayat');
Route::get('/vendor/scan', function () { return view('vendor.scan'); })->name('vendor.scan');
Route::get('/api/pesanan/{idpesanan}', [App\Http\Controllers\VendorController::class, 'cekPesanan']);

Route::get('/kunjungan-toko', [App\Http\Controllers\KunjunganController::class, 'index'])->name('kunjungan.index');
Route::post('/api/kunjungan/validasi', [App\Http\Controllers\KunjunganController::class, 'validasiKunjungan']);

Route::get('/kunjungan/toko', [App\Http\Controllers\KunjunganController::class, 'listToko'])->name('kunjungan.list');
Route::post('/kunjungan/toko/simpan', [App\Http\Controllers\KunjunganController::class, 'storeToko'])->name('kunjungan.store');
Route::get('/kunjungan/toko/{barcode}/cetak', [App\Http\Controllers\KunjunganController::class, 'cetakBarcode'])->name('kunjungan.cetak');
});