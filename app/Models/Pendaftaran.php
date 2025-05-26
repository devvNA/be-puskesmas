<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';
    protected $fillable = [
        'pasien_id',
        'poli_id',
        'dokter_id',
        'tanggal_pendaftaran',
        'no_antrian',
        'status_kehadiran', // sudah hadir/belum hadir
        'waktu_hadir',
        'keterangan',
        'waktu_dipanggil',
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
     * Relasi ke model Poli
     */
    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    /**
     * Relasi ke model Dokter
     */
    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    /**
     * Relasi ke model RekamMedis
     */
    public function rekamMedis()
    {
        return $this->hasOne(RekamMedis::class);
    }
}
