<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table    = 'pasien';
    protected $fillable = [
        'email',
        'user_id',
        'no_rm',
        'nik',
        'no_bpjs',
        'jenis',
        'hubungan_keluarga',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'golongan_darah',
        'alamat',
        'rt',
        'rw',
        'provinsi',
        'no_telepon',
    ];

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Pendaftaran
     */
    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    /**
     * Relasi ke model RekamMedis
     */
    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class);
    }
}
