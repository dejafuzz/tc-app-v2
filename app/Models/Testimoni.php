<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_testimoni';
    protected $table = 'testimoni';
    protected $casts = [
        'id_testimoni' => 'string'
    ];
}