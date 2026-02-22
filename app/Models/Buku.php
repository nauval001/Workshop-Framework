<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
protected $table = 'buku';
protected $primaryKey = 'idbuku';
protected $guarded = [];
public function kategori() {
    return $this->belongsTo(Kategori::class, 'idkategori');}
}