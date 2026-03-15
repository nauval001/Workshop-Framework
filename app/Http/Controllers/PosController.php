<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    // Menampilkan halaman POS
    public function index()
    {
        return view('ajax.pos');
    }

    // Fungsi untuk AJAX/Axios mencari barang saat ditekan Enter
    public function cariBarang(Request $request)
    {
        $barang = Barang::where('id_barang', $request->kode)->first();
        
        if ($barang) {
            return response()->json([
                'status' => 'success',
                'data' => $barang
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Barang tidak ditemukan!'
        ]);
    }

    public function bayar(Request $request)
    {
        DB::beginTransaction();
        try {
            // Simpan ke tabel penjualan
            $penjualan = Penjualan::create([
                'total' => $request->total,
                'timestamp' => now()
            ]);

            // Simpan setiap item ke tabel penjualan_detail
            foreach ($request->keranjang as $item) {
                PenjualanDetail::create([
                    'id_penjualan' => $penjualan->id_penjualan,
                    'id_barang' => $item['id_barang'],
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Transaksi berhasil disimpan!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan sistem!']);
        }
    }
}