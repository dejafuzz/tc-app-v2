<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FotograferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama' => 'Andi Saputra', 'no_wa' => '6281234567890'],
            ['nama' => 'Budi Santoso', 'no_wa' => '6285678901234'],
            ['nama' => 'Citra Permata', 'no_wa' => '6289876543210'],
            ['nama' => 'Dewi Anggraini', 'no_wa' => '6282233445566'],
        ];

        foreach ($data as $item) {
            DB::table('fotografer')->insert([
                'nama' => $item['nama'],
                'no_wa' => $item['no_wa'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
