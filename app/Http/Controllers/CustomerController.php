<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    // 1. Menampilkan Halaman Customer
    public function index()
    {
        $vendors = Vendor::all(); // Ambil semua vendor untuk dropdown level 1
        return view('customer.index', compact('vendors'));
    }

    // 2. API untuk Dropdown Berjenjang (Ambil Menu berdasarkan Vendor)
    public function getMenus($idvendor)
    {
        $menus = Menu::where('idvendor', $idvendor)->get();
        return response()->json($menus);
    }

    // 3. Proses Checkout & Generate Token Midtrans
    public function checkout(Request $request)
    {
        // Setup konfigurasi Midtrans
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        \Midtrans\Config::$isSanitized = env('MIDTRANS_IS_SANITIZED', true);
        \Midtrans\Config::$is3ds = env('MIDTRANS_IS_3DS', true);

        DB::beginTransaction();
        try {
            // Generate ID Guest Otomatis (Guest_0000001)
            $lastPesanan = Pesanan::orderBy('idpesanan', 'desc')->first();
            $nextId = $lastPesanan ? $lastPesanan->idpesanan + 1 : 1;
            $namaGuest = 'Guest_' . str_pad($nextId, 7, '0', STR_PAD_LEFT);

            // Simpan ke tabel Pesanan
            $pesanan = Pesanan::create([
                'nama' => $namaGuest,
                'total' => $request->total,
                'status_bayar' => 'Belum Bayar'
            ]);

            $itemDetails = [];

            // Simpan ke tabel Detail Pesanan
            foreach ($request->keranjang as $item) {
                DetailPesanan::create([
                    'idpesanan' => $pesanan->idpesanan,
                    'idmenu' => $item['idmenu'],
                    'jumlah' => $item['jumlah'],
                    'harga' => $item['harga'],
                    'subtotal' => $item['subtotal']
                ]);

                // Format item untuk dikirim ke Midtrans
                $itemDetails[] = [
                    'id' => $item['idmenu'],
                    'price' => $item['harga'],
                    'quantity' => $item['jumlah'],
                    'name' => substr($item['nama_menu'], 0, 50) // Max 50 karakter
                ];
            }

            // Persiapkan parameter untuk Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => 'ORD-' . $pesanan->idpesanan . '-' . time(),
                    'gross_amount' => $request->total,
                ],
                'customer_details' => [
                    'first_name' => $namaGuest,
                ],
                'item_details' => $itemDetails,
            ];

            // Dapatkan Snap Token dari Midtrans
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Simpan token ke database pesanan
            $pesanan->update(['snap_token' => $snapToken]);

            DB::commit();

            // Kembalikan token ke Frontend
            return response()->json(['status' => 'success', 'snap_token' => $snapToken]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function paymentSuccess(Request $request)
    {
        Pesanan::where('snap_token', $request->snap_token)->update([
            'status_bayar' => 'Lunas'
        ]);
        
        return response()->json(['status' => 'success']);
    }
}