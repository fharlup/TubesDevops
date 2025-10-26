<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicalRecordSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('medical_records')->insert([
            [
                'user_id' => 1,
                'doctor_id' => 1,
                'tanggal_kunjungan' => '2025-10-20',
                'keluhan' => 'Demam dan sakit kepala',
                'diagnosis' => 'Infeksi virus ringan',
                'tindakan' => 'Istirahat dan minum air cukup',
                'resep_obat' => 'Paracetamol 500mg, 3x sehari',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'doctor_id' => 2,
                'tanggal_kunjungan' => '2025-10-22',
                'keluhan' => 'Batuk dan pilek',
                'diagnosis' => 'Flu biasa',
                'tindakan' => 'Konsumsi vitamin C dan istirahat',
                'resep_obat' => 'OBH Combi, 3x sehari',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
