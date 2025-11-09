<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorFactory extends Factory
{
    public function definition(): array
    {
         return [
            'nama' => $this->faker->firstName,
            'gelar' => 'Sp.KK',
            'spesialisasi' => 'Kulit',
            'foto_url' => null,
        ];
    }
}
