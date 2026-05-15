<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiUas extends Model
{
    protected $table = 'nilai_uas';

    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'guru_id',
        'nilai'
    ];
}
