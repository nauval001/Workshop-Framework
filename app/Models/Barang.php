<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $guarded = [];

    // Ini adalah pengganti Trigger BEFORE INSERT untuk men-generate ID otomatis
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Format: YYMMDD (TahunBulanTanggal)
            $prefix = date('ymd'); 
            
            // Hitung ada berapa barang yang dimasukkan hari ini
            $jumlahHariIni = self::where('id_barang', 'like', $prefix . '%')->count();
            
            // Tambahkan nomor urut di belakangnya (2 digit)
            $model->id_barang = $prefix . str_pad($jumlahHariIni + 1, 2, '0', STR_PAD_LEFT);
            
            // Isi timestamp otomatis jika kosong
            if (empty($model->timestamp)) {
                $model->timestamp = now();
            }
        });
    }
}