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
use App\Helpers\ForgetCache;

class KandangMain extends Component
{
    public $kandang, $totalChicken, $chickenAge, $eggs;
    public $bulan, $tahun;

    public function mount()
    {
        $this->bulan = now()->format('m');
        $this->tahun = now()->format('Y');
        
        $user = auth()->user();
        $this->kandang = $user->kandang;

        // if (auth()->user()->kandang()->exists()) {
        //     return redirect()->route('kandang')->with('success', 'Kamu sudah punya kandang.');
        // }
        
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

    public function getTableCageProperty()
    {
        return Kandang::where('user_id', auth()->id())->first();
    }

    public function destroy($id)
    {
        $kandang = Kandang::where('id', $id)->with(['ayam', 'telur'])->findOrFail($id);
        
        // Hapus semua ayam yang terkait
        $kandang->ayam()->delete();
        ForgetCache::getForgetCacheChickens($id, $this->bulan, $this->tahun);

        // Hapus semua telur yang terkait
        $kandang->telur()->delete();
        ForgetCache::getForgetCacheEggs($id, $this->bulan, $this->tahun);

        ForgetCache::getForgetCacheCage();
        $kandang->delete();

        return redirect()->route('kandang')->with('success', 'Data kandang berhasil dihapus.');
    }

    #[Title('Kandang')] 
    public function render()
    {
        return view('livewire.pages.kandang-main')->layout('layouts.app');
    }   
}
