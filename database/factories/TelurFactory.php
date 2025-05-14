<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Kandang;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Telur>
 */
class TelurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' =>  fake()->numberBetween(1, 50),
            'kandang_id' =>  fake()->numberBetween(1, 50),
            'jumlah_telur_bagus' => fake()->numberBetween(3000,4000),
            'jumlah_telur_retak' => fake()->numberBetween(100,200),
            'tanggal' => fake()->date(),
        ];
    }
}
