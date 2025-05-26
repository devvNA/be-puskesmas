<?php

namespace Database\Seeders;

use App\Models\Poli;
use Illuminate\Database\Seeder;

class PoliSeeder extends Seeder
{
    /**
     * Menjalankan database seeder untuk tabel poli
     */
    public function run(): void
    {
        $poliData = [
            [
                'nama' => 'Poli Gigi & Mulut',
                'deskripsi' => 'Pemeriksaan dan perawatan kesehatan gigi dan mulut',
                'kuota_harian' => 25,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Poli Umum',
                'deskripsi' => 'Pelayanan kesehatan umum untuk segala usia',
                'kuota_harian' => 50,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Poli KIA & KB',
                'deskripsi' => 'Pelayanan kesehatan untuk ibu hamil, anak, dan keluarga berencana',
                'kuota_harian' => 30,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Poli MTBS',
                'deskripsi' => 'Manajemen Terpadu Balita Sakit untuk pelayanan kesehatan balita',
                'kuota_harian' => 20,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Poli P2PM',
                'deskripsi' => 'Pencegahan dan Pengendalian Penyakit Menular',
                'kuota_harian' => 15,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($poliData as $data) {
            Poli::create($data);
        }
    }
}
