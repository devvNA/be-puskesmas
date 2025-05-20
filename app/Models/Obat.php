<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Obat extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nama tabel yang terkait dengan model
     */
    protected $table = 'obat';

    /**
     * Atribut yang dapat diisi
     */
    protected $fillable = [
        'kode_obat',
        'nama_obat',
        'jenis_obat',
        'satuan',
        'deskripsi',
        'stok',
        'harga',
        'tanggal_kadaluarsa',
    ];

    /**
     * Atribut yang harus dikonversi menjadi tipe data tertentu
     */
    protected $casts = [
        'tanggal_kadaluarsa' => 'date',
        'harga' => 'decimal:2',
        'stok' => 'integer',
    ];

    /**
     * Hubungan dengan model RekamMedis
     * Satu obat dapat diresepkan di banyak rekam medis
     */
    public function rekamMedis()
    {
        return $this->belongsToMany(RekamMedis::class, 'rekam_medis_obat', 'obat_id', 'rekam_medis_id')
            ->withPivot('jumlah', 'dosis', 'keterangan')
            ->withTimestamps();
    }
}
