<?php

namespace Database\Seeders;

use App\Models\FilePendukung;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FilePendukungSeeder extends Seeder
{
    /**
     * Menjalankan database seeder untuk tabel file pendukung
     */
    public function run(): void
    {
        $filePendukungData = [
            // File pendukung untuk rekam medis pasien pertama (Ahmad Santoso - Poli Umum)
            [
                'rekam_medis_id' => 1,
                'nama_file' => 'Hasil Lab Ahmad Santoso',
                'jenis_file' => 'lab',
                'file_path' => 'files/lab/ahmad_santoso_lab_20230101.pdf',
                'keterangan' => 'Hasil pemeriksaan darah lengkap',
                'created_at' => Carbon::now()->subDays(5)->setHour(9)->setMinute(30),
                'updated_at' => Carbon::now()->subDays(5)->setHour(9)->setMinute(30),
            ],
            [
                'rekam_medis_id' => 1,
                'nama_file' => 'Resep Obat Ahmad Santoso',
                'jenis_file' => 'resep',
                'file_path' => 'files/resep/ahmad_santoso_resep_20230101.pdf',
                'keterangan' => 'Resep obat ISPA',
                'created_at' => Carbon::now()->subDays(5)->setHour(9)->setMinute(45),
                'updated_at' => Carbon::now()->subDays(5)->setHour(9)->setMinute(45),
            ],

            // File pendukung untuk rekam medis pasien kedua (Siti Rahma - Poli Gigi)
            [
                'rekam_medis_id' => 2,
                'nama_file' => 'Foto Rontgen Gigi Siti Rahma',
                'jenis_file' => 'rontgen',
                'file_path' => 'files/rontgen/siti_rahma_rontgen_20230102.jpg',
                'keterangan' => 'Hasil rontgen gigi pra-penambalan',
                'created_at' => Carbon::now()->subDays(4)->setHour(10)->setMinute(45),
                'updated_at' => Carbon::now()->subDays(4)->setHour(10)->setMinute(45),
            ],
            [
                'rekam_medis_id' => 2,
                'nama_file' => 'Resep Obat Siti Rahma',
                'jenis_file' => 'resep',
                'file_path' => 'files/resep/siti_rahma_resep_20230102.pdf',
                'keterangan' => 'Resep analgesik dan antibiotik',
                'created_at' => Carbon::now()->subDays(4)->setHour(11)->setMinute(15),
                'updated_at' => Carbon::now()->subDays(4)->setHour(11)->setMinute(15),
            ],

            // File pendukung untuk rekam medis pasien ketiga (Budi Pratama - Poli Lansia)
            [
                'rekam_medis_id' => 3,
                'nama_file' => 'Hasil EKG Budi Pratama',
                'jenis_file' => 'lab',
                'file_path' => 'files/lab/budi_pratama_ekg_20230103.pdf',
                'keterangan' => 'Hasil EKG kontrol hipertensi',
                'created_at' => Carbon::now()->subDays(3)->setHour(10)->setMinute(20),
                'updated_at' => Carbon::now()->subDays(3)->setHour(10)->setMinute(20),
            ],
            [
                'rekam_medis_id' => 3,
                'nama_file' => 'Hasil Lab Budi Pratama',
                'jenis_file' => 'lab',
                'file_path' => 'files/lab/budi_pratama_lab_20230103.pdf',
                'keterangan' => 'Hasil pemeriksaan fungsi ginjal dan profil lipid',
                'created_at' => Carbon::now()->subDays(3)->setHour(10)->setMinute(30),
                'updated_at' => Carbon::now()->subDays(3)->setHour(10)->setMinute(30),
            ],

            // File pendukung untuk rekam medis pasien keempat (Dewi Sartika - Poli Kandungan)
            [
                'rekam_medis_id' => 4,
                'nama_file' => 'Hasil USG Dewi Sartika',
                'jenis_file' => 'usg',
                'file_path' => 'files/usg/dewi_sartika_usg_20230104.jpg',
                'keterangan' => 'Hasil USG kehamilan 24 minggu',
                'created_at' => Carbon::now()->subDays(2)->setHour(11)->setMinute(45),
                'updated_at' => Carbon::now()->subDays(2)->setHour(11)->setMinute(45),
            ],
            [
                'rekam_medis_id' => 4,
                'nama_file' => 'Hasil Lab Dewi Sartika',
                'jenis_file' => 'lab',
                'file_path' => 'files/lab/dewi_sartika_lab_20230104.pdf',
                'keterangan' => 'Hasil pemeriksaan darah kehamilan trimester 2',
                'created_at' => Carbon::now()->subDays(2)->setHour(12)->setMinute(10),
                'updated_at' => Carbon::now()->subDays(2)->setHour(12)->setMinute(10),
            ],

            // File pendukung untuk rekam medis pasien kelima (Hendra Wijaya - Poli Umum)
            [
                'rekam_medis_id' => 5,
                'nama_file' => 'Foto Tenggorokan Hendra Wijaya',
                'jenis_file' => 'foto',
                'file_path' => 'files/foto/hendra_wijaya_tenggorokan_20230105.jpg',
                'keterangan' => 'Foto kondisi tenggorokan yang meradang',
                'created_at' => Carbon::now()->subDay()->setHour(9)->setMinute(45),
                'updated_at' => Carbon::now()->subDay()->setHour(9)->setMinute(45),
            ],
            [
                'rekam_medis_id' => 5,
                'nama_file' => 'Resep Obat Hendra Wijaya',
                'jenis_file' => 'resep',
                'file_path' => 'files/resep/hendra_wijaya_resep_20230105.pdf',
                'keterangan' => 'Resep antibiotik dan pereda nyeri tenggorokan',
                'created_at' => Carbon::now()->subDay()->setHour(10)->setMinute(15),
                'updated_at' => Carbon::now()->subDay()->setHour(10)->setMinute(15),
            ],
        ];

        foreach ($filePendukungData as $data) {
            FilePendukung::create($data);
        }
    }
}
