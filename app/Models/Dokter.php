<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $table = 'dokter';
    protected $fillable = [
        'poli_id',
        'nama',
        'spesialisasi',
        'foto',
        'status', // aktif, cuti, off
        'created_at',
        'updated_at'
    ];

    /**
     * Relasi ke model Poli
     */
    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    /**
     * Relasi ke model JadwalDokter
     */
    public function jadwal()
    {
        return $this->hasMany(JadwalDokter::class);
    }

    /**
     * Relasi ke model RekamMedis
     */
    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class);
    }

    /**
     * Relasi ke model Pendaftaran
     */
    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}
