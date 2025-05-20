<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalDokter extends Model
{
    use HasFactory;

    protected $table = 'jadwal_dokter';
    protected $fillable = [
        'dokter_id',
        'hari', // senin, selasa, dll
        'jam_mulai',
        'jam_selesai',
        'status', // aktif/tidak aktif
        'created_at',
        'updated_at'
    ];

    /**
     * Relasi ke model Dokter
     */
    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }
}
