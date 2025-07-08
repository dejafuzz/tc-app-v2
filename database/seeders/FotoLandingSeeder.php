<?php

namespace Database\Seeders;

use App\Models\FotoLanding;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FotoLandingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['univ' => 'UNIV. PANDJAJARAN', 'keterangan' => 'A prestigious campus with many innovations', 'foto' => 'landing/img/home-sample/unpad.jpg'],
            ['univ' => 'UNIV. INDONESIA', 'keterangan' => 'One of the best universities in Indonesia', 'foto' => 'landing/img/home-sample/ui.jpg'],
            ['univ' => 'BINUS', 'keterangan' => 'Leading technology and business campuses', 'foto' => 'landing/img/home-sample/binus.jpg'],
            ['univ' => 'TRISAKTI', 'keterangan' => 'Known for its legal and engineering education', 'foto' => 'landing/img/home-sample/trisakti.jpg'],
            ['univ' => 'PRESIDEN UNIVERSITY', 'keterangan' => 'International universities in Indonesia', 'foto' => 'landing/img/home-sample/presiden.jpg'],
            ['univ' => 'UNIV. DIPONEGORO', 'keterangan' => 'The Pride of Central Java University', 'foto' => 'landing/img/home-sample/undip.jpg'],
            ['univ' => 'UNIV. NEGERI SEMARANG', 'keterangan' => 'Excellent campus with quality education', 'foto' => 'landing/img/home-sample/unes.jpg'],
        ];

        foreach ($data as $item) {
            $originalPath = public_path($item['foto']); // Path asli di public
            $storagePath = 'uploads/foto_landing/' . basename($item['foto']); // Path tujuan di storage

            if (file_exists($originalPath)) {
                // Pindahkan file ke storage
                Storage::disk('public')->put($storagePath, file_get_contents($originalPath));
            } else {
                $storagePath = null; // Jika file tidak ditemukan, set null
            }

            FotoLanding::create([
                'id_foto_landing' => Str::upper(Str::random(4)),
                'univ' => $item['univ'],
                'keterangan' => $item['keterangan'],
                'foto' => $storagePath, // Simpan path baru
                'status' => 'Posted',
            ]);
        }
    }
}
