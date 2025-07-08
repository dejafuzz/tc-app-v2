<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketLanding extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_pl';
    protected $table = 'paket_landing';
    protected $guarded = [];

    public function paket()
    {
        return $this->belongsTo(Paket::class,'paket_id','id_paket');
    }
}
