<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LokasiToko;

class KunjunganController extends Controller
{
    public function index()
    {
        return view('kunjungan.index');
    }

    public function validasiKunjungan(Request $request)
    {
        $toko = LokasiToko::find($request->barcode);
        
        if (!$toko) {
            return response()->json(['status' => 'error', 'message' => 'Barcode Toko tidak ditemukan di Database!']);
        }

        $sales_lat = $request->lat;
        $sales_lng = $request->lng;
        $sales_acc = $request->acc;

        $R = 6371000;
        $dLat = ($sales_lat - $toko->latitude) * pi() / 180;
        $dLng = ($sales_lng - $toko->longitude) * pi() / 180;
        $a = sin($dLat/2) * sin($dLat/2) + 
             cos($toko->latitude * pi()/180) * cos($sales_lat * pi()/180) * sin($dLng/2) * sin($dLng/2);
             
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $jarak_aktual = $R * $c;

        $threshold_base = 300;
        $threshold_efektif = $threshold_base + $toko->accuracy + $sales_acc;

        if ($jarak_aktual <= $threshold_efektif) {
            $status_kunjungan = 'DITERIMA ✓';
            $warna = 'success';
        } else {
            $status_kunjungan = 'DITOLAK ✗';
            $warna = 'danger';
        }

        return response()->json([
            'status' => 'success',
            'toko' => $toko,
            'jarak_aktual' => round($jarak_aktual, 2),
            'threshold_efektif' => round($threshold_efektif, 2),
            'hasil' => $status_kunjungan,
            'warna' => $warna
        ]);
    }
    public function listToko()
    {
        $tokos = LokasiToko::all();
        return view('kunjungan.list', compact('tokos'));
    }
    public function storeToko(Request $request)
    {
        LokasiToko::create([
            'barcode' => $request->barcode,
            'nama_toko' => $request->nama_toko,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'accuracy' => $request->accuracy,
        ]);

        return redirect()->back()->with('success', 'Data Toko berhasil didaftarkan!');
    }
    public function cetakBarcode($barcode)
    {
        $toko = LokasiToko::where('barcode', $barcode)->firstOrFail();
        return view('kunjungan.cetak', compact('toko'));
    }
}