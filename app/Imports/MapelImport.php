<?php

namespace App\Imports;

use App\Models\Mapel;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\GuruMengajar;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class MapelImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        unset($rows[0]);

        foreach ($rows as $row)
        {
            $mapel = Mapel::firstOrCreate([
                'nama_mapel' => $row[0]
            ]);

            $guru = Guru::whereHas('user', function($q) use ($row){
                $q->where('name',$row[1]);
            })->first();

            $kelas = Kelas::where(
                'nama_kelas',
                $row[2]
            )->first();

            if($guru && $kelas)
            {
                GuruMengajar::firstOrCreate([
                    'guru_id' => $guru->id,
                    'kelas_id' => $kelas->id,
                    'mapel_id' => $mapel->id,
                ]);
            }
        }
    }
}