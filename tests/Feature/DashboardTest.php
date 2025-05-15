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
use App\Livewire\Pages\Dashboard;
use Carbon\Carbon;

class DashboardTest extends TestCase
{
    Use RefreshDatabase;
    
    protected $employee, $cage, $egg;

    protected function setUp(): void
    {
        parent::setUp();

        $this->employee = User::factory()->create([
            'is_admin' => false
        ]);

        $this->cage = Kandang::create([
            'user_id' => $this->employee->id,
            'nama_kandang' => 'kandang01',
            'nama_karyawan' => $this->employee->name,
            'jumlah_ayam' => 5000,
            'umur_ayam' => 50,
        ]);

        $this->egg = Telur::create([
            'user_id' =>  $this->employee->id,
            'kandang_id' => $this->cage->id,
            'jumlah_telur_bagus' => 4000,
            'jumlah_telur_retak' =>100,
            'tanggal' => now(),
        ]);
        
        $this->chicken = Ayam::create([
            'user_id' => $this->employee->id,
            'kandang_id' => $this->cage->id,
            'total_ayam' =>  3980,
            'jumlah_ayam_mati' => 20,
            'jumlah_pakan' => 10,
            'tanggal' => now(),
        ]);

        $this->actingAs($this->employee);
    }

    /** test employee is do not accsess system admin*/ 
    public function test_employee_cannot_access_system_admin(): void
    {
        $response = $this->get('/admin/karyawan');
        $response->assertForbidden();
    }

    /** test employee is not view employe other */
    public function test_employee_can_not_see_activities_egg_other_employee()
    {
        $secondUser = User::factory()->create([
            'is_admin' => false
        ]);

        $eggOther = Telur::create([
            'user_id' =>  $secondUser->id,
            'kandang_id' => $this->cage->id,
            'jumlah_telur_bagus' => 5000,
            'jumlah_telur_retak' => 200,
            'tanggal' => now(),
        ]);

        $response = $this->get(route('telur.edit', $eggOther->id));
        $response->assertForbidden();
    }

    public function test_employee_can_not_see_activities_chicken_other_employee()
    {
        $secondUser = User::factory()->create([
            'is_admin' => false
        ]);

        $chickenOther = Ayam::create([
            'user_id' => $secondUser->id,
            'kandang_id' => $this->cage->id,
            'total_ayam' =>  3980,
            'jumlah_ayam_mati' => 20,
            'jumlah_pakan' => 10,
            'tanggal' => now()->toDateString()
        ]);

        $response = $this->get(route('ayam.edit', $chickenOther->id));
        $response->assertForbidden();
    }

    /** test page dashboad generate tag html */
    public function test_page_dashboard_generate_tag()
    {
        $this->get('/dashboard')
            ->assertSee('table')
            ->assertSee('button')
            ->assertSee('h3')
            ->assertSee('form');
    }

    /** test show data egg */
    public function test_show_data_egg():void
    {
        Livewire::test(dashboard::class)
            ->assertSee(number_format($this->egg->jumlah_telur_bagus , 0, ',', '.'))
            ->assertSee(number_format($this->egg->jumlah_telur_retak , 0, ',', '.'))
            ->assertSee(Carbon::parse($this->egg->tanggal)->format('d-m-Y'))
             ->set('bulan', '05')
            ->set('tahun', '2025');
    }

    /** test show data chicken */
     public function test_show_data_chicken():void
    {
        $liveChicken = $this->cage->jumlah_ayam - $this->chicken->jumlah_ayam_mati;
        $ageChicken = $this->cage->umur_ayam;

        Livewire::test(dashboard::class)
            ->assertSee(number_format($liveChicken , 0, ',', '.'))
            ->assertSee(number_format($this->chicken->jumlah_ayam_mati, 0, ',', '.'))
            ->assertSee($ageChicken)
            ->set('bulan', '05')
            ->set('tahun', '2025');
    }

    /** test btn create telur */
    public function test_btn_create_telur(): void
    {
        $response = $this->get('telur/create');
        $response->assertStatus(200);
        $response->assertSee('form');
    }
    




}
