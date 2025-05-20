<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis';
    protected $fillable = [
        'pasien_id',
        'pendaftaran_id',
        'dokter_id',
        'poli_id',
        'tanggal_periksa',
        'keluhan',
        'diagnosis',
        'tindakan',
        'resep',
        'catatan',
        'created_at',
        'updated_at'
    ];

    /**
     * Relasi ke model Pasien
     */
    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    /**
     * Relasi ke model Dokter
     */
    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    /**
     * Relasi ke model Poli
     */
    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    /**
     * Relasi ke model Pendaftaran
     */
    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    /**
     * Relasi ke model FilePendukung
     */
    public function filePendukung()
    {
        return $this->hasMany(FilePendukung::class);
    }

    /**
     * Relasi ke model Obat (many-to-many)
     */
    public function obat()
    {
        return $this->belongsToMany(Obat::class, 'rekam_medis_obat', 'rekam_medis_id', 'obat_id')
            ->withPivot('jumlah', 'dosis', 'keterangan')
            ->withTimestamps();
    }
}
