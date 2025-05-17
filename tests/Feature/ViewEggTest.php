<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
Use App\Models\Telur;
Use App\Models\Kandang;
Use App\Models\User;
Use Livewire\Livewire;
use Carbon\Carbon;
use App\Livewire\Admin\Egg\EggPageAdmin;

class ViewEggTest extends TestCase
{
    Use RefreshDatabase;

    /**
     * test page egg on system admin. is it work with properly
     */

    protected function setUp(): void
    {
        parent::setUp();

        $admin = User::factory()->create([
            'is_admin' => true
        ]);

        $this->actingAs($admin);
    }

    /** test page chicken system admin */
    public function test_page_egg_admin(): void
    {
        $response = $this->get('/admin/telur');
        $response->assertStatus(200);
    }

     /** test btn view employee*/
    public function test_btn_view_emloyee_on_page_egg(): void
    {
        $user = User::factory()->create();

        $response = $this->get(route('egg.admin.view', ['name' => $user->name ]));
        $response->assertStatus(200);
    } 

       /** test count egg overall */
     public function test_show_data_egg():void
    {   
        $crackedEggs = Telur::sum('jumlah_telur_retak');
        $goodEggs = Telur::sum('jumlah_telur_bagus');

        $totalEggs = $goodEggs + $crackedEggs;

        Livewire::test(EggPageAdmin::class)
            ->assertSee(number_format($goodEggs , 0, ',', '.'))
            ->assertSee(number_format($crackedEggs, 0, ',', '.'))
            ->assertSee(number_format($totalEggs, 0, ',', '.'));
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

            Telur::create([
                'user_id' => $user->id,
                'kandang_id' => $kandang->id,
                'jumlah_telur_bagus' => 4000,
                'jumlah_telur_retak' => 25,
                'tanggal' => now()->toDateString(),
            ]);
        }

        $component = Livewire::test(EggPageAdmin::class);

        foreach ($users as $user) {
            $kandang = $user->kandang;
            $name = $user->name;

            $eggQuery = Telur::where('kandang_id', $kandang->id);

            $crackedEggs = $eggQuery->sum('jumlah_telur_retak');
            $goodEggs = $eggQuery->sum('jumlah_telur_bagus');
            $totalEggs = $goodEggs + $crackedEggs;

            $date = $eggQuery->latest()->value('tanggal');
            $viewDate = \Carbon\Carbon::parse($date)->format('d-m-Y');

            $component
                ->assertSee($name)
                ->assertSee($kandang->nama_kandang)
                ->assertSee(number_format($goodEggs, 0, ',', '.') . ' Butir')
                ->assertSee(number_format($crackedEggs, 0, ',', '.') . ' Butir')
                ->assertSee(number_format($totalEggs, 0, ',', '.') . ' Butir')
                ->assertSee($viewDate);
        }
    }  



}
