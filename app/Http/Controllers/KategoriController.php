<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori; // Wajib dipanggil agar bisa mengambil data dari database

class KategoriController extends Controller
{
    /**
     * Menampilkan daftar data kategori.
     */
    public function index()
    {
        // Ambil semua data dari tabel kategori
        $kategori = Kategori::all(); 
        
        // Kirim data tersebut ke file view 'kategori/index.blade.php'
        return view('kategori.index', compact('kategori'));
    }
    
    public function create()
    {
        return view('kategori.create');
    }

    // Menyimpan data baru ke database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_kategori' => 'required|max:100'
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // Menampilkan halaman form edit
    public function edit($id)
    {
        // Cari data berdasarkan idkategori
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    // Menyimpan perubahan data ke database
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|max:100'
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    // Menghapus data
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
    // (Method lain seperti create, store, update, destroy bisa dibiarkan kosong dulu)
}