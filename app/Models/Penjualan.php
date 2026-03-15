<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $primaryKey = 'id_penjualan';
    protected $fillable = ['total', 'timestamp'];
}
