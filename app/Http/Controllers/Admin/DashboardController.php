<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use App\Models\Poli;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Data untuk statistik kunjungan tahun ini
        $tahunIni = date('Y');
        $tahunLalu = $tahunIni - 1;

        // Data kunjungan per bulan untuk tahun ini dan tahun lalu
        $kunjunganTahunIni = [
            'Januari' => rand(120, 180),
            'Februari' => rand(130, 190),
            'Maret' => rand(140, 200),
            'April' => rand(150, 210),
            'Mei' => rand(160, 220),
            'Juni' => rand(170, 230),
            'Juli' => date('n') > 7 ? rand(180, 240) : 0,
            'Agustus' => date('n') > 8 ? rand(170, 250) : 0,
            'September' => date('n') > 9 ? rand(160, 230) : 0,
            'Oktober' => date('n') > 10 ? rand(150, 220) : 0,
            'November' => date('n') > 11 ? rand(140, 210) : 0,
            'Desember' => date('n') > 12 ? rand(160, 220) : 0
        ];

        $kunjunganTahunLalu = [
            'Januari' => rand(100, 160),
            'Februari' => rand(110, 170),
            'Maret' => rand(120, 180),
            'April' => rand(130, 190),
            'Mei' => rand(140, 200),
            'Juni' => rand(150, 210),
            'Juli' => rand(160, 220),
            'Agustus' => rand(150, 230),
            'September' => rand(140, 210),
            'Oktober' => rand(130, 200),
            'November' => rand(120, 190),
            'Desember' => rand(140, 200)
        ];

        // Data untuk status kehadiran
        $statusKehadiran = [
            'Hadir' => rand(60, 70),
            'Tidak Hadir' => rand(10, 20),
            'Terlambat' => rand(8, 15),
            'Reschedule' => rand(5, 10)
        ];

        // Aktivitas terkini dummy
        $aktivitasTerkini = [
            [
                'judul' => 'Pendaftaran Pasien Baru',
                'waktu' => '2 menit yang lalu',
                'icon' => 'fa-user-plus',
                'warna' => 'primary'
            ],
            [
                'judul' => 'Pemeriksaan Selesai',
                'waktu' => '10 menit yang lalu',
                'icon' => 'fa-notes-medical',
                'warna' => 'success'
            ],
            [
                'judul' => 'Jadwal Dokter Diperbarui',
                'waktu' => '30 menit yang lalu',
                'icon' => 'fa-calendar-check',
                'warna' => 'info'
            ],
            [
                'judul' => 'Rekam Medis Baru Ditambahkan',
                'waktu' => '1 jam yang lalu',
                'icon' => 'fa-file-medical',
                'warna' => 'warning'
            ],
            [
                'judul' => 'Obat Diterima Pasien',
                'waktu' => '2 jam yang lalu',
                'icon' => 'fa-pills',
                'warna' => 'danger'
            ]
        ];

        return view('admin.dashboard', compact(
            'tahunIni',
            'tahunLalu',
            'kunjunganTahunIni',
            'kunjunganTahunLalu',
            'statusKehadiran',
            'aktivitasTerkini'
        ));
    }
}
