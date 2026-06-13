<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = ['nama_kelas', 'wali_kelas'];

    public function siswa()
    {
        return $this->hasMany(\App\Models\Siswa::class);
    }

    public function wali()
    {
        return $this->belongsTo(User::class, 'wali_kelas');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    public function jurnal()
    {
        return $this->hasMany(Jurnal::class);
    }

    public function mengajar()
    {
        return $this->hasMany(GuruMengajar::class);
    }
}
