<?php

namespace Database\Seeders;

use App\Models\Pasien;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PasienSeeder extends Seeder
{
    /**
     * Menjalankan database seeder untuk tabel pasien
     */
    public function run(): void
    {
        $pasienData = [
            [
                'no_rm'             => 'RM-001',
                'nik'               => '3302111234567890',
                'no_bpjs'           => '0001234567890',
                'jenis'             => 'Reguler (BPJS)',
                'golongan_darah'    => 'A',
                'hubungan_keluarga' => 'Kepala Keluarga',
                'nama'              => 'Ahmad Santoso',
                'tanggal_lahir'     => Carbon::parse('1990-05-15'),
                'jenis_kelamin'     => 'Laki-laki',
                'alamat'            => 'Jl. Kluwung Indah No. 123, Banyumas',
                'rt'                => '001',
                'rw'                => '002',
                'provinsi'          => 'Jawa Tengah',
                'no_telepon'        => '081234567890',
                'email'             => 'ahmad.santoso@example.com',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'no_rm'             => 'RM-002',
                'nik'               => '3302112345678901',
                'no_bpjs'           => '0001234567891',
                'jenis'             => 'Reguler (BPJS)',
                'golongan_darah'    => 'AB',
                'hubungan_keluarga' => 'Istri',
                'nama'              => 'Siti Rahma',
                'tanggal_lahir'     => Carbon::parse('1995-08-20'),
                'jenis_kelamin'     => 'Perempuan',
                'alamat'            => 'Jl. Kluwung Indah No. 123, Banyumas',
                'rt'                => '001',
                'rw'                => '002',
                'provinsi'          => 'Jawa Tengah',
                'no_telepon'        => '082345678901',
                'email'             => 'siti.rahma@example.com',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'no_rm'             => 'RM-003',
                'nik'               => '3302123456789012',
                'no_bpjs'           => '0001234567892',
                'jenis'             => 'Reguler (BPJS)',
                'hubungan_keluarga' => 'Anak',
                'nama'              => 'Budi Pratama',
                'tanggal_lahir'     => Carbon::parse('2010-03-10'),
                'jenis_kelamin'     => 'Laki-laki',
                'alamat'            => 'Jl. Kluwung Indah No. 123, Banyumas',
                'rt'                => '001',
                'rw'                => '002',
                'provinsi'          => 'Jawa Tengah',
                'no_telepon'        => '083456789012',
                'email'             => 'budi.pratama@example.com',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'no_rm'             => 'RM-004',
                'nik'               => '3302134567890123',
                'no_bpjs'           => null,
                'jenis'             => 'Eksekutif (Non BPJS)',
                'hubungan_keluarga' => 'Kepala Keluarga',
                'nama'              => 'Dewi Sartika',
                'tanggal_lahir'     => Carbon::parse('1992-11-25'),
                'jenis_kelamin'     => 'Perempuan',
                'alamat'            => 'Jl. Mangga No. 32, Kluwung',
                'rt'                => '003',
                'rw'                => '005',
                'provinsi'          => 'Jawa Tengah',
                'no_telepon'        => '084567890123',
                'email'             => 'dewi.sartika@example.com',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'no_rm'             => 'RM-005',
                'nik'               => '3302145678901234',
                'no_bpjs'           => '0001234567893',
                'jenis'             => 'Reguler (BPJS)',
                'hubungan_keluarga' => 'Kepala Keluarga',
                'nama'              => 'Hendra Wijaya',
                'tanggal_lahir'     => Carbon::parse('1988-07-12'),
                'jenis_kelamin'     => 'Laki-laki',
                'alamat'            => 'Jl. Rambutan No. 15, Banyumas',
                'rt'                => '002',
                'rw'                => '004',
                'provinsi'          => 'Jawa Tengah',
                'no_telepon'        => '085678901234',
                'email'             => 'hendra.wijaya@example.com',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
        ];

        foreach ($pasienData as $data) {
            Pasien::create($data);
        }
    }
}
