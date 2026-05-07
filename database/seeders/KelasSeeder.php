<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $kelas = [
            ['nama_kelas' => '1A'],
            ['nama_kelas' => '1B'],
            ['nama_kelas' => '2A'],
            ['nama_kelas' => '2B'],
            ['nama_kelas' => '3A'],
            ['nama_kelas' => '3B'],
            ['nama_kelas' => '4A'],
            ['nama_kelas' => '4B'],
            ['nama_kelas' => '5A'],
            ['nama_kelas' => '5B'],
            ['nama_kelas' => '6A'],
            ['nama_kelas' => '6B'],
        ];

        Kelas::insert($kelas);
    }
}
