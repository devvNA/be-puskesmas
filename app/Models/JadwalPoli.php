<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPoli extends Model
{
    use HasFactory;

    protected $table = 'jadwal_poli';
    protected $fillable = [
        'poli_id',
        'hari', // senin, selasa, dll
        'jam_buka',
        'jam_tutup',
        'status', // aktif/tidak aktif
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
}
