<?php

namespace Database\Seeders;

use App\Models\Pendaftaran;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PendaftaranSeeder extends Seeder
{
    /**
     * Menjalankan database seeder untuk tabel pendaftaran
     */
    public function run(): void
    {
        $pendaftaranData = [
            // Pendaftaran untuk Pasien 1 (Ahmad Santoso) di Poli Umum
            [
                'pasien_id' => 1, // Ahmad Santoso
                'poli_id' => 1, // Poli Umum
                'dokter_id' => 1, // dr. Agus Setiawan
                'tanggal_pendaftaran' => Carbon::now()->subDays(5)->format('Y-m-d'),
                'no_antrian' => 1,
                'status_kehadiran' => 'sudah hadir',
                'waktu_hadir' => Carbon::now()->subDays(5)->setHour(8)->setMinute(30),
                'keterangan' => 'Pasien datang tepat waktu',
                'waktu_dipanggil' => Carbon::now()->subDays(5)->setHour(8)->setMinute(45),
                'created_at' => Carbon::now()->subDays(5)->setHour(7),
                'updated_at' => Carbon::now()->subDays(5)->setHour(8)->setMinute(30),
            ],

            // Pendaftaran untuk Pasien 2 (Siti Rahma) di Poli Gigi
            [
                'pasien_id' => 2, // Siti Rahma
                'poli_id' => 2, // Poli Gigi
                'dokter_id' => 3, // drg. Ratna Dewi
                'tanggal_pendaftaran' => Carbon::now()->subDays(4)->format('Y-m-d'),
                'no_antrian' => 3,
                'status_kehadiran' => 'sudah hadir',
                'waktu_hadir' => Carbon::now()->subDays(4)->setHour(10)->setMinute(15),
                'keterangan' => 'Pasien melaporkan sakit gigi',
                'waktu_dipanggil' => Carbon::now()->subDays(4)->setHour(10)->setMinute(30),
                'created_at' => Carbon::now()->subDays(4)->setHour(8),
                'updated_at' => Carbon::now()->subDays(4)->setHour(10)->setMinute(15),
            ],

            // Pendaftaran untuk Pasien 3 (Budi Pratama) di Poli Lansia
            [
                'pasien_id' => 3, // Budi Pratama
                'poli_id' => 5, // Poli Lansia
                'dokter_id' => 6, // dr. Haryanto, Sp.PD
                'tanggal_pendaftaran' => Carbon::now()->subDays(3)->format('Y-m-d'),
                'no_antrian' => 5,
                'status_kehadiran' => 'sudah hadir',
                'waktu_hadir' => Carbon::now()->subDays(3)->setHour(9)->setMinute(45),
                'keterangan' => 'Kontrol rutin',
                'waktu_dipanggil' => Carbon::now()->subDays(3)->setHour(10)->setMinute(0),
                'created_at' => Carbon::now()->subDays(3)->setHour(7)->setMinute(30),
                'updated_at' => Carbon::now()->subDays(3)->setHour(9)->setMinute(45),
            ],

            // Pendaftaran untuk Pasien 4 (Dewi Sartika) di Poli Kandungan
            [
                'pasien_id' => 4, // Dewi Sartika
                'poli_id' => 4, // Poli Kandungan
                'dokter_id' => 5, // dr. Maya Puteri, Sp.OG
                'tanggal_pendaftaran' => Carbon::now()->subDays(2)->format('Y-m-d'),
                'no_antrian' => 2,
                'status_kehadiran' => 'sudah hadir',
                'waktu_hadir' => Carbon::now()->subDays(2)->setHour(11),
                'keterangan' => 'Pemeriksaan kehamilan 6 bulan',
                'waktu_dipanggil' => Carbon::now()->subDays(2)->setHour(11)->setMinute(15),
                'created_at' => Carbon::now()->subDays(2)->setHour(9),
                'updated_at' => Carbon::now()->subDays(2)->setHour(11),
            ],

            // Pendaftaran untuk Pasien 5 (Hendra Wijaya) di Poli Umum
            [
                'pasien_id' => 5, // Hendra Wijaya
                'poli_id' => 1, // Poli Umum
                'dokter_id' => 2, // dr. Dian Purnama
                'tanggal_pendaftaran' => Carbon::now()->subDay()->format('Y-m-d'),
                'no_antrian' => 7,
                'status_kehadiran' => 'sudah hadir',
                'waktu_hadir' => Carbon::now()->subDay()->setHour(9)->setMinute(20),
                'keterangan' => 'Pasien mengeluh demam dan batuk',
                'waktu_dipanggil' => Carbon::now()->subDay()->setHour(9)->setMinute(35),
                'created_at' => Carbon::now()->subDay()->setHour(8),
                'updated_at' => Carbon::now()->subDay()->setHour(9)->setMinute(20),
            ],

            // Pendaftaran untuk hari ini (belum hadir)
            [
                'pasien_id' => 1, // Ahmad Santoso
                'poli_id' => 1, // Poli Umum
                'dokter_id' => 1, // dr. Agus Setiawan
                'tanggal_pendaftaran' => Carbon::now()->format('Y-m-d'),
                'no_antrian' => 4,
                'status_kehadiran' => 'belum hadir',
                'waktu_hadir' => null,
                'keterangan' => 'Kontrol setelah sakit 5 hari yang lalu',
                'waktu_dipanggil' => Carbon::now()->setHour(10)->setMinute(15),
                'created_at' => Carbon::now()->subHours(2),
                'updated_at' => Carbon::now()->subHours(2),
            ],
            [
                'pasien_id' => 3, // Budi Pratama
                'poli_id' => 3, // Poli Anak
                'dokter_id' => 4, // dr. Budi Santoso, Sp.A
                'tanggal_pendaftaran' => Carbon::now()->format('Y-m-d'),
                'no_antrian' => 2,
                'status_kehadiran' => 'belum hadir',
                'waktu_hadir' => null,
                'keterangan' => 'Memeriksakan anaknya yang sakit',
                'waktu_dipanggil' => Carbon::now()->setHour(9)->setMinute(30),
                'created_at' => Carbon::now()->subHours(3),
                'updated_at' => Carbon::now()->subHours(3),
            ],
        ];

        foreach ($pendaftaranData as $data) {
            Pendaftaran::create($data);
        }
    }
}
