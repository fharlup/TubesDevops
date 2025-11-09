<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => $this->faker->firstName,
            'spesialisasi' => $this->faker->randomElement(['Kulit', 'Gigi', 'Anak', 'Jantung']),
            'foto_url' => null,
        ];
    }
}
