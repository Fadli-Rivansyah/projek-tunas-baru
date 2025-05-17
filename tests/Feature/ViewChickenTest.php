<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
Use App\Models\Ayam;
Use App\Models\Kandang;
Use App\Models\User;
Use Livewire\Livewire;
use Carbon\Carbon;
use App\Livewire\Admin\Chicken\ChickenPageAdmin;

class ViewChickenTest extends TestCase
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

    /**
     * testing page chicken on interface admin. 
     */

    /** test page chicken on system admin */  
    public function test_page_chicken_on_admin(): void
    {
        $response = $this->get(route('chicken.admin.index'));
        $response->assertStatus(200);
    }
    
    /** test btn view employee*/
    public function test_btn_view_emloyee_on_page_chicken(): void
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

        $response = $this->get(route('chicken.admin.view', $user->name));
        $response->assertStatus(200);
    } 

    /** test authorization admin with user. is it can have forbiden */
    public function test_authorization_admin_and_employee(): void
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user);

        $response = $this->get(route('chicken.admin.index'));
        $response->assertStatus(403);
    }
    
    /** test count chicken overall */
     public function test_show_data_chicken():void
    {   
        $deadChicken = Ayam::sum('jumlah_ayam_mati');
        $countChicken = Kandang::sum('jumlah_ayam');

        $totalChicken = $countChicken - $deadChicken;

        Livewire::test(ChickenPageAdmin::class)
            ->assertSee(number_format($totalChicken , 0, ',', '.'))
            ->assertSee(number_format($deadChicken, 0, ',', '.'));
    }

    /** test show data employee  */
    public function test_show_data_table(): void
    {
        $users = User::factory()->count(3)->create();

        foreach ($users as $index => $user) {
            $kandang = Kandang::create([
                'user_id' => $user->id,
                'nama_kandang' => 'Kandang-' . ($index + 1),
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
        }

        $component = Livewire::test(ChickenPageAdmin::class);

        foreach ($users as $user) {
            $kandang = $user->kandang;
            $name = $user->name;

            $chickenQuery = Ayam::where('kandang_id', $kandang->id);
            $deadChicken = $chickenQuery->sum('jumlah_ayam_mati');
            $countChicken = $kandang->jumlah_ayam - $deadChicken;
            $countFeed = $chickenQuery->sum('jumlah_pakan');
            $ageChicken = $kandang->umur_ayam + 2;

            $date = $chickenQuery->latest()->value('tanggal');
            $viewDate = \Carbon\Carbon::parse($date)->format('d-m-Y');

            $component
                ->assertSee($name)
                ->assertSee($kandang->nama_kandang)
                ->assertSee(number_format($countChicken, 0, ',', '.') . ' Ekor')
                ->assertSee(number_format($deadChicken, 0, ',', '.') . ' Ekor')
                ->assertSee(number_format($countFeed, 0, ',', '.') . ' Kg')
                ->assertSee($viewDate);
        }
    }  
}
