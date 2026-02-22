<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Posisikan import Model di sini, di luar class!
use App\Models\Kategori; 
use App\Models\Buku;     

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kategori
        $novel = Kategori::create(['nama_kategori' => 'Novel']);
        $biografi = Kategori::create(['nama_kategori' => 'Biografi']);
        Kategori::create(['nama_kategori' => 'Komik']);

        // Buku 1 
        Buku::create([
            'idkategori' => $novel->idkategori,
            'kode' => 'NV-01',
            'judul' => 'Home Sweet Loan',
            'pengarang' => 'Almira Bastari'
        ]);

        // Buku 2 
        Buku::create([
            'idkategori' => $biografi->idkategori,
            'kode' => 'BO-01',
            'judul' => 'Mohammad Hatta, Untuk Negeriku',
            'pengarang' => 'Taufik Abdullah'
        ]);
        
        // Buku 3 
        Buku::create([
            'idkategori' => $novel->idkategori,
            'kode' => 'NV-02',
            'judul' => 'Keajaiban Toko Kelontong Namiya',
            'pengarang' => 'Keigo Higashino'
        ]);
    }
}