<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'rama',
            'nip' => '12345678',
            'password' => '111111',
            'role' => 'admin'
        ]);
        User::factory()->create([
            'name' => 'heka',
            'nip' => '0987654',
            'password' => '222222',
            'role' => 'guru'
        ]);
        

        $this->call(KelasSeeder::class);
    }
    
}
