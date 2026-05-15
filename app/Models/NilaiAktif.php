<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiAktif extends Model
{
    protected $table = 'nilai_aktif';

    protected $fillable = [
        'siswa_id',
        'guru_id',
        'kelas_id',
        'diskusi',
        'inisiatif',
        'kerjasama',
        'komunikasi',
        'tugas',
        'nilai'
    ];
}
