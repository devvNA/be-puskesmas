<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            UserSeeder::class,
            PasienSeeder::class,
            PoliSeeder::class,
            DokterSeeder::class,
            JadwalPoliSeeder::class,
            JadwalDokterSeeder::class,
            PendaftaranSeeder::class,
            RekamMedisSeeder::class,
            FilePendukungSeeder::class,
            ObatSeeder::class,
        ]);
    }
}
