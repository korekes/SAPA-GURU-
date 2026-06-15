<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class GuruImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        unset($rows[0]);

        foreach ($rows as $row) {

            $user = User::create([
                'name' => $row[0],
                'email' => $row[1],
                'nip' => $row[2],
                'password' => Hash::make($row[3]),
                'role' => 'guru',
            ]);

            Guru::create([
                'user_id' => $user->id,
                'jenis_kelamin' => $row[4],
                'mapel' => $row[5],
            ]);
        }
    }
}