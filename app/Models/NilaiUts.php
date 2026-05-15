<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiUts extends Model
{
    protected $table = 'nilai_uts';

    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'guru_id',
        'nilai'
    ];
}
