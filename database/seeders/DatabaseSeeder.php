<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kandang;
use App\Models\Pakan;
use App\Models\Telur;
use App\Models\Ayam;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // Kandang::factory(10)->create();
        // Pakan::factory(30)->create();
        // Ayam::factory(30)->create();
        // Telur::factory(30)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'password',
            'is_admin' => true
        ]);
    }
}
