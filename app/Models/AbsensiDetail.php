<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiDetail extends Model
{
    use HasFactory;

    protected $table = 'absensi_details';

    protected $fillable = [
        'absensi_id',
        'siswa_id',
        'status',
        'keterangan',
    ];

    // 🔗 Relasi ke Absensi (header)
    public function absensi()
    {
        return $this->belongsTo(Absensi::class);
    }

    // 🔗 Relasi ke Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}