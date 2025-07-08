<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama_kategori' => 'Private Package','id_kp' => '1'],
            ['nama_kategori' => 'Couple & Group Package','id_kp' => '2'],
            ['nama_kategori' => 'Photo & Video','id_kp' => '3'],
            ['nama_kategori' => 'Add on Analog','id_kp' => '4'],
        ];

        foreach ($data as $item) {
            DB::table('kategori_paket')->insert([
                'id_kp' => $item['id_kp'],
                'nama_kategori' => $item['nama_kategori'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
