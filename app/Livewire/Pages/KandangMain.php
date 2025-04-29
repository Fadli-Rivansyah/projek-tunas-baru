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

class KandangMain extends Component
{
    public $kandang, $totalChicken, $chickenAge, $eggs;

    public function mount()
    {
        $this->kandang = Cache::remember("kandang_user_karyawan",  300, function() {
            return Kandang::where('user_id', auth()->id())->first();
        });

        if($this->kandang){
            // Cache total ayam hidup
            $this->totalChicken = Cache::remember("kandang_{$this->kandang->id}_total_chicken_kandang", 300, function () {
                $deadChicken = Ayam::where('kandang_id', $this->kandang->id)->sum('jumlah_ayam_mati');
                return $this->kandang->jumlah_ayam - $deadChicken;
            }) ?? 0;

            $this->eggs = Cache::remember("kandang_{$this->kandang->id}_total_eggs_kandang", 300, function () {
                $egg = Telur::where('kandang_id', $this->kandang->id);
                return $egg->sum('jumlah_telur_bagus') + $egg->sum('jumlah_telur_retak');
            }) ?? 0;

            // chicken age
            $this->chickenAge = Cache::remember("kandang_{$this->kandang->id}_total_chickenAge_kandang", 300, function() {
                $baseAge = $this->kandang?->umur_ayam ?? 0;
                if(!$this->kandang?->created_at){
                    return $baseAge;
                }
                $weekRange = Carbon::parse($this->kandang?->created_at)->diffInWeeks(now());
                return round($weekRange) + $baseAge ;
            });
        }
    }

    public function destroy($id)
    {
        $kandang = Kandang::findOrFail($id);
        $ayam = $kandang->ayams;
        $telur = $kandang->telurs;
        $kandang->delete();
        if($telur == null || $ayam== null){
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
