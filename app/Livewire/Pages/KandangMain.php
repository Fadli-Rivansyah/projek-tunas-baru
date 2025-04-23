<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Livewire\Pages\KandangMain;
use App\Models\Kandang;

class KandangMain extends Component
{
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

    public function render()
    {
        $kandang = Kandang::where('user_id', auth()->id())->first();

        return view('livewire.pages.kandang-main', [
            'kandang' => $kandang
        ])->layout('layouts.app');
    }
    
}
