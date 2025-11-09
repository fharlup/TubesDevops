<?php

namespace Database\Factories;

use App\Models\Tagihan;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagihanFactory extends Factory
{
    protected $model = Tagihan::class;

    public function definition()
{
    return [
        'pasien_id' => null, // nullable, bisa diisi null
        'no_tagihan' => 'INV-' . $this->faker->unique()->numberBetween(1, 999),
        'name' => $this->faker->name(),
        'total_tagihan' => $this->faker->numberBetween(50000, 500000),
        'tanggal_tagihan' => $this->faker->date(),
        'status' => 'belum_bayar',
        'tanggal_bayar' => null, // nullable
    ];
}

}
