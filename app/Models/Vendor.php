<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    // Beri tahu Laravel bahwa primary key kita adalah 'idvendor', bukan 'id'
    protected $primaryKey = 'idvendor';

    // Izinkan kolom 'nama_vendor' untuk diisi secara massal
    protected $fillable = ['nama_vendor'];
}