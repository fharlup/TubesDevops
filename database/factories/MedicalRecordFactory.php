<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicalRecordFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'doctor_id' => Doctor::factory(),
            'tanggal_kunjungan' => $this->faker->date(),
            'keluhan' => $this->faker->sentence(),
            'diagnosis' => $this->faker->word(),
            'tindakan' => $this->faker->word(),
            'resep_obat' => $this->faker->word(),
        ];
    }
}
