<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoLanding extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_foto_landing';
    protected $table = 'foto_landing';
    protected $guarded = [];
    protected $casts = [
        'id_foto_landing' => 'string'
    ];
}