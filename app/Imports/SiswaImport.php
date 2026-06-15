<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row): Model|Siswa|null
    {
        $kelas = Kelas::where(
            'nama_kelas',
            trim($row['kelas'])
        )->first();

        return new Siswa([
            'nama'           => $row['nama'],
            'nis'            => $row['nis'],
            'no_absen'       => $row['no_absen'] ?? null,
            'jenis_kelamin'  => $row['jenis_kelamin'] ?? null,
            'kelas_id'       => $kelas?->id,
        ]);
    }
}