<?php

namespace Database\Factories;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorScheduleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'doctor_id' => Doctor::factory(),
            'hari' => $this->faker->numberBetween(0, 6),
            'jam_mulai' => '08:00',
            'jam_selesai' => '12:00',
        ];
    }
}
