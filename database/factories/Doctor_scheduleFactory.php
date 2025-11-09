<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Doctor;
use App\Models\Doctor_schedule;

class Doctor_scheduleFactory extends Factory
{
    protected $model = Doctor_schedule::class;

    public function definition(): array
    {
        return [
            'doctor_id' => Doctor::factory(),
            'hari' => $this->faker->numberBetween(0, 6), // Senin–Minggu
            'jam_mulai' => $this->faker->time('H:i'),
            'jam_selesai' => $this->faker->time('H:i'),
        ];
    }
}
