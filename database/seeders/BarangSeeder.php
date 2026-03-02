<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Buku Tulis Sidu 38 Lembar', 'harga' => 3500],
            ['nama' => 'Pensil 2B Faber Castell', 'harga' => 4000],
            ['nama' => 'Bolpoin Standard AE7', 'harga' => 2500],
            ['nama' => 'Penghapus Joyko Hitam', 'harga' => 2000],
            ['nama' => 'Penggaris Besi 30cm', 'harga' => 6000],
            ['nama' => 'Tipe-X Kenko', 'harga' => 5500],
            ['nama' => 'Spidol Snowman Hitam', 'harga' => 7000],
            ['nama' => 'Buku Gambar A3', 'harga' => 12000],
            ['nama' => 'Crayon Titi 12 Warna', 'harga' => 18000],
            ['nama' => 'Rautan Pensil Putar', 'harga' => 15000],
        ];

        foreach ($data as $item) {
            Barang::create($item);
        }
    }
}