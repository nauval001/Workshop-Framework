<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataCustomer extends Model
{
    use HasFactory;

    // Beri tahu Laravel bahwa primary key kita adalah 'idcustomer'
    protected $primaryKey = 'idcustomer';

    // Daftarkan semua kolom yang diizinkan untuk diisi secara massal
    protected $fillable = [
        'nama',
        'alamat',
        'provinsi',
        'kota',
        'kecamatan',
        'kodepos',
        'foto_blob',
        'foto_path'
    ];
}