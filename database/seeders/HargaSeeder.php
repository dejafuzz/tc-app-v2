<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'harga' => 400000,
                'golongan' => 'W1',
                'paket_id' => '1',
            ],[
                'harga' => 550000,
                'golongan' => 'W1',
                'paket_id' => '2',
            ],[
                'harga' => 1000000,
                'golongan' => 'W1',
                'paket_id' => '3',
            ],[
                'harga' => 750000,
                'golongan' => 'W1',
                'paket_id' => '4',
            ],[
                'harga' => 650000,
                'golongan' => 'W1',
                'paket_id' => '5',
            ],[
                'harga' => 1200000,
                'golongan' => 'W1',
                'paket_id' => '6',
            ],[
                'harga' => 1800000,
                'golongan' => 'W1',
                'paket_id' => '7',
            ],[
                'harga' => 1650000,
                'golongan' => 'W1',
                'paket_id' => '8',
            ],[
                'harga' => 700000,
                'golongan' => 'W1',
                'paket_id' => '9',
            ],[
                'harga' => 400000,
                'golongan' => 'W1',
                'paket_id' => '10',
            ],

            [
                'harga' => 300000,
                'golongan' => 'W2',
                'paket_id' => '1',
            ],[
                'harga' => 400000,
                'golongan' => 'W2',
                'paket_id' => '2',
            ],[
                'harga' => 750000,
                'golongan' => 'W2',
                'paket_id' => '3',
            ],[
                'harga' => 550000,
                'golongan' => 'W2',
                'paket_id' => '4',
            ],[
                'harga' => 500000,
                'golongan' => 'W2',
                'paket_id' => '5',
            ],[
                'harga' => 900000,
                'golongan' => 'W2',
                'paket_id' => '6',
            ],[
                'harga' => 1450000,
                'golongan' => 'W2',
                'paket_id' => '7',
            ],[
                'harga' => 1350000,
                'golongan' => 'W2',
                'paket_id' => '8',
            ],[
                'harga' => 550000,
                'golongan' => 'W2',
                'paket_id' => '9',
            ],[
                'harga' => 300000,
                'golongan' => 'W2',
                'paket_id' => '10',
            ],

            [
                'harga' => 350000,
                'golongan' => 'W3',
                'paket_id' => '1',
            ],[
                'harga' => 450000,
                'golongan' => 'W3',
                'paket_id' => '2',
            ],[
                'harga' => 850000,
                'golongan' => 'W3',
                'paket_id' => '3',
            ],[
                'harga' => 650000,
                'golongan' => 'W3',
                'paket_id' => '4',
            ],[
                'harga' => 700000,
                'golongan' => 'W3',
                'paket_id' => '5',
            ],[
                'harga' => 1100000,
                'golongan' => 'W3',
                'paket_id' => '6',
            ],[
                'harga' => 1500000,
                'golongan' => 'W3',
                'paket_id' => '7',
            ],[
                'harga' => 1350000,
                'golongan' => 'W3',
                'paket_id' => '8',
            ],[
                'harga' => 550000,
                'golongan' => 'W3',
                'paket_id' => '9',
            ],[
                'harga' => 350000,
                'golongan' => 'W3',
                'paket_id' => '10',
            ],

            [
                'harga' => 450000,
                'golongan' => 'W4',
                'paket_id' => '1',
            ],[
                'harga' => 650000,
                'golongan' => 'W4',
                'paket_id' => '2',
            ],[
                'harga' => 1200000,
                'golongan' => 'W4',
                'paket_id' => '3',
            ],[
                'harga' => 900000,
                'golongan' => 'W4',
                'paket_id' => '4',
            ],[
                'harga' => 850000,
                'golongan' => 'W4',
                'paket_id' => '5',
            ],[
                'harga' => 1450000,
                'golongan' => 'W4',
                'paket_id' => '6',
            ],[
                'harga' => 2500000,
                'golongan' => 'W4',
                'paket_id' => '7',
            ],[
                'harga' => 2000000,
                'golongan' => 'W4',
                'paket_id' => '8',
            ],[
                'harga' => 800000,
                'golongan' => 'W4',
                'paket_id' => '9',
            ],[
                'harga' => 450000,
                'golongan' => 'W4',
                'paket_id' => '10',
            ],
        ];

        foreach ($data as $item) {
            DB::table('harga_paket')->insert([
                'id_harga_paket' => Str::uuid(),
                'harga' => $item['harga'],
                'golongan' => $item['golongan'],
                'paket_id' => $item['paket_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
