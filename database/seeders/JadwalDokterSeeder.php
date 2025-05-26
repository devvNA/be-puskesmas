<?php

namespace Database\Seeders;

use App\Models\JadwalDokter;
use Illuminate\Database\Seeder;

class JadwalDokterSeeder extends Seeder
{
    /**
     * Menjalankan database seeder untuk tabel jadwal dokter
     */
    public function run(): void
    {
        $jadwalDokterData = [
            // Jadwal dr. Agus Setiawan (Poli Umum)
            [
                'dokter_id' => 1,
                'hari' => 'Senin',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '12:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dokter_id' => 1,
                'hari' => 'Rabu',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '12:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dokter_id' => 1,
                'hari' => 'Jumat',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '12:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Jadwal dr. Dian Purnama (Poli Umum)
            [
                'dokter_id' => 2,
                'hari' => 'Selasa',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '16:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dokter_id' => 2,
                'hari' => 'Kamis',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '16:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Jadwal drg. Ratna Dewi (Poli Gigi & Mulut)
            [
                'dokter_id' => 3,
                'hari' => 'Senin',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '15:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dokter_id' => 3,
                'hari' => 'Rabu',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '15:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dokter_id' => 3,
                'hari' => 'Jumat',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '15:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Jadwal dr. Budi Santoso, Sp.A (Poli MTBS)
            [
                'dokter_id' => 4,
                'hari' => 'Selasa',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '14:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dokter_id' => 4,
                'hari' => 'Kamis',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '14:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Jadwal dr. Maya Puteri, Sp.OG (Poli KIA & KB)
            [
                'dokter_id' => 5,
                'hari' => 'Senin',
                'jam_mulai' => '10:00:00',
                'jam_selesai' => '14:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dokter_id' => 5,
                'hari' => 'Kamis',
                'jam_mulai' => '10:00:00',
                'jam_selesai' => '14:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Jadwal dr. Haryanto, Sp.PD (Poli P2PM)
            [
                'dokter_id' => 6,
                'hari' => 'Rabu',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '13:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dokter_id' => 6,
                'hari' => 'Jumat',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '13:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($jadwalDokterData as $data) {
            JadwalDokter::create($data);
        }
    }
}
