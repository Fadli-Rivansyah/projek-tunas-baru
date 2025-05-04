<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Livewire\Pages\KandangMain;
use App\Models\Kandang;
use App\Models\Telur;
use App\Models\Ayam;
use Livewire\Attributes\Title;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Helpers\EggsCache;
use App\Helpers\ChickensCache;

class KandangMain extends Component
{
    public $kandang, $totalChicken, $chickenAge, $eggs;

    public function mount()
    {
        $this->bulan = now()->format('m');
        $this->tahun = now()->format('Y');
        
        $this->kandang = Cache::remember("kandang_user_karyawan",  300, function() {
            return Kandang::where('user_id', auth()->id())->first();
        });

        if($this->kandang){
            $firstChickens = $this->kandang->jumlah_ayam ?? 0;
            $kandangId = $this->kandang->id;
            $firstChickensAge = $this->kandang->created_at ?? 0;
            $baseAge = $this->kandang->umur_ayam ?? 0;
            // Cache total ayam hidup
            $this->totalChicken = ChickensCache::getTotalLiveChicken($kandangId, $firstChickens);
            $this->eggs = EggsCache::getTotalEggInTheCage($this->kandang->id, $this->tahun, $this->bulan);
            // chicken age
            $this->chickenAge = ChickensCache::getTotalChickensAge($kandangId, $firstChickensAge, $baseAge);
        }
    }

    public function destroy($id)
    {
        $kandang = Kandang::findOrFail($id);
        $ayam = $kandang->ayams;
        $telur = $kandang->telurs;
        $kandang->delete();
        if($telur == null || $ayam == null){
            $telur->delete();
            $ayam->delete();
        }

        return redirect()->route('kandang')->with('success', 'Data kandang berhasil dihapus.');
    }

    #[Title('Buat Data Kandang')] 
    public function render()
    {
        return view('livewire.pages.kandang-main')->layout('layouts.app');
    }
    
}
