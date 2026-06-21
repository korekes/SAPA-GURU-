<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Guru;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class GuruImport implements ToModel, WithHeadingRow, WithChunkReading
{
    public function model(array $row): Model|array|null
    {
        if (
            empty($row['name']) ||
            empty($row['email']) ||
            empty($row['password']) ||
            empty($row['nip'])
        ) {
            return null;
        }

        $email = trim($row['email']);

        // Cegah email duplikat
        if (User::where('email', $email)->exists()) {
            return null;
        }

        $user = User::create([
            'name'     => trim($row['name']),
            'email'    => $email,
            'password' => Hash::make(trim($row['password'])),
            'nip'      => trim($row['nip']),
            'role'     => 'guru',
        ]);

        return new Guru([
            'user_id'        => $user->id,
            'jenis_kelamin'  => strtoupper(trim($row['jenis_kelamin'] ?? 'L')),
            'mapel'          => trim($row['mapel'] ?? ''),
        ]);
    }

    public function chunkSize(): int
    {
        return 100;
    }
}