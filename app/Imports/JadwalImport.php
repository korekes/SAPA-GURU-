<?php

namespace App\Imports;

use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Guru;
use App\Models\GuruMengajar;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Validators\Failure;

class JadwalImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    SkipsOnFailure,
    WithBatchInserts,
    WithChunkReading
{
    use SkipsFailures;

    /*
    |--------------------------------------------------------------------------
    | Cache lookup agar tidak query berulang per baris
    |--------------------------------------------------------------------------
    */
    private array $kelasCache       = [];
    private array $guruCache        = [];
    private array $mapelCache       = [];
    private array $mengajarCache    = [];

    public int $rowsImported  = 0;
    public int $rowsSkipped   = 0;

    /*
    |--------------------------------------------------------------------------
    | Validasi kolom header
    |--------------------------------------------------------------------------
    */
    public function rules(): array
    {
        return [
            'hari'        => ['required', 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu'],
            'jam_mulai'   => ['required'],
            'jam_selesai' => ['required'],
            'kelas'       => ['required'],
            'mapel'       => ['required'],
            'guru'        => ['required'],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'hari.in'           => 'Hari harus salah satu dari: Senin, Selasa, Rabu, Kamis, Jumat, Sabtu.',
            'hari.required'     => 'Kolom hari wajib diisi.',
            'jam_mulai.required'=> 'Kolom jam_mulai wajib diisi.',
            'kelas.required'    => 'Kolom kelas wajib diisi.',
            'mapel.required'    => 'Kolom mapel wajib diisi.',
            'guru.required'     => 'Kolom guru wajib diisi.',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Proses tiap baris
    |--------------------------------------------------------------------------
    */
    public function model(array $row): ?Jadwal
    {
        // Ambil entitas dari cache atau DB
        $kelas = $this->getKelas(trim($row['kelas']));
        $guru  = $this->getGuru(trim($row['guru']));
        $mapel = $this->getMapel(trim($row['mapel']));

        if (!$kelas || !$guru || !$mapel) {
            $this->rowsSkipped++;
            return null;
        }

        $guruMengajar = $this->getMengajar($guru->id, $kelas->id, $mapel->id);

        if (!$guruMengajar) {
            $this->rowsSkipped++;
            return null;
        }

        // Normalisasi jam (bisa berupa string "07:00" atau float dari Excel)
        $jamMulai   = $this->normalizeTime($row['jam_mulai']);
        $jamSelesai = $this->normalizeTime($row['jam_selesai']);

        // Cek bentrok di kelas yang sama
        $bentrok = Jadwal::where('hari', trim($row['hari']))
            ->whereHas('mengajar', fn($q) => $q->where('kelas_id', $kelas->id))
            ->where(function ($q) use ($jamMulai, $jamSelesai) {
                $q->whereBetween('jam_mulai', [$jamMulai, $jamSelesai])
                  ->orWhereBetween('jam_selesai', [$jamMulai, $jamSelesai]);
            })
            ->exists();

        if ($bentrok) {
            $this->rowsSkipped++;
            return null;
        }

        $this->rowsImported++;

        return new Jadwal([
            'guru_mengajar_id' => $guruMengajar->id,
            'hari'             => trim($row['hari']),
            'jam_mulai'        => $jamMulai,
            'jam_selesai'      => $jamSelesai,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper cache
    |--------------------------------------------------------------------------
    */

    private function getKelas(string $nama): ?Kelas
    {
        if (!isset($this->kelasCache[$nama])) {
            $this->kelasCache[$nama] = Kelas::where('nama_kelas', $nama)->first();
        }
        return $this->kelasCache[$nama];
    }

    private function getGuru(string $nama): ?Guru
    {
        if (!isset($this->guruCache[$nama])) {
            $this->guruCache[$nama] = Guru::whereHas(
                'user',
                fn($q) => $q->where('name', $nama)
            )->first();
        }
        return $this->guruCache[$nama];
    }

    private function getMapel(string $nama): ?Mapel
    {
        if (!isset($this->mapelCache[$nama])) {
            $this->mapelCache[$nama] = Mapel::where('nama_mapel', $nama)->first();
        }
        return $this->mapelCache[$nama];
    }

    private function getMengajar(int $guruId, int $kelasId, int $mapelId): ?GuruMengajar
    {
        $key = "{$guruId}-{$kelasId}-{$mapelId}";
        if (!isset($this->mengajarCache[$key])) {
            $this->mengajarCache[$key] = GuruMengajar::where('guru_id', $guruId)
                ->where('kelas_id', $kelasId)
                ->where('mapel_id', $mapelId)
                ->first();
        }
        return $this->mengajarCache[$key];
    }

    /**
     * Normalisasi waktu dari Excel.
     * Excel menyimpan waktu sebagai desimal (0.291667 = 07:00).
     */
    private function normalizeTime(mixed $value): string
    {
        if (is_numeric($value)) {
            // Konversi dari desimal Excel ke menit
            $totalMinutes = round($value * 24 * 60);
            $hours        = intdiv($totalMinutes, 60) % 24;
            $minutes      = $totalMinutes % 60;
            return sprintf('%02d:%02d', $hours, $minutes);
        }

        // Sudah berupa string "HH:MM" atau "HH:MM:SS"
        return substr(trim($value), 0, 5);
    }

    /*
    |--------------------------------------------------------------------------
    | Performa
    |--------------------------------------------------------------------------
    */

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 200;
    }
}