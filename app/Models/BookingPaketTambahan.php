<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingPaketTambahan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_booking_paket_tambahan';
    protected $table = 'booking_paket_tambahan';
    protected $guarded = [];
    protected $casts = [
        'id_booking_paket_tambahan' => 'string'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id_booking');
    }

    public function paketTambahan()
    {
        return $this->belongsTo(PaketTambahan::class, 'paket_tambahan_id', 'id_paket_tambahan');
    }
    
}