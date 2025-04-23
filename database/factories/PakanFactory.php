<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Kandang;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pakan>
 */
class PakanFactory extends Factory
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
            'jumlah_jagung' => fake()->numberBetween(40,70),
            'jumlah_multivitamin' => fake()->numberBetween(40,70),
            'tanggal' => fake()->date()
        ];
    }
}
