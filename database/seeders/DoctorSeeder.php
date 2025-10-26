<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('doctors')->insert([
            [
                'nama' => 'dr. Andi Saputra',
                'spesialisasi' => 'Dokter Umum',
                'foto_url' => 'https://example.com/foto/andi.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'dr. Budi Santoso, Sp.PD',
                'spesialisasi' => 'Penyakit Dalam',
                'foto_url' => 'https://example.com/foto/budi.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'dr. Citra Lestari, Sp.A',
                'spesialisasi' => 'Anak',
                'foto_url' => 'https://example.com/foto/citra.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
