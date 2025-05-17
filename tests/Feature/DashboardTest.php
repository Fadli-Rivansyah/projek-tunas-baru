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
    
    protected $employee, $egg;

    protected function setUp(): void
    {
        parent::setUp();

        $this->employee = User::factory()->create([
            'is_admin' => false
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

        $cage = Kandang::create([
            'user_id' => $this->employee->id,
            'nama_kandang' => 'kandang01',
            'nama_karyawan' => $this->employee->name,
            'jumlah_ayam' => 5000,
            'umur_ayam' => 50,
        ]);

        $eggOther = Telur::create([
            'user_id' =>  $secondUser->id,
            'kandang_id' => $cage->id,
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

        $cage = Kandang::create([
            'user_id' => $this->employee->id,
            'nama_kandang' => 'kandang01',
            'nama_karyawan' => $this->employee->name,
            'jumlah_ayam' => 5000,
            'umur_ayam' => 50,
        ]);

        $chickenOther = Ayam::create([
            'user_id' => $secondUser->id,
            'kandang_id' => $cage->id,
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
        $cage = Kandang::create([
            'user_id' => $this->employee->id,
            'nama_kandang' => 'kandang01',
            'nama_karyawan' => $this->employee->name,
            'jumlah_ayam' => 5000,
            'umur_ayam' => 50,
        ]);

         $egg = Telur::create([
            'user_id' =>  $this->employee->id,
            'kandang_id' => $cage->id,
            'jumlah_telur_bagus' => 4000,
            'jumlah_telur_retak' =>100,
            'tanggal' => now(),
        ]);
        
        Livewire::test(Dashboard::class)
            ->assertSee(number_format($egg->jumlah_telur_bagus , 0, ',', '.'))
            ->assertSee(number_format($egg->jumlah_telur_retak , 0, ',', '.'))
            ->assertSee(Carbon::parse($egg->tanggal)->format('d-m-Y'))
             ->set('bulan', '05')
            ->set('tahun', '2025');
    }

    /** test show data chicken */
     public function test_show_data_chicken():void
    {
        $cage = Kandang::create([
            'user_id' => $this->employee->id,
            'nama_kandang' => 'kandang01',
            'nama_karyawan' => $this->employee->name,
            'jumlah_ayam' => 5000,
            'umur_ayam' => 50,
        ]);

         $chicken = Ayam::create([
            'user_id' => $this->employee->id,
            'kandang_id' => $cage->id,
            'total_ayam' =>  3980,
            'jumlah_ayam_mati' => 20,
            'jumlah_pakan' => 10,
            'tanggal' => now(),
        ]);

        $liveChicken = $cage->jumlah_ayam - $chicken->jumlah_ayam_mati;
        $ageChicken = $cage->umur_ayam;

        Livewire::test(dashboard::class)
            ->assertSee(number_format($liveChicken , 0, ',', '.'))
            ->assertSee(number_format($chicken->jumlah_ayam_mati, 0, ',', '.'))
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

    /** test page admin access to dashboard */
    public function test_page_dahsboard_access_admin()
    {
        $admin = User::factory()->create([
            'is_admin' => true
        ]);
        
        $this->get('/dashboard')
            ->assertSee('table')
            ->assertSee('button')
            ->assertSee('h3')
            ->assertSee('form');
    }

    /** total chicken overall */
    public function test_show_data_summary_employee(): void
    {
        
        $users = User::factory()->count(3)->create([
            'is_admin' => false
        ]);
        
        $admin = User::factory()->create([
            'is_admin' => true
        ]);

        $this->actingAs($admin);


        foreach ($users as $index => $user) {
            $kandang = Kandang::create([
                'user_id' => $user->id,
                'nama_kandang' => 'Kandang' . ($index + 1),
                'nama_karyawan' => $user->name,
                'jumlah_ayam' => 5000,
                'umur_ayam' => 50,
            ]);

            Ayam::create([
                'user_id' => $user->id,
                'kandang_id' => $kandang->id,
                'total_ayam' => 3000,
                'jumlah_ayam_mati' => 50,
                'jumlah_pakan' => 30,
                'tanggal' => now(),
            ]);

            Telur::create([
                'user_id' => $user->id,
                'kandang_id' => $kandang->id,
                'jumlah_telur_bagus' => 4000,
                'jumlah_telur_retak' => 100,
                'tanggal' => now(),
            ]);
        }

        $component = Livewire::test(Dashboard::class);

        foreach ($users as $user) {
            $kandang = $user->kandang;
            $name = $user->name;
            $chickenCoop = $kandang->nama_kandang;

            $chickenQuery = Ayam::where('kandang_id', $kandang->id);
            $eggQuery = Telur::where('kandang_id', $kandang->id);
            
            $eggs = $eggQuery->sum('jumlah_telur_bagus');
            $deadChicken = $chickenQuery->sum('jumlah_ayam_mati');
            $totalChicken = $kandang->jumlah_ayam - $deadChicken;

            $component
                ->assertSee($kandang->nama_karyawan)
                ->assertSee($chickenCoop)
                ->assertSee(number_format($totalChicken, 0, ',', '.'))
                ->assertSee(number_format($deadChicken, 0, ',', '.'))
                ->assertSee(number_format($eggs, 0, ',', '.'));
        }
    }

    /** test btn create employee */
    public function test_btn_create_employee_page_dashboard()
    {
        $admin = User::factory()->create([
            'is_admin' => true
        ]);

        $this->actingAs($admin);

        $response = $this->get('/admin/karyawan/create');
        $response->assertStatus(200);
    } 

    /** test btn export summry employee */
    public function test_btn_export_summary_employee():void
    {
        $admin = User::factory()->create([
            'is_admin' => true
        ]);

        $this->actingAs($admin);

        Livewire::test(Dashboard::class)
            ->call('exportPdf');

        $this->assertTrue(true); 
    }
}



