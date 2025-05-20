<?php

namespace Database\Seeders;

use App\Models\Obat;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ObatSeeder extends Seeder
{
    /**
     * Menjalankan seeder untuk data obat
     */
    public function run(): void
    {
        $obatData = [
            [
                'kode_obat' => 'OBT001',
                'nama_obat' => 'Paracetamol',
                'jenis_obat' => 'Tablet',
                'satuan' => 'Strip',
                'deskripsi' => 'Obat untuk meredakan demam dan nyeri ringan sampai sedang',
                'stok' => 100,
                'harga' => 5000.00,
                'tanggal_kadaluarsa' => Carbon::now()->addYears(2),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_obat' => 'OBT002',
                'nama_obat' => 'Amoxicillin',
                'jenis_obat' => 'Kapsul',
                'satuan' => 'Strip',
                'deskripsi' => 'Antibiotik untuk mengatasi infeksi bakteri',
                'stok' => 75,
                'harga' => 15000.00,
                'tanggal_kadaluarsa' => Carbon::now()->addYears(1)->addMonths(6),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_obat' => 'OBT003',
                'nama_obat' => 'Antasida',
                'jenis_obat' => 'Sirup',
                'satuan' => 'Botol',
                'deskripsi' => 'Obat untuk meredakan gejala sakit maag dan asam lambung',
                'stok' => 50,
                'harga' => 20000.00,
                'tanggal_kadaluarsa' => Carbon::now()->addYears(2)->addMonths(3),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_obat' => 'OBT004',
                'nama_obat' => 'Dexamethasone',
                'jenis_obat' => 'Tablet',
                'satuan' => 'Strip',
                'deskripsi' => 'Obat golongan kortikosteroid untuk mengurangi peradangan',
                'stok' => 60,
                'harga' => 12000.00,
                'tanggal_kadaluarsa' => Carbon::now()->addYears(1)->addMonths(8),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_obat' => 'OBT005',
                'nama_obat' => 'Vitamin C',
                'jenis_obat' => 'Tablet',
                'satuan' => 'Botol',
                'deskripsi' => 'Suplemen untuk meningkatkan daya tahan tubuh',
                'stok' => 120,
                'harga' => 25000.00,
                'tanggal_kadaluarsa' => Carbon::now()->addYears(3),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_obat' => 'OBT006',
                'nama_obat' => 'Salbutamol',
                'jenis_obat' => 'Inhaler',
                'satuan' => 'Buah',
                'deskripsi' => 'Obat untuk mengatasi serangan asma',
                'stok' => 30,
                'harga' => 65000.00,
                'tanggal_kadaluarsa' => Carbon::now()->addYears(2),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_obat' => 'OBT007',
                'nama_obat' => 'Omeprazole',
                'jenis_obat' => 'Kapsul',
                'satuan' => 'Strip',
                'deskripsi' => 'Obat untuk menekan produksi asam lambung',
                'stok' => 85,
                'harga' => 18000.00,
                'tanggal_kadaluarsa' => Carbon::now()->addYears(1)->addMonths(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_obat' => 'OBT008',
                'nama_obat' => 'Metformin',
                'jenis_obat' => 'Tablet',
                'satuan' => 'Strip',
                'deskripsi' => 'Obat untuk mengendalikan kadar gula darah pada penderita diabetes',
                'stok' => 70,
                'harga' => 22000.00,
                'tanggal_kadaluarsa' => Carbon::now()->addYears(2)->addMonths(6),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_obat' => 'OBT009',
                'nama_obat' => 'Povidone Iodine',
                'jenis_obat' => 'Cairan',
                'satuan' => 'Botol',
                'deskripsi' => 'Antiseptik untuk membersihkan luka',
                'stok' => 40,
                'harga' => 15000.00,
                'tanggal_kadaluarsa' => Carbon::now()->addYears(3),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_obat' => 'OBT010',
                'nama_obat' => 'Cetirizine',
                'jenis_obat' => 'Tablet',
                'satuan' => 'Strip',
                'deskripsi' => 'Antihistamin untuk mengatasi gejala alergi',
                'stok' => 55,
                'harga' => 8000.00,
                'tanggal_kadaluarsa' => Carbon::now()->addYears(2),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_obat' => 'OBT011',
                'nama_obat' => 'Parasetamol Sirup',
                'jenis_obat' => 'Sirup',
                'satuan' => 'Botol',
                'deskripsi' => 'Obat penurun demam dan pereda nyeri untuk anak-anak',
                'stok' => 5,
                'harga' => 12000.00,
                'tanggal_kadaluarsa' => Carbon::now()->addMonths(2),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_obat' => 'OBT012',
                'nama_obat' => 'Ibuprofen',
                'jenis_obat' => 'Tablet',
                'satuan' => 'Strip',
                'deskripsi' => 'Obat anti-inflamasi non-steroid untuk meredakan nyeri',
                'stok' => 8,
                'harga' => 10000.00,
                'tanggal_kadaluarsa' => Carbon::now()->addMonths(2)->addDays(15),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($obatData as $data) {
            Obat::create($data);
        }
    }
}
