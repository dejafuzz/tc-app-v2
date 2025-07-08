<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_wilayah';
    protected $table = 'wilayah';
    protected $guarded = [];
    protected $casts = [
        'id_wilayah' => 'string'
    ];
}