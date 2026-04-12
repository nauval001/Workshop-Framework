<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataCustomer;

class DataCustomerController extends Controller
{
    public function index()
    {
        $customers = DataCustomer::all();
        return view('customer.data', compact('customers'));
    }

    public function createBlob()
    {
        return view('customer.tambah1');
    }

    public function storeBlob(Request $request)
    {
        DataCustomer::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'provinsi' => $request->provinsi,
            'kota' => $request->kota,
            'kecamatan' => $request->kecamatan,
            'kodepos' => $request->kodepos,
            'foto_blob' => $request->foto_base64 
        ]);

        return redirect()->route('customer.data')->with('success', 'Customer dengan foto Blob berhasil ditambahkan!');
    }
    
    // Menampilkan halaman Tambah Customer 2
    public function createPath()
    {
        return view('customer.tambah2');
    }

    // Memproses penyimpanan file ke server dan menyimpan path-nya
    public function storePath(Request $request)
    {
        // 1. Ambil data Base64 dari input tersembunyi
        $base64_image = $request->foto_base64;

        if ($base64_image) {
            // 2. Ekstrak data gambar (buang bagian "data:image/png;base64,")
            $image_parts = explode(";base64,", $base64_image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);

            // 3. Buat nama file unik (contoh: cust_1680123456.png)
            $fileName = 'cust_' . time() . '.' . $image_type;
            
            // 4. Tentukan folder penyimpanan (public/customer_photos)
            $folderPath = public_path('customer_photos');
            
            // Buat foldernya jika belum ada
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            $file = $folderPath . '/' . $fileName;
            
            // 5. Simpan file gambar ke folder server
            file_put_contents($file, $image_base64);

            // 6. Simpan PATH (alamat) gambarnya ke variabel untuk disimpan ke DB
            $fotoPathToSave = 'customer_photos/' . $fileName;
        } else {
            $fotoPathToSave = null;
        }

        // Simpan data ke database menggunakan kolom foto_path
        DataCustomer::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'provinsi' => $request->provinsi,
            'kota' => $request->kota,
            'kecamatan' => $request->kecamatan,
            'kodepos' => $request->kodepos,
            'foto_path' => $fotoPathToSave // <-- Simpan di kolom foto_path
        ]);

        return redirect()->route('customer.data')->with('success', 'Customer dengan foto File Path berhasil ditambahkan!');
    }
}