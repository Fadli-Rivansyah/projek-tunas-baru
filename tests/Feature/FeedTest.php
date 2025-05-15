<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Livewire\Admin\Pakan\CreatePakan;
use App\Livewire\Admin\Pakan\EditPakan;
use App\Livewire\Pages\PakanMain;
use App\Models\User;
use App\Models\Pakan;
use Tests\TestCase;
use Carbon\Carbon;
use Livewire\Livewire;

class FeedTest extends TestCase
{
    protected $admin;
    protected $pakan;

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'is_admin' => true,
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
        ]);

        $this->actingAs($this->admin);

        $jagung = fake()->numberBetween(40,100);
        $multivitamin = fake()->numberBetween(40,100);

        $this->pakan = Pakan::create([
            'total_pakan' => $jagung + $multivitamin,
            'jumlah_jagung' => $jagung,
            'jumlah_multivitamin' => $multivitamin,
            'sisa_pakan' => $jagung + $multivitamin,
            'tanggal' => now()
        ]);
    }
    
    /**
     * test to page Pakan main, is it peroperly when on accses
     */
    public function test_page_feed_main(): void
    {
        // it is route pakan main
        $response = $this->get('/admin/pakan');
        $response->assertStatus(200);
    }

    /** test btn create feed. is it properly when on apply. this goes to the create feed page */
    public function test_page_create_feed(): void
    {
        $response = $this->get('/admin/pakan/create');
        $response->assertStatus(200); 
        $response->assertSee('form');
    }
    /** test for validation data feed and property that used in code CreatePakan.php */
    public function test_validation_for_create_data_feed(): void
    {
        Livewire::test(CreatePakan::class)
            ->set('jagung', 100)
            ->set('multivitamin', 100)
            ->set('tanggal', now())
            ->call('save')
            ->assertRedirect(route('pakan'));

            // Check if the database is correct
        $this->assertDatabaseHas('pakans', [
            'total_pakan' => 200,
            'jumlah_jagung' => 100,
            'jumlah_multivitamin' => 100,
            'sisa_pakan' => 200,
            'tanggal' => now()->toDateString(),
        ]);
    }

    /** test required in form input create Feed*/
    public function test_create_feed_required_fields(): void
    {
        Livewire::test(CreatePakan::class)
            ->call('save')
            ->assertHasErrors(['jagung' => ['required']])
            ->assertHasErrors(['multivitamin' => ['required']])
            ->assertHasErrors(['tanggal' => ['required']]);
    }

    /** test page edit feed. is it can be open peroperly */
    public function test_page_edit_feed(): void
    {
        $response = $this->get(route('pakan.edit', $this->pakan->id));
        
        $response->assertStatus(200); 
        $response->assertSee('form');
    }

    /** test validation in form edit feed. is it properly */
    public function test_validation_form_edit_feed(): void
    {
        Livewire::test(EditPakan::class, ['id' => $this->pakan->id])
        ->set('jagung', 100)
        ->set('multivitamin', 100)
        ->set('tanggal', now())
        ->call('editPakan')
        ->assertRedirect(route('pakan'));

            // Check if the database is correct
        $this->assertDatabaseHas('pakans', [
            'total_pakan' => 200,
            'jumlah_jagung' => 100,
            'jumlah_multivitamin' => 100,
            'sisa_pakan' => 200,
            'tanggal' => now()->toDateString(),
        ]);
    }

    /** test open page pakan main. is it can be open properly. this determine can success or fail*/
    public function  test_data_feed_list_show(): void
    {
        Livewire::test(PakanMain::class)
            ->assertSee($this->pakan->id)
            ->assertSee($this->pakan->total_pakan)
            ->assertSee($this->pakan->jumlah_jagung)
            ->assertSee($this->pakan->jumlah_multivitamin)
            ->assertSee($this->pakan->sisa_pakan)
            ->assertSee(Carbon::parse($this->pakan->tanggal)->format('d-m-Y'));
    }
    /** test btn export. is it properly  */
    public function test_admin_can_export_feed_pdf(): void
    {
        Livewire::test(PakanMain::class)
            ->call('exportPdf');

        $this->assertTrue(true); 
    }
    /**  test btn delete. is it properly */
    public function test_btn_delete_feed(): void
    {
        Livewire::test(PakanMain::class, ['id' => $this->pakan->id])
            ->call('destroy', $this->pakan->id)
            ->assertDontSee($this->pakan->total_ayam);
        
        $this->assertDatabaseMissing('pakans', [
            'id' => $this->pakan->id,
        ]);
    }
}
