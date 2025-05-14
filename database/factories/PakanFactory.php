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
        $jagung = fake()->numberBetween(40,100);
        $multivitamin = fake()->numberBetween(40,100);

        return [
            'total_pakan' => $jagung + $multivitamin,
            'jumlah_jagung' => $jagung,
            'jumlah_multivitamin' => $multivitamin,
            'sisa_pakan' => $jagung + $multivitamin,
            'tanggal' => fake()->date()
        ];
    }
}
