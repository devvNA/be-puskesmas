<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilePendukung extends Model
{
    use HasFactory;

    protected $table = 'file_pendukung';
    protected $fillable = [
        'rekam_medis_id',
        'nama_file',
        'jenis_file', // lab, rujukan, resep, dll
        'file_path',
        'keterangan',
        'created_at',
        'updated_at'
    ];

    /**
     * Relasi ke model RekamMedis
     */
    public function rekamMedis()
    {
        return $this->belongsTo(RekamMedis::class);
    }
}
