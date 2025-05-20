<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    use HasFactory;

    protected $table = 'poli';
    protected $fillable = [
        'nama',
        'deskripsi',
        'kuota_harian',
        'status',
        'created_at',
        'updated_at'
    ];

    /**
     * Relasi ke model Dokter
     */
    public function dokter()
    {
        return $this->hasMany(Dokter::class);
    }

    /**
     * Relasi ke model JadwalPoli
     */
    public function jadwal()
    {
        return $this->hasMany(JadwalPoli::class);
    }

    /**
     * Relasi ke model Pendaftaran
     */
    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}
