<?php

namespace Database\Seeders;

use App\Models\RekamMedis;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RekamMedisSeeder extends Seeder
{
    /**
     * Menjalankan database seeder untuk tabel rekam medis
     */
    public function run(): void
    {
        $rekamMedisData = [
            // Rekam Medis untuk pendaftaran pasien pertama (Ahmad Santoso - Poli Umum)
            [
                'pasien_id' => 1, // Ahmad Santoso
                'pendaftaran_id' => 1,
                'dokter_id' => 1, // dr. Agus Setiawan
                'poli_id' => 1, // Poli Umum
                'tanggal_periksa' => Carbon::now()->subDays(5)->format('Y-m-d'),
                'keluhan' => 'Demam, batuk berdahak, pilek selama 3 hari. Suhu tubuh 38.5°C.',
                'diagnosis' => 'ISPA (Infeksi Saluran Pernapasan Atas)',
                'tindakan' => 'Pemeriksaan fisik, pengukuran suhu, dan pemeriksaan tekanan darah',
                'resep' => "1. Paracetamol 500mg 3x1\n2. Amoxicillin 500mg 3x1\n3. CTM 4mg 3x1\n4. OBH 3x1 sdm",
                'catatan' => 'Pasien dianjurkan untuk banyak istirahat dan minum air putih. Kontrol 5 hari lagi jika tidak membaik.',
                'created_at' => Carbon::now()->subDays(5)->setHour(9),
                'updated_at' => Carbon::now()->subDays(5)->setHour(9),
            ],

            // Rekam Medis untuk pendaftaran pasien kedua (Siti Rahma - Poli Gigi)
            [
                'pasien_id' => 2, // Siti Rahma
                'pendaftaran_id' => 2,
                'dokter_id' => 3, // drg. Ratna Dewi
                'poli_id' => 2, // Poli Gigi
                'tanggal_periksa' => Carbon::now()->subDays(4)->format('Y-m-d'),
                'keluhan' => 'Sakit gigi bagian geraham bawah kanan, nyeri terutama saat makan/minum dingin/panas',
                'diagnosis' => 'Karies gigi (lubang) pada gigi molar kedua kanan bawah',
                'tindakan' => 'Pemeriksaan gigi, pembersihan karies, dan penambalan sementara',
                'resep' => "1. Asam Mefenamat 500mg 3x1\n2. Amoxicillin 500mg 3x1",
                'catatan' => 'Pasien disarankan untuk kembali 1 minggu lagi untuk penambalan permanen. Hindari makanan/minuman terlalu panas atau dingin.',
                'created_at' => Carbon::now()->subDays(4)->setHour(11),
                'updated_at' => Carbon::now()->subDays(4)->setHour(11),
            ],

            // Rekam Medis untuk pendaftaran pasien ketiga (Budi Pratama - Poli Lansia)
            [
                'pasien_id' => 3, // Budi Pratama
                'pendaftaran_id' => 3,
                'dokter_id' => 6, // dr. Haryanto, Sp.PD
                'poli_id' => 5, // Poli Lansia
                'tanggal_periksa' => Carbon::now()->subDays(3)->format('Y-m-d'),
                'keluhan' => 'Kontrol rutin untuk hipertensi. Pasien merasa pusing sesekali.',
                'diagnosis' => 'Hipertensi Grade I, terkontrol',
                'tindakan' => 'Pemeriksaan tekanan darah (140/90 mmHg), EKG, pemeriksaan fisik umum',
                'resep' => "1. Amlodipine 10mg 1x1\n2. Captopril 25mg 2x1",
                'catatan' => 'Tekanan darah lebih baik dibanding kunjungan terakhir. Pasien dianjurkan untuk mengurangi konsumsi garam, rutin berolahraga ringan, dan kontrol 1 bulan lagi.',
                'created_at' => Carbon::now()->subDays(3)->setHour(10),
                'updated_at' => Carbon::now()->subDays(3)->setHour(10),
            ],

            // Rekam Medis untuk pendaftaran pasien keempat (Dewi Sartika - Poli Kandungan)
            [
                'pasien_id' => 4, // Dewi Sartika
                'pendaftaran_id' => 4,
                'dokter_id' => 5, // dr. Maya Puteri, Sp.OG
                'poli_id' => 4, // Poli Kandungan
                'tanggal_periksa' => Carbon::now()->subDays(2)->format('Y-m-d'),
                'keluhan' => 'Pemeriksaan kehamilan rutin, usia kehamilan 24 minggu. Pasien merasa sehat dan tidak ada keluhan khusus.',
                'diagnosis' => 'G1P0A0, Hamil 24 minggu, normal',
                'tindakan' => 'Pemeriksaan kandungan, pengukuran tinggi fundus, pengecekan denyut jantung janin, USG',
                'resep' => "1. Tablet Fe 1x1\n2. Kalsium 1x1\n3. Vitamin Ibu Hamil 1x1",
                'catatan' => 'Kehamilan berjalan normal, DJJ 140x/menit, posisi janin normal. Pasien dianjurkan untuk kembali 1 bulan lagi untuk pemeriksaan rutin.',
                'created_at' => Carbon::now()->subDays(2)->setHour(12),
                'updated_at' => Carbon::now()->subDays(2)->setHour(12),
            ],

            // Rekam Medis untuk pendaftaran pasien kelima (Hendra Wijaya - Poli Umum)
            [
                'pasien_id' => 5, // Hendra Wijaya
                'pendaftaran_id' => 5,
                'dokter_id' => 2, // dr. Dian Purnama
                'poli_id' => 1, // Poli Umum
                'tanggal_periksa' => Carbon::now()->subDay()->format('Y-m-d'),
                'keluhan' => 'Demam 38°C, nyeri tenggorokan, dan batuk kering selama 2 hari.',
                'diagnosis' => 'Faringitis akut',
                'tindakan' => 'Pemeriksaan fisik, pemeriksaan tenggorokan, pengukuran suhu',
                'resep' => "1. Paracetamol 500mg 3x1\n2. Azithromycin 500mg 1x1 selama 3 hari\n3. Strepsils 3x1",
                'catatan' => 'Pasien dianjurkan untuk banyak minum air hangat, istirahat cukup, dan kembali jika gejala memburuk setelah 3 hari.',
                'created_at' => Carbon::now()->subDay()->setHour(10),
                'updated_at' => Carbon::now()->subDay()->setHour(10),
            ],
        ];

        foreach ($rekamMedisData as $data) {
            RekamMedis::create($data);
        }
    }
}
