<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        return view('ajax.pos');
    }

    public function cariBarang(Request $request)
    {
            $kode = $request->kode;
            $barang = Barang::where('id_barang', $kode)->first();
        
            if ($barang) {
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'id_barang' => $barang->id_barang,
                        'nama' => $barang->nama,
                        'harga' => $barang->harga
                ]
            ]);
        }

            $buku = Buku::where('kode', $kode)->first();
        
            if ($buku) {
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'id_barang' => $buku->kode,
                        'nama' => $buku->judul,
                        'harga' => $buku->harga ?? 0 
                ]
            ]);
        }

                return response()->json([
                    'status' => 'error',
                    'message' => 'Kode Barang atau Buku tidak ditemukan!'
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