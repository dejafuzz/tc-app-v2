<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\FotoLanding;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            FotoLandingSeeder::class,
            WilayahSeeder::class,
            KategoriSeeder::class,
            PaketSeeder::class,
            HargaSeeder::class,
            PaketTambahanSeeder::class,
            FotograferSeeder::class,
            TestimoniSeeder::class,
        ]);
    }
}