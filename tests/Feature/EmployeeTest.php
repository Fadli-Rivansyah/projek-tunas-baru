<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Livewire\Pages\KaryawanMain;
use Tests\TestCase;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Livewire;

class EmployeeTest extends TestCase
{
    protected $admin;
    protected $employee;


    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $this->employee = User::factory()->create([
            'is_admin' => false,
        ]);


        $this->actingAs($this->admin);

    }
    /**
     * test to page employee main, is it peroperly when on accses
     */
    public function test_page_employee_main(): void
    {
        // it is route employee main
        $response = $this->get('/admin/karyawan');
        $response->assertStatus(200);
    }

    /** test btn create employee. is it properly when on apply. this goes to the create employee page */
    public function test_page_create_employee(): void
    {
        $response = $this->get('/admin/karyawan/create');
        $response->assertStatus(200); 
        $response->assertSee('form');
    }
    /** test for validation data employee and property that used in code CreateKaryawan.php */
    public function test_validation_for_create_data_employee(): void
    {
        Livewire::test(CreateKaryawan::class)
            ->set('search', $this->admin->id)
            ->set('user', $this->employee)
            ->set('kandang', $this->kandang?->id)
            ->set('tahun', '05')
            ->set('bulan', '2025');

          $this->assertDatabaseHas('users', [
            'name' => $this->employee->name,
            'email' => $this->employee->email,
            'password' => Hash::make('password'),
            'is_admin' => 0
          ]);
    }
}
