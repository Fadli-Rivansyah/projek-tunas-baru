<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
Use App\Models\Ayam;
Use App\Models\Kandang;
Use App\Models\User;
Use App\Models\Telur;
Use Livewire\Livewire;
use Carbon\Carbon;
use App\Livewire\Admin\Chicken\ChickenPageEmployee;
use App\Livewire\Admin\Egg\EggPageEmployee;


class ActivitiesEmployeeTest extends TestCase
{
    Use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $admin = User::factory()->create([
            'is_admin' => true
        ]);

        $this->actingAs($admin);
    }

      /** test page chicken on system admin */  
    public function test_page_activities_employee(): void
    {
        $user = User::factory()->create();

        $kandang = Kandang::create([
                'user_id' => $user->id,
                'nama_kandang' => 'Kandang-1',
                'nama_karyawan' => $user->name,
                'jumlah_ayam' => 5000,
                'umur_ayam' => 50,
            ]);

        $chicken = Ayam::create([
                'user_id' => $user->id,
                'kandang_id' => $kandang->id,
                'total_ayam' => 3000,
                'jumlah_ayam_mati' => 50,
                'jumlah_pakan' => 30,
                'tanggal' => now(),
            ]);

        //for chicken admin 
        $response = $this->get(route('chicken.admin.view', $user->name));
        // for egg admin
        $response = $this->get(route('egg.admin.view', $user->name));
        $response->assertStatus(200);
    }

    /** test count chicken in view empployee */
    public function test_show_card_chicken(): void
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $kandang = Kandang::create([
            'user_id' => $user->id,
            'nama_kandang' => 'Kandang01',
            'nama_karyawan' => $user->name,
            'jumlah_ayam' => 5000,
            'umur_ayam' => 50,
        ]);

        for ($i=0; $i <= 5 ; $i++) { 
            Ayam::create([
                'user_id' => $user->id,
                'kandang_id' => $kandang->id,
                'total_ayam' => 3000,
                'jumlah_ayam_mati' => 50,
                'jumlah_pakan' => 30,
                'tanggal' => now(),
            ]);
        }

        $start = Carbon::createFromDate(2025, 05, 1)->startOfMonth()->toDateString();
        $end = Carbon::createFromDate(2025, 05, 1)->endOfMonth()->toDateString();
        
        $chickenQuery = Ayam::where('kandang_id', $kandang->id)
                ->whereBetween('tanggal', [$start, $end]);

        $nameChickenCoop = $kandang->nama_kandang;
        $deadChicken = $chickenQuery->sum('jumlah_ayam_mati');
        $totalChicken = number_format($kandang->jumlah_ayam, 0, ',', '.');
        $chickenAge = $kandang->umur_ayam;
        // view card hasil
        Livewire::test(ChickenPageEmployee::class, ['name' => $user->name])
            ->assertSee($nameChickenCoop)
            ->assertSee(number_format($deadChicken, 0, ',', '.'))
            ->assertSee($totalChicken)
            ->assertSee($chickenAge);
    }

    /** test show data table chicken employee */
    public function test_show_data_chicken_table_employee(): void
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $kandang = Kandang::create([
            'user_id' => $user->id,
            'nama_kandang' => 'Kandang01',
            'nama_karyawan' => $user->name,
            'jumlah_ayam' => 5000,
            'umur_ayam' => 50,
        ]);
        
        // selection monthly
        $start = Carbon::createFromDate(2025, 05, 1)->startOfMonth()->toDateString();
        $end = Carbon::createFromDate(2025, 05, 1)->endOfMonth()->toDateString();

        for ($i=0; $i <= 5 ; $i++) { 
            Ayam::create([
                'user_id' => $user->id,
                'kandang_id' => $kandang->id,
                'total_ayam' => 3000,
                'jumlah_ayam_mati' => 50,
                'jumlah_pakan' => 30,
                'tanggal' => now()->toDateString(),
        ]);
        }
        
        $component = Livewire::test(ChickenPageEmployee::class, ['name' => $user->name]);
        $chicken = Ayam::where('kandang_id', $kandang->id)->whereBetween('tanggal', [$start, $end])->get();

        foreach($chicken as $data)
        {
            $nameChickenCoop = $kandang->nama_kandang;
            $date = $data->tanggal;
            $totalChicken = $data->total_ayam;
            $deadChicken = $data->jumlah_ayam_mati;
            $feed = $data->jumlah_pakan;

            $component
                ->assertSee($date)
                ->assertSee(number_format($totalChicken , 0, ',', '.'))
                ->assertSee(number_format($deadChicken , 0, ',', '.'))
                ->assertSee(number_format($feed , 0, ',', '.'));
        }
    }
    
    /** test show count egg employee */
    Public function test_show_card_egg(): void
    {
         $user = User::factory()->create([
            'is_admin' => false
        ]);

        $kandang = Kandang::create([
            'user_id' => $user->id,
            'nama_kandang' => 'Kandang01',
            'nama_karyawan' => $user->name,
            'jumlah_ayam' => 5000,
            'umur_ayam' => 50,
        ]);

        for ($i=0; $i <= 5 ; $i++) { 
            $telur = Telur::create([
                'user_id' => $user->id,
                'kandang_id' => $kandang->id,
                'jumlah_telur_bagus' => 4000,
                'jumlah_telur_retak' => 25,
                'tanggal' => now()->toDateString(),
            ]);
        }

        $start = Carbon::createFromDate(2025, 05, 1)->startOfMonth()->toDateString();
        $end = Carbon::createFromDate(2025, 05, 1)->endOfMonth()->toDateString();
        
        $eggQuery = Telur::where('kandang_id', $kandang->id)
                ->whereBetween('tanggal', [$start, $end]);

        $nameChickenCoop = $kandang->nama_kandang;
        $goodEggs = $eggQuery->sum('jumlah_telur_bagus');
        $crackedEggs = $eggQuery->sum('jumlah_telur_retak');

        $totalEggs = $goodEggs + $crackedEggs;

        // view card hasil
        Livewire::test(EggPageEmployee::class, ['name' => $user->name])
            ->assertSee($nameChickenCoop)
            ->assertSee(number_format($goodEggs, 0, ',', '.'))
            ->assertSee(number_format($crackedEggs, 0, ',', '.'))
            ->assertSee(number_format($totalEggs, 0, ',', '.'));
    }
      /** test show data table egg employee */
    public function test_show_data_egg_table_employee(): void
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $kandang = Kandang::create([
            'user_id' => $user->id,
            'nama_kandang' => 'Kandang01',
            'nama_karyawan' => $user->name,
            'jumlah_ayam' => 5000,
            'umur_ayam' => 50,
        ]);
        
        // selection monthly
        $start = Carbon::createFromDate(2025, 05, 1)->startOfMonth()->toDateString();
        $end = Carbon::createFromDate(2025, 05, 1)->endOfMonth()->toDateString();

        for ($i=0; $i <= 5 ; $i++) { 
            $telur = Telur::create([
                'user_id' => $user->id,
                'kandang_id' => $kandang->id,
                'jumlah_telur_bagus' => 4000,
                'jumlah_telur_retak' => 25,
                'tanggal' => now()->toDateString(),
            ]);
        }
        
        $component = Livewire::test(EggPageEmployee::class, ['name' => $user->name]);
        $eggQuery = Telur::where('kandang_id', $kandang->id)->whereBetween('tanggal', [$start, $end])->get();

        foreach($eggQuery as $data)
        {
            $date = $data->tanggal;
            $goodEggs = $data->sum('jumlah_telur_bagus');
            $crackedEggs = $data->sum('jumlah_telur_retak');

            $component
                ->assertSee($date)
                ->assertSee(number_format($goodEggs , 0, ',', '.'))
                ->assertSee(number_format($crackedEggs , 0, ',', '.'));
        }
    }
}
