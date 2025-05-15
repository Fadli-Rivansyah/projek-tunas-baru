<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Telur;
use App\Models\Kandang;
use App\Livewire\Pages\TelurMain;
use App\Livewire\Telur\CreateTelur;
use Carbon\Carbon;
use App\Livewire\Telur\EditTelur;
use Livewire\Livewire;

class EggTest extends TestCase
{
    protected $user, $kandang, $telur;

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($this->user);

        $this->kandang = Kandang::create([
            'user_id' => $this->user->id,
            'nama_kandang' => 'kandang01',
            'nama_karyawan' => $this->user->name,
            'jumlah_ayam' => 5000,
            'umur_ayam' => 50,
        ]);

        $this->telur= Telur::create([
            'user_id' => $this->user->id,
            'kandang_id' => $this->kandang->id,
            'jumlah_telur_bagus' => 4000,
            'jumlah_telur_retak' => 25,
            'tanggal' => now()->toDateString(),
        ]);
    }
    /**
     * test to page telur main, is it peroperly when on accses
     */
    public function test_page_egg_main(): void
    {
        // it is route pakan main
        $response = $this->get('/telur');
        $response->assertStatus(200);
    }

    /** test btn create egg. is it properly when on apply. this goes to the create egg page */
    public function test_page_create_egg(): void
    {
        $response = $this->get('/telur/create');
        $response->assertStatus(200); 
        $response->assertSee('form');
    }
    /** test for validation data egg and property that used in code CreateTelur.php */
    public function test_validation_for_create_data_egg(): void
    {
        Livewire::test(CreateTelur::class)
            ->set('kandang', $this->kandang?->id)
            ->set('jumlahTelur_bagus', 4000)
            ->set('jumlahTelur_retak', 25)
            ->set('tanggal', now())
            ->call('save')
            ->assertRedirect(route('telur'));

            // Check if the database is correct
        $this->assertDatabaseHas('telurs', [
            'user_id' => $this->user->id,
            'kandang_id' => $this->kandang->id,
            'jumlah_telur_bagus' => 4000,
            'jumlah_telur_retak' => 25,
            'tanggal' => now()->toDateString(),
        ]);
    }

    /** test required in form input create egg*/
    public function test_create_egg_required_fields(): void
    {
        Livewire::test(CreateTelur::class)
            ->call('save')
            ->assertHasErrors(['jumlahTelur_bagus' => ['required']])
            ->assertHasErrors(['jumlahTelur_retak' => ['required']])
            ->assertHasErrors(['tanggal' => ['required']]);
    }

    /** test page edit egg. is it can be open peroperly */
    public function test_page_edit_egg(): void
    {
        $response = $this->get(route('telur.edit', $this->telur->id));
        
        $response->assertStatus(200); 
        $response->assertSee('form');
    }

    /** test validation in form edit egg. is it properly */
    public function test_validation_form_edit_egg(): void
    {

        Livewire::test(EditTelur::class, ['id' => $this->telur->id])
            ->set('kandang', $this->kandang->id)
            ->set('telur_id', $this->telur->id)
            ->set('jumlahTelur_bagus', 4000)
            ->set('jumlahTelur_retak', 25)
            ->set('tanggal', $this->telur->tanggal)
            ->call('editTelur')
            ->assertRedirect(route('telur'));

        // Cek database
        $this->assertDatabaseHas('telurs', [
            'user_id' => $this->user->id,
            'kandang_id' => $this->kandang?->id,
            'jumlah_telur_bagus' => 4000,
            'jumlah_telur_retak' => 25,
            'tanggal' => now()->toDateString(),
        ]);
    }

    /** test open page egg main. is it can be open properly. this determine can success or fail*/
    public function  test_data_egg_list_show(): void
    {
        Livewire::test(TelurMain::class)
            ->assertSee(number_format($this->telur->jumlah_telur_bagus , 0, ',', '.'))
            ->assertSee(number_format($this->telur->jumlah_telur_bagus , 0, ',', '.'))
            ->assertSee(Carbon::parse($this->telur->tanggal)->format('d-m-Y'));
    }
    /** test btn export. is it properly  */
    public function test_admin_can_export_egg_pdf(): void
    {
        Livewire::test(TelurMain::class)
            ->call('exportPdf');

        $this->assertTrue(true); 
    }
    /**  test btn delete. is it properly */
    public function test_btn_delete_egg(): void
    {
        Livewire::test(TelurMain::class, ['id' => $this->telur->id])
            ->call('destroy', $this->telur->id);
        
        $this->assertDatabaseMissing('telurs', [
            'id' => $this->telur->id,
        ]);
    }
}

