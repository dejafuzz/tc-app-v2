<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public static function resetAntrian()
    {
        DB::transaction(function () {
            DB::table('foto')->update(['antrian' => null]);

            DB::statement("
                UPDATE foto f
                JOIN (
                    SELECT id_foto, ROW_NUMBER() OVER (
                        ORDER BY
                            CASE WHEN status_foto = 'Editing' THEN 1
                                WHEN status_foto = 'List File Edit' THEN 2
                                ELSE 3 END,
                            tanggal_list ASC
                    ) AS rn
                    FROM foto
                    WHERE status_foto IN ('Editing', 'List File Edit')
                ) o ON f.id_foto = o.id_foto
                SET f.antrian = o.rn
            ");
        });
    }
}