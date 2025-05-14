<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kandang>
 */
class KandangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1, 50),
            'nama_kandang' => fake()->word(),
            'nama_karyawan' => fake()->name(),
            'umur_ayam' => fake()->numberBetween(50,80),
            'jumlah_ayam' => fake()->numberBetween(4000,5000),
        ];
    }
}