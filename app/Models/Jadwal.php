<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';

    protected $fillable = [
        'guru_mengajar_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    /*
    |--------------------------------------------------------------------------
    | Urutan hari untuk sorting manual
    |--------------------------------------------------------------------------
    */
    const URUTAN_HARI = [
        'Senin'  => 1,
        'Selasa' => 2,
        'Rabu'   => 3,
        'Kamis'  => 4,
        'Jumat'  => 5,
        'Sabtu'  => 6,
    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi ke GuruMengajar (pivot guru–mapel–kelas).
     */
    public function mengajar()
    {
        return $this->belongsTo(GuruMengajar::class, 'guru_mengajar_id');
    }

    /**
     * Shortcut langsung ke Kelas melalui GuruMengajar.
     */
    public function kelas()
    {
        return $this->hasOneThrough(
            Kelas::class,
            GuruMengajar::class,
            'id',           // FK di guru_mengajars
            'id',           // FK di kelas
            'guru_mengajar_id', // FK di jadwal
            'kelas_id'      // FK di guru_mengajars
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Nama mapel via relasi.
     */
    public function getNamaMapelAttribute(): string
    {
        return $this->mengajar?->mapel?->nama_mapel ?? '-';
    }

    /**
     * Nama guru via relasi.
     */
    public function getNamaGuruAttribute(): string
    {
        return $this->mengajar?->guru?->user?->name ?? '-';
    }

    /**
     * Nama kelas via relasi.
     */
    public function getNamaKelasAttribute(): string
    {
        return $this->mengajar?->kelas?->nama_kelas ?? '-';
    }

    /**
     * Jam tampil dalam format HH:MM – HH:MM.
     */
    public function getJamAttribute(): string
    {
        return substr($this->jam_mulai, 0, 5) . ' – ' . substr($this->jam_selesai, 0, 5);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Filter berdasarkan kelas.
     */
    public function scopeKelas($query, string $namaKelas)
    {
        return $query->whereHas(
            'mengajar.kelas',
            fn($q) => $q->where('nama_kelas', $namaKelas)
        );
    }

    /**
     * Filter berdasarkan hari.
     */
    public function scopeHari($query, string $hari)
    {
        return $query->where('hari', $hari);
    }

    /**
     * Urutkan berdasarkan urutan hari dan jam mulai.
     */
    public function scopeTerurut($query)
    {
        return $query
            ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
            ->orderBy('jam_mulai');
    }
}