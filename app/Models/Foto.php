<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_foto';
    protected $table = 'foto';
    protected $guarded = [];
    protected $casts = [
        'id_foto' => 'string',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class,'pesanan_id','id_pesanan');
    }
}