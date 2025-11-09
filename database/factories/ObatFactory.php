<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ObatFactory extends Factory
{
    public function definition()
    {
        return [
            'nama_obat' => $this->faker->word(),
            'kategori' => 'Umum',
            'stok' => rand(1, 100),
            'satuan' => 'Tablet',
            'harga' => rand(1000, 100000),
            'deskripsi' => $this->faker->sentence(),
        ];
    }
}
