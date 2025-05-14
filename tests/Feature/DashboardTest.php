<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
Use App\Models\Telur;
Use App\Models\Kandang;
Use App\Models\Ayam;
Use Livewire\Livewire;

class DashboardTest extends TestCase
{
    Use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_dashboard_employee(): void
    {
        $userNotAdmin = User::factory()->create([
            'is_admin' => false
        ]);

        $kandang = Kandang::factory()->create([
            'user_id' =>  $userNotAdmin->id
        ]);

        $telur = Telur::factory()->create([
            'user_id' =>  $userNotAdmin->id,
            'kandang_id' => $kandang->id,
            'jumlah_telur_bagus' => fake()->numberBetween(3000,4000),
            'jumlah_telur_retak' => fake()->numberBetween(100,200),
            'tanggal' => fake()->date(),
        ]);

        $this->actingAs($userNotAdmin)
            ->get('/dashboard')
            ->assertSee('table')
            ->assertSee('button')
            ->assertSee('h3')
            ->assertSee('form');

        $response = $this->post('/login', [
            'email' => $userNotAdmin->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard'); // atau route lainnya
        $this->assertAuthenticatedAs($userNotAdmin);
    }

}
