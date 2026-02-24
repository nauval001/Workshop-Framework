<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Kategori extends Model

{
protected $table = 'kategori';
protected $primaryKey = 'idkategori'; // Penting untuk PostgreSQL update/delete
protected $guarded = [];
public $timestamps = false; // Opsional jika tabel tidak pakai created_at
}