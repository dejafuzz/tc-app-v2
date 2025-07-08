<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_paket' => '1',
                'nama_paket' => 'I',
                'fitur' => json_encode(['For 1 Graduated', '30 Minute Photo Session', 'Without Family, Friends & GF/BF', 'Unlimited Shots','20 Photo Edited','All File on G-Drive *Expired 14 Day','Location on Campus or venue of Grad *If outside campus of venue, additional fees apply']),
                'kp_id' => '1',
            ],[
                'id_paket' => '2',
                'nama_paket' => 'II',
                'fitur' => json_encode(['For 1 Graduated', '1 Hours Photo Session', 'Unlimited Shots','Family & Guest Photo Session','35 Photo Edited','All File on G-Drive *Expired 14 Day', 'Location on Campus or venue of Grad *If outside campus of venue, additional fees apply']),
                'kp_id' => '1',
            ],[
                'id_paket' => '3',
                'nama_paket' => 'III',
                'fitur' => json_encode(['For 1 Graduated', '120 Minute Photo Session', 'Unlimited Shots','Family & Guest Photo Session','55 Photo Edited','All File on G-Drive *Expired 14 Day','Location on Campus or venue of Grad *If outside campus of venue, additional fees apply']),
                'kp_id' => '1',
            ],[
                'id_paket' => '4',
                'nama_paket' => 'Couple or Partner',
                'fitur' => json_encode(['For 2 Graduated', 'Without Family', '1 Hours Photo Session', 'Unlimited Shots', '40 Photo Edited','All File on G-Drive *Expired 14 Day','Location on Campus or venue of Grad *If outside campus of venue, additional fees apply']),
                'kp_id' => '2',
            ],[
                'id_paket' => '5',
                'nama_paket' => 'Group I',
                'fitur' => json_encode(['Max 5 Graduated', '1 Hours Photo Session', 'Unlimited Shots', '30 Photo Edited', 'Group Photo Only', 'All File on G-Drive *Expired 14 Day','Location on Campus or venue of Grad *If outside campus of venue, additional fees apply | *add graduate, will be charge 100k/person']),
                'kp_id' => '2',
            ],[
                'id_paket' => '6',
                'nama_paket' => 'Group II',
                'fitur' => json_encode(['Max 5 Graduated', '120 Minute Photo Session', 'Unlimited Shots', '50 Photo Edited', 'Group and Personal', 'All File on G-Drive *Expired 14 Day','Location on Campus or venue of Grad *If outside campus of venue, additional fees apply | *add graduate, will be charge 100k/person']),
                'kp_id' => '2',
            ],[
                'id_paket' => '7',
                'nama_paket' => 'Bercerita dgn Video I',
                'fitur' => json_encode(['1 Graduated', '90 Minute Photo & Video Session', 'Unlimited Shots', 'With Family and Guest Photo Session', '40 Photo Edited', 'Group and Personal', 'Teaser / Reels Video Instagram (1 Min more)', 'File on G-Drive (Photo & Video) *Expired 14 Day']),
                'kp_id' => '3',
            ],[
                'id_paket' => '8',
                'nama_paket' => 'Bercerita dgn Video II',
                'fitur' => json_encode(['2 Graduated', '90 Minute Photo & Video Session', 'Unlimited Shots', 'Photo and Video Couple only', '40 Photo Edited', 'Group and Personal', 'Teaser / Reels Video Instagram (1 Min more)', 'File on G-Drive (Photo & Video) *Expired 14 Day', '*Add person, will be charge 100k/person']),
                'kp_id' => '3',
            ],[
                'id_paket' => '9',
                'nama_paket' => '1 Roll (36 Frame)',
                'fitur' => json_encode(['1 Roll Film', '36 Frame Analog', 'Included Dev-Scan', 'High resolution and quality', 'File on G-Drive *Expired 14 Day', '*by appointment']),
                'kp_id' => '4',
            ],[
                'id_paket' => '10',
                'nama_paket' => '18 Frame',
                'fitur' => json_encode(['18 Frame Analog', 'Included Dev-Scan', 'High resolution and quality', 'File on G-Drive *Expired 14 Day', '*by appointment']),
                'kp_id' => '4',
            ],
        ];

        foreach ($data as $item) {
            DB::table('paket')->insert([
                'id_paket' => $item['id_paket'],
                'nama_paket' => $item['nama_paket'],
                'fitur' => $item['fitur'],
                'kp_id' => $item['kp_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
