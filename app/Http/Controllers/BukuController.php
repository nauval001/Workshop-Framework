<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku; // Wajib dipanggil untuk mengambil data buku

class BukuController extends Controller
{
    /**
     * Menampilkan daftar data buku.
     */
    public function index()
    {
        // Ambil semua data buku beserta relasi kategorinya
        // Menggunakan with('kategori') agar nama kategori bisa dipanggil langsung
        $buku = Buku::with('kategori')->get(); 
        
        // Kirim data ke file view 'buku/index.blade.php'
        return view('buku.index', compact('buku'));
    }

    public function create()
    {
        $kategori = Kategori::all(); // Ambil semua kategori untuk form pilihan (dropdown)
        return view('buku.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|max:20',
            'judul' => 'required|max:500',
            'pengarang' => 'required|max:200',
            'idkategori' => 'required|integer'
        ]);

        Buku::create([
            'kode' => $request->kode,
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'idkategori' => $request->idkategori
        ]);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategori = Kategori::all(); // Tetap ambil kategori untuk dropdown
        return view('buku.edit', compact('buku', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|max:20',
            'judul' => 'required|max:500',
            'pengarang' => 'required|max:200',
            'idkategori' => 'required|integer'
        ]);

        $buku = Buku::findOrFail($id);
        $buku->update([
            'kode' => $request->kode,
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'idkategori' => $request->idkategori
        ]);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus!');
    }
}