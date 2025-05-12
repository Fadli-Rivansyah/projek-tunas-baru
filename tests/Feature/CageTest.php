<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Livewire\Pages\KandangMain;
use App\Livewire\Kandang\CreateKandang;
use App\Livewire\Kandang\EditKandang;
use Livewire\Livewire;
use App\Models\User;
use App\Models\Kandang;
use App\Models\Ayam;
use Tests\TestCase;

class CageTest extends TestCase
{
    use RefreshDatabase;

    protected $user, $kandang, $chicken;

    protected  function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'is_admin' => false,
        ]);

        $this->kandang = Kandang::factory()->create([
            'user_id' => $this->user->id,
            'nama_kandang' => 'kandang01',
            'nama_karyawan' => $this->user->name,
            'jumlah_ayam' => 5000,
            'umur_ayam' => 50,
        ]);

        $this->chicken = Ayam::factory()->create([
            'user_id' => $this->user->id,
            'kandang_id' => $this->kandang?->id,
            'total_ayam' => 3980,
            'jumlah_ayam_mati' => 20,
            'jumlah_pakan' => 10,
            'tanggal' => now(),
        ]);

        $this->actingAs($this->user);
    }

    /** test page kandang. is it properly*/
    public function test_page_cage_main(): void
    {
        $response = $this->get('/kandang');
        $response->assertStatus(200);
    }

    /** test btn create cage. is it properly when on apply. this goes to the create cage page */
    public function test_page_create_cage(): void
    {
        $response = $this->get('/kandang/create');
        $response->assertStatus(200); 
        $response->assertSee('form');
    }

     /** test for validation data cage and property that used in code CreateKandang.php */
    public function test_validation_for_create_data_cage(): void
    {
        Livewire::test(CreateKandang::class)
            ->set('nama_kandang', $this->kandang?->kandang)
            ->set('nama_karyawan', $this->kandang?->nama_karyawan)
            ->set('jumlah_ayam', $this->kandang?->jumlah_ayam)
            ->set('umur_ayam', $this->kandang?->umur_ayam)
            ->call('save')
            ->assertRedirect('/kandang');

            // Check if the database is correct
        $this->assertDatabaseHas('kandangs', [
            'user_id' => $this->user?->id,
            'nama_kandang' => $this->kandang?->nama_kandang,
            'nama_karyawan' => $this->kandang?->nama_karyawan,
            'jumlah_ayam' => $this->kandang?->jumlah_ayam,
            'umur_ayam' => $this->kandang?->umur_ayam,
        ]);
    }

     /** test required in form input create cage*/
    public function test_create_cage_required_fields(): void
    {
        Livewire::test(CreateKandang::class)
            ->call('save')
            ->assertHasErrors(['nama_kandang' => ['required']])
            ->assertHasErrors(['jumlah_ayam' => ['required']])
            ->assertHasErrors(['umur_ayam' => ['required']]);
    }

      /** test page edit cage. is it can be open peroperly */
    public function test_page_edit_cage(): void
    {
        $response = $this->get(route('kandang.edit', $this->kandang?->id));
        
        $response->assertStatus(200); 
        $response->assertSee('form');
    }

    /** test validation in form edit cage. is it properly */
    public function test_validation_form_edit_cage(): void
    {
        Livewire::test(EditKandang::class, ['id' => $this->kandang?->id])
            ->set('kandang_id', $this->kandang?->id)
            ->set('nama_karyawan', $this->kandang?->nama_karyawan)
            ->set('nama_kandang', $this->kandang?->nama_kandang)
            ->set('jumlah_ayam', $this->kandang?->jumlah_ayam)
            ->set('umur_ayam', $this->kandang?->umur_ayam)
            ->call('editKandang')
            ->assertRedirect('/kandang');

            // Check if the database is correct
        $this->assertDatabaseHas('kandangs', [
            'user_id' => $this->user?->id,
            'nama_kandang' => $this->kandang?->nama_kandang,
            'nama_karyawan' => $this->kandang?->nama_karyawan,
            'jumlah_ayam' => $this->kandang?->jumlah_ayam,
            'umur_ayam' => $this->kandang?->umur_ayam,
        ]);
    }
     /** test open page kandang main. is it can be open properly. this determine can success or fail*/
    public function  test_data_cage_list_show(): void
    {
        Livewire::test(KandangMain::class)
            ->assertSee($this->kandang?->nama_kandang)
            ->assertSee($this->kandang?->nama_karyawan)
            ->assertSee(number_format($this->kandang?->jumlah_ayam, 0, ',', '.'))
            ->assertSee($this->kandang?->usia_ayam);
    }
    /**  test btn delete. is it properly */
    public function test_btn_delete_cage(): void
    {
        Livewire::test(KandangMain::class, ['id' => $this->kandang->id])
            ->call('destroy', $this->kandang?->id);
        
        $this->assertDatabaseMissing('kandangs', [
            'id' => $this->kandang?->id,
        ]);
    }




}
