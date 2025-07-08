<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestimoniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_testimoni' => 'TST001',
                'nama' => 'Rina Putri',
                'event' => 'Wisuda Universitas Gadjah Mada',
                'deskripsi' => 'Saya sangat puas dengan pelayanan dari tim ini. Mereka tidak hanya tepat waktu, tetapi juga sangat profesional dalam mengambil setiap momen penting di hari wisuda saya.',
                'status' => 'Posted',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_testimoni' => 'TST002',
                'nama' => 'Fajar Nugroho',
                'event' => 'Graduation Universitas Indonesia',
                'deskripsi' => 'Saya tidak menyangka hasil dokumentasi wisuda saya akan sebagus ini. Fotografernya sangat ramah dan mampu membuat saya nyaman sepanjang sesi foto.',
                'status' => 'Posted',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_testimoni' => 'TST003',
                'nama' => 'Dewi Lestari',
                'event' => 'Sidang Skripsi UNNES',
                'deskripsi' => 'Momen sidang skripsi adalah salah satu hal paling penting dalam hidup saya, dan saya sangat bersyukur mempercayakan dokumentasinya kepada tim ini.',
                'status' => 'Posted',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_testimoni' => 'TST004',
                'nama' => 'Bagus Priambodo',
                'event' => 'Wisuda Politeknik Negeri Semarang',
                'deskripsi' => 'Tim ini bekerja sangat efisien dan hasilnya benar-benar melebihi ekspektasi saya. Tidak hanya dokumentasi saat prosesi, tapi juga sesi foto bersama keluarga dibuat dengan sangat baik dan berkesan.',
                'status' => 'Posted',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_testimoni' => 'TST005',
                'nama' => 'Siti Marlina',
                'event' => 'Graduation Ceremony STMIK AMIKOM Yogyakarta',
                'deskripsi' => 'Sebagai mahasiswa yang sibuk, saya ingin semuanya berjalan lancar di hari wisuda, termasuk dokumentasinya. Dan tim ini benar-benar memberikan pelayanan terbaik! Mereka sangat responsif, sopan, dan hasil akhirnya sangat menyentuh hati.',
                'status' => 'Posted',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('testimoni')->insert($data);
    }
}
