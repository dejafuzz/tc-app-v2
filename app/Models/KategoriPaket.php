<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPaket extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_kp';
    protected $table = 'kategori_paket';
    protected $guarded = [];
    protected $casts = [
        'id_kp' => 'string'
    ];

    public function paket()
    {
        return $this->hasMany(Paket::class,'kp_id','id_kp');
    }
    
}