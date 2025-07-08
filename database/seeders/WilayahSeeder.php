<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kode' => 'W1', 'nama_wilayah' => 'JAKARTA'],
            ['kode' => 'W1', 'nama_wilayah' => 'BOGOR'],
            ['kode' => 'W1', 'nama_wilayah' => 'BANDUNG'],
            ['kode' => 'W1', 'nama_wilayah' => 'SURABAYA'],
            ['kode' => 'W2', 'nama_wilayah' => 'YOGYAKARTA'],
            ['kode' => 'W2', 'nama_wilayah' => 'SOLO'],
            ['kode' => 'W2', 'nama_wilayah' => 'SEMARANG'],
            ['kode' => 'W2', 'nama_wilayah' => 'PURWOKERTO'],
            ['kode' => 'W3', 'nama_wilayah' => 'MALANG AND SURROUNDING'],
            ['kode' => 'W4', 'nama_wilayah' => 'BALI'],
            ['kode' => 'W4', 'nama_wilayah' => 'LOMBOK'],
        ];

        foreach ($data as $item) {
            DB::table('wilayah')->insert([
                'id_wilayah' => Str::uuid(),
                'kode' => $item['kode'],
                'nama_wilayah' => $item['nama_wilayah'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
