<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pengeluaran';
    protected $table = 'pengeluaran';
    protected $guarded = [];

    public function jenis_pengeluaran()
    {
        return $this->belongsTo(JenisPengeluaran::class,'jenis_pengeluaran_id','id_jenis_pengeluaran');
    }
}