<?php
namespace Database\Seeders;

use App\Models\Pasien;
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
                'no_rm'         => 'RM-001',
                'nik'           => '3302111234567890',
                'nama'          => 'Ahmad Santoso',
                'tanggal_lahir' => Carbon::parse('1990-05-15'),
                'jenis_kelamin' => 'Laki-laki',
                'alamat'        => 'Jl. Kluwung Indah No. 123, Banyumas',
                'no_telepon'    => '081234567890',
                'foto'          => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'no_rm'         => 'RM-002',
                'nik'           => '3302112345678901',
                'nama'          => 'Siti Rahma',
                'tanggal_lahir' => Carbon::parse('1995-08-20'),
                'jenis_kelamin' => 'Perempuan',
                'alamat'        => 'Jl. Banyumas Raya No. 45, Kluwung',
                'no_telepon'    => '082345678901',
                'foto'          => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'no_rm'         => 'RM-003',
                'nik'           => '3302123456789012',
                'nama'          => 'Budi Pratama',
                'tanggal_lahir' => Carbon::parse('1985-03-10'),
                'jenis_kelamin' => 'Laki-laki',
                'alamat'        => 'Jl. Sukun No. 78, Banyumas',
                'no_telepon'    => '083456789012',
                'foto'          => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'no_rm'         => 'RM-004',
                'nik'           => '3302134567890123',
                'nama'          => 'Dewi Sartika',
                'tanggal_lahir' => Carbon::parse('1992-11-25'),
                'jenis_kelamin' => 'Perempuan',
                'alamat'        => 'Jl. Mangga No. 32, Kluwung',
                'no_telepon'    => '084567890123',
                'foto'          => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'no_rm'         => 'RM-005',
                'nik'           => '3302145678901234',
                'nama'          => 'Hendra Wijaya',
                'tanggal_lahir' => Carbon::parse('1988-07-12'),
                'jenis_kelamin' => 'Laki-laki',
                'alamat'        => 'Jl. Rambutan No. 15, Banyumas',
                'no_telepon'    => '085678901234',
                'foto'          => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ];

        foreach ($pasienData as $data) {
            Pasien::create($data);
        }
    }
}
