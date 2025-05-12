<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Livewire\Pages\KaryawanMain;
use App\Livewire\Admin\Karyawan\CreateKaryawan;
use App\Livewire\Admin\Karyawan\EditKaryawan;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Livewire;
use Faker\Generator;

class EmployeeTest extends TestCase
{
    protected $admin;
    protected $employee;

    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = app(Generator::class);

        $this->admin = User::factory()->create([
            'is_admin' => true,
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
        ]);

        $this->employee = User::factory()->create([
            'is_admin' => false,
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
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
        $name = $this->faker->name();
        $email = $this->faker->unique()->safeEmail();

        Livewire::test(CreateKaryawan::class)
            ->set('nama', $name)
            ->set('email', $email)
            ->call('store')
            ->assertRedirect('/admin/karyawan');

            // Check if the database is correct
          $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email,
            'is_admin' => 0
          ]);
    }

    /** test required in form input create karyawan*/
    public function test_create_employee_required_fields(): void
    {
        Livewire::test(CreateKaryawan::class)
            ->call('store')
            ->assertHasErrors(['nama' => ['required']])
            ->assertHasErrors(['email' => ['required']]);
    }

    /** test page edit karyawan. is it can be open peroperly */
    public function test_page_edit_employee(): void
    {
        $response = $this->get(route('karyawan.edit', $this->employee->id));
        
        $response->assertStatus(200); 
        $response->assertSee('form');
    }

    /** test validation in form edit karywawn. is it properly */
    public function test_validation_form_edit_employee(): void
    {
        $name = $this->faker->name();
        $email = $this->faker->unique()->safeEmail();

        Livewire::test(EditKaryawan::class, ['id' => $this->employee->id])
            ->set('nama', $name)
            ->set('email', $email)
            ->call('editKaryawan')
            ->assertRedirect('/admin/karyawan');

        // Check if the database is correct
        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email,
            'is_admin' => 0
        ]);
    }

    /** test open page karyawan main. is it can be open properly. this determine can success or fail*/
    public function  test_data_employee_list_show(): void
    {
        Livewire::test(KaryawanMain::class)
            ->assertSee($this->employee->name)
            ->assertSee($this->employee->email);
    }
    /** test btn export. is it properly  */
    public function test_admin_can_export_karyawan_pdf(): void
    {
        Livewire::test(KaryawanMain::class)
            ->call('exportPdf');

        $this->assertTrue(true); 
    }
    /**  test btn delete. is it properly */
    public function test_btn_delete_employee(): void
    {
        Livewire::test(KaryawanMain::class, ['id' => $this->employee->id])
            ->call('destroy', $this->employee->id)
            ->assertDontSee($this->employee->total_ayam);
        
        $this->assertDatabaseMissing('users', [
            'id' => $this->employee->id,
        ]);
    }
}
