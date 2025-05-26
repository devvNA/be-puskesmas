<?php

namespace Database\Seeders;

use App\Models\JadwalPoli;
use Illuminate\Database\Seeder;

class JadwalPoliSeeder extends Seeder
{
    /**
     * Menjalankan database seeder untuk tabel jadwal poli
     */
    public function run(): void
    {
        $jadwalPoliData = [
            // Jadwal Poli Umum
            [
                'poli_id' => 2,
                'hari' => 'Senin',
                'jam_buka' => '08:00:00',
                'jam_tutup' => '16:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'poli_id' => 2,
                'hari' => 'Selasa',
                'jam_buka' => '08:00:00',
                'jam_tutup' => '16:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'poli_id' => 2,
                'hari' => 'Rabu',
                'jam_buka' => '08:00:00',
                'jam_tutup' => '16:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'poli_id' => 2,
                'hari' => 'Kamis',
                'jam_buka' => '08:00:00',
                'jam_tutup' => '16:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'poli_id' => 2,
                'hari' => 'Jumat',
                'jam_buka' => '08:00:00',
                'jam_tutup' => '15:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Jadwal Poli Gigi & Mulut
            [
                'poli_id' => 1,
                'hari' => 'Senin',
                'jam_buka' => '09:00:00',
                'jam_tutup' => '15:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'poli_id' => 1,
                'hari' => 'Rabu',
                'jam_buka' => '09:00:00',
                'jam_tutup' => '15:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'poli_id' => 1,
                'hari' => 'Jumat',
                'jam_buka' => '09:00:00',
                'jam_tutup' => '15:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Jadwal Poli KIA & KB
            [
                'poli_id' => 3,
                'hari' => 'Selasa',
                'jam_buka' => '08:00:00',
                'jam_tutup' => '14:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'poli_id' => 3,
                'hari' => 'Kamis',
                'jam_buka' => '08:00:00',
                'jam_tutup' => '14:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Jadwal Poli MTBS
            [
                'poli_id' => 4,
                'hari' => 'Senin',
                'jam_buka' => '10:00:00',
                'jam_tutup' => '14:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'poli_id' => 4,
                'hari' => 'Kamis',
                'jam_buka' => '10:00:00',
                'jam_tutup' => '14:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Jadwal Poli P2PM
            [
                'poli_id' => 5,
                'hari' => 'Rabu',
                'jam_buka' => '08:00:00',
                'jam_tutup' => '13:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'poli_id' => 5,
                'hari' => 'Jumat',
                'jam_buka' => '08:00:00',
                'jam_tutup' => '13:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($jadwalPoliData as $data) {
            JadwalPoli::create($data);
        }
    }
}
