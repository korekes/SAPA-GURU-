<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiSikap extends Model
{
    protected $table = 'nilai_sikap';

    protected $fillable = [
        'siswa_id',
        'guru_id',
        'kelas_id',
        'disiplin',
        'kejujuran',
        'tanggung_jawab',
        'kemandirian',
        'kepedulian',
        'nilai'
    ];
}