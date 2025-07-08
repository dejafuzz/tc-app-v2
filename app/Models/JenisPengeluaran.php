<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPengeluaran extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_jenis_pengeluaran';
    protected $table = 'jenis_pengeluaran';
    protected $guarded = [];

    public function pengeluaran()
    {
        return $this->hasMany(Pengeluaran::class,'jenis_pengeluaran_id','id_jenis_pengeluaran');
    }
}