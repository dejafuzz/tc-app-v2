<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_paket';
    protected $table = 'paket';
    protected $guarded = [];
    protected $casts = [
        'id_paket' => 'string',
    ];

    public function kategori_paket()
    {
        return $this->belongsTo(KategoriPaket::class,'kp_id','id_kp');
    }
    public function harga_paket()
    {
        return $this->hasMany(HargaPaket::class,'paket_id','id_paket');
    }
}