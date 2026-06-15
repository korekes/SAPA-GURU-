<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    protected $fillable = [
        'kelas_id',
        'guru_id',
        'mapel', 
        'tanggal',
        'materi',
        'kegiatan',
        'tujuan_pembelajaran',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function guru()
    {
        return $this->belongsTo(\App\Models\Guru::class);
    }
    public function kelas()
    {
        return $this->belongsTo(\App\Models\Kelas::class);
    }
}
