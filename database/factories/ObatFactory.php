<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Obat;

class ObatFactory extends Factory
{
    protected $model = Obat::class;  

    public function definition()
    {
        return [
            'nama_obat' => $this->faker->word(),
            'kategori' => 'Umum',
            'stok' => $this->faker->numberBetween(1, 100),
            'satuan' => 'Tablet',
            'harga' => $this->faker->numberBetween(1000, 100000),
            'deskripsi' => $this->faker->sentence(),
        ];
    }
}
