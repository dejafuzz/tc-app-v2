<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaketTambahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['jenis_tambahan' => 'Extra Time 30 Minute'],
            ['jenis_tambahan' => 'Extra Time 60 Minute'],
            ['jenis_tambahan' => 'Fisheye Lens'],
            ['jenis_tambahan' => 'Video (1 Minutes Video)'],
            ['jenis_tambahan' => 'Split Time *by appointment'],
            ['jenis_tambahan' => 'Extra Edited 10 Photo'],
            ['jenis_tambahan' => 'Extra Person'],
        ];

        foreach ($data as $item) {
            DB::table('paket_tambahan')->insert([
                'id_paket_tambahan' => Str::uuid(),
                'jenis_tambahan' => $item['jenis_tambahan'],
                // 'harga_tambahan' => $item['harga_tambahan'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}