<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaPaket extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_harga_paket';
    protected $table = 'harga_paket';
    protected $guarded = [];
    protected $casts = [
        'id_harga_paket' => 'string'
    ];

    public function paket()
    {
        return $this->belongsTo(Paket::class,'paket_id','id_paket');
    }
    public function booking()
    {
        return $this->hasMany(Booking::class,'harga_paket_id','id_harga_paket');
    }

}