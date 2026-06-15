<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiFormatif extends Model
{
    protected $table = 'nilai_formatif';

    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'guru_id',
        'bab',
        'nilai'
    ];

    public function siswa()
    {
        return $this->belongsTo(\App\Models\Siswa::class);
    }
}