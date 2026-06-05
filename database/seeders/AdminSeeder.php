<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@simukmin.test',
            ],
            [
                'name' => 'Admin SiMukmin',
                'password' => 'admin123',
                'role' => 'admin',
                'must_change_password' => false,
                'siswa_id' => null,
            ]
        );
    }
}
