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
                'nama' => 'Poli Umum',
                'deskripsi' => 'Pelayanan kesehatan umum untuk segala usia',
                'kuota_harian' => 50,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Poli Gigi',
                'deskripsi' => 'Pemeriksaan dan perawatan kesehatan gigi dan mulut',
                'kuota_harian' => 25,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Poli Anak',
                'deskripsi' => 'Pelayanan kesehatan khusus untuk anak-anak',
                'kuota_harian' => 30,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Poli Kandungan',
                'deskripsi' => 'Pelayanan kesehatan untuk ibu hamil dan kesehatan reproduksi wanita',
                'kuota_harian' => 20,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Poli Lansia',
                'deskripsi' => 'Pelayanan kesehatan khusus untuk lansia',
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
