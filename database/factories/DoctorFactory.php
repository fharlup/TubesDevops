<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'spesialisasi' => fake()->randomElement(['Umum', 'Gigi', 'Anak', 'Saraf', 'THT']),
            'foto_url' => fake()->imageUrl(200, 200, 'people'),
        ];
    }
}
