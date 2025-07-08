<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pesanan';
    protected $table = 'pesanan';
    protected $guarded = [];
    protected $casts = [
        'id_pesanan' => 'string',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class,'booking_id','id_booking');
    }
    public function fotografer()
    {
        return $this->belongsTo(Fotografer::class,'fotografer_id','id_fotografer');
    }
    public function foto()
    {
        return $this->hasOne(Foto::class,'pesanan_id','id_pesanan');
    }
}