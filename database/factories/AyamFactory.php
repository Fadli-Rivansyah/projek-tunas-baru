<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Kandang;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ayam>
 */
class AyamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kandang_id' => fn () => Kandang::inRandomOrder()->first()->id,
            'jumlah_ayam_mati' => fake()->numberBetween(1, 10),
            'jumlah_pakan' => fake()->numberBetween(15, 30),
            'tanggal' => fake()->date()
        ];
    }
}
