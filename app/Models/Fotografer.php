<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fotografer extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_fotografer';
    protected $table = 'fotografer';
    protected $guarded = [];

}