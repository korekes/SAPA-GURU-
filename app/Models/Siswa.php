<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = ['nama',
        'nis',
        'kelas_id',
        'no_absen',
        'jenis_kelamin',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function absensi()
    {
        return $this->hasManyThrough(
            \App\Models\Absensi::class,
            \App\Models\AbsensiDetail::class,
            'siswa_id',     // FK di absensi_details
            'id',           // PK di absensis
            'id',           // PK di siswa
            'absensi_id'    // FK di absensi_details ke absensis
        );
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    public function absensiDetails()
    {
        return $this->hasMany(\App\Models\AbsensiDetail::class);
    }
}
