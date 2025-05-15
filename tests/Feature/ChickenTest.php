<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Livewire\Ayam\CreateAyam;
use App\Livewire\Ayam\EditAyam;
use App\Livewire\Pages\AyamMain;
use Tests\TestCase;
use App\Models\User;
use App\Models\Kandang;
use App\Models\Ayam;
use App\Models\Pakan;
use Carbon\Carbon;
use Livewire\Livewire;

class ChickenTest extends TestCase
{
    use RefreshDatabase;
   
    protected $user;
    protected $kandang;
    protected $chicken;
    protected $feed;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->actingAs($this->user);

        $this->kandang = Kandang::create([
            'user_id' => $this->user->id,
            'nama_kandang' => 'kandang01',
            'nama_karyawan' => $this->user->name,
            'jumlah_ayam' => 5000,
            'umur_ayam' => 50,
        ]);

        $this->chicken = Ayam::create([
            'user_id' => $this->user->id,
            'kandang_id' => $this->kandang->id,
            'total_ayam' =>  3980,
            'jumlah_ayam_mati' => 20,
            'jumlah_pakan' => 10,
            'tanggal' => now()->toDateString()
        ]);

        $this->feed = Pakan::create([
            'jumlah_jagung' => 100,
            'jumlah_multivitamin' => 100,
            'tanggal' => now()->toDateString()
        ]);
    }

    /** test for check the page ayam main, is it properly */
    public function test_page_chicken_main(): void
    {
        $response = $this->get('/ayam');
        $response->assertStatus(200);
    }

    /**  test for open the page create chicken. is it use html like form  */
    public function test_page_create_data_chicken(): void
    {
        $response = $this->get('/ayam/create');
        $response->assertStatus(200); 
        $response->assertSee('form');
    }

    /** test validation for create data chicken */
    public function test_validation_create_chicken(): void
    {
        Livewire::test(CreateAyam::class)
            ->set('kandang', $this->kandang?->id)
            ->set('bulan', now()->format('m'))
            ->set('tahun', now()->format('Y'))
            ->set('total_ayam', 4000)
            ->set('jumlahAyam_mati', 20)
            ->set('pakan', 10)
            ->set('tanggal', now()->toDateString())
            ->call('save')
            ->assertRedirect('/ayam');
        
            // Check if the database is correct
        $this->assertDatabaseHas('ayams', [
            'user_id' => $this->user?->id,
            'kandang_id' => $this->kandang?->id,
            'total_ayam' =>3980,
            'jumlah_ayam_mati' => 20,
            'jumlah_pakan' => 10,
            'tanggal' => now()->toDateString(),
        ]);
    }

    /** test field on form input. is it required field */
    public function test_create_chicken_required_fields(): void
    {
        Livewire::test(CreateAyam::class)
            ->call('save')
            ->assertHasErrors(['jumlahAyam_mati' => ['required']])
            ->assertHasErrors(['pakan' => ['required']])
            ->assertHasErrors(['tanggal' => ['required']]);
    }

    public function test_page_udpdate_data_chicken(): void
    {
        $response = $this->get(route('ayam.edit', $this->chicken?->id));

        $response->assertStatus(200); 
        $response->assertSee('form');
    }

    public function test_update_data_chicken_validation(): void
    {

        Livewire::test(EditAyam::class, ['id' => $this->chicken?->id])
            ->set('kandang', $this->kandang?->id)
            ->set('total_ayam', 3980)
            ->set('jumlahAyam_mati', 20)
            ->set('pakan', 10)
            ->set('tanggal', now()->toDateString())
            ->set('previousTotalChickens', 3980)
            ->call('editAyam')
            ->assertRedirect('/ayam');
        
            // Check if the database is correct
        $this->assertDatabaseHas('ayams', [
            'id' => $this->chicken->id, 
            'user_id' => $this->user->id,
            'kandang_id' => $this->kandang->id,
            'total_ayam' =>7940,
            'jumlah_ayam_mati' => 20,
            'jumlah_pakan' => 10,
            'tanggal' => now()->toDateString(),
        ]);
    }

    /** test to display the data to the page  */
    public function test_chicken_list_shows_data(): void
    {
        Livewire::test(AyamMain::class)
            ->assertSee(number_format($this->chicken->total_ayam , 0, ',', '.'))
            ->assertSee(number_format($this->chicken->jumlah_ayam_mati , 0, ',', '.'))
            ->assertSee(number_format($this->chicken->jumlah_pakan , 0, ',', '.'))
            ->assertSee(Carbon::parse($this->chicken->tanggal)->format('d-m-Y'))
            ->set('bulan', '05')
            ->set('tahun', '2025');
    }

    /** test to button delete. is is properly */
    public function test_btn_delete_chicken(): void
    {
        Livewire::test(AyamMain::class)
            ->call('destroy', $this->chicken->id)
            ->assertDontSee($this->chicken->total_ayam);
        
        $this->assertDatabaseMissing('ayams', [
            'id' => $this->chicken->id,
        ]);
    }



}
