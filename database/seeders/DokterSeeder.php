<?php

namespace Database\Seeders;

use App\Models\Dokter;
use Illuminate\Database\Seeder;

class DokterSeeder extends Seeder
{
    /**
     * Menjalankan database seeder untuk tabel dokter
     */
    public function run(): void
    {
        $dokterData = [
            [
                'poli_id' => 2, // Poli Umum
                'nama' => 'dr. Agus Setiawan',
                'spesialisasi' => 'Dokter Umum',
                'foto' => null,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'poli_id' => 2, // Poli Umum
                'nama' => 'dr. Dian Purnama',
                'spesialisasi' => 'Dokter Umum',
                'foto' => null,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'poli_id' => 1, // Poli Gigi & Mulut
                'nama' => 'drg. Ratna Dewi',
                'spesialisasi' => 'Dokter Gigi',
                'foto' => null,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'poli_id' => 4, // Poli MTBS
                'nama' => 'dr. Budi Santoso, Sp.A',
                'spesialisasi' => 'Spesialis Anak',
                'foto' => null,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'poli_id' => 3, // Poli KIA & KB
                'nama' => 'dr. Maya Puteri, Sp.OG',
                'spesialisasi' => 'Spesialis Obstetri dan Ginekologi',
                'foto' => null,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'poli_id' => 5, // Poli P2PM
                'nama' => 'dr. Haryanto, Sp.PD',
                'spesialisasi' => 'Spesialis Penyakit Dalam',
                'foto' => null,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($dokterData as $data) {
            Dokter::create($data);
        }
    }
}
