<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorScheduleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('doctor_schedules')->insert([
            [
                'doctor_id' => 1,
                'hari' => 1, // Senin
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '12:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'doctor_id' => 1,
                'hari' => 3, // Rabu
                'jam_mulai' => '13:00:00',
                'jam_selesai' => '17:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'doctor_id' => 2,
                'hari' => 2, // Selasa
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '14:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'doctor_id' => 3,
                'hari' => 5, // Jumat
                'jam_mulai' => '10:00:00',
                'jam_selesai' => '15:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
