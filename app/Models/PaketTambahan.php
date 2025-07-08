<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketTambahan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_paket_tambahan';
    protected $table = 'paket_tambahan';
    protected $guarded = [];
    protected $casts = [
        'id_paket_tambahan' => 'string',
    ];

    public function bookingPaketTambahan()
    {
        return $this->hasMany(BookingPaketTambahan::class, 'paket_tambahan_id', 'id_paket_tambahan');
    }

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_paket_tambahan', 'paket_tambahan_id', 'booking_id');
    }
}