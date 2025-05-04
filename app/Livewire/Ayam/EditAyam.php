<?php

namespace App\Livewire\Ayam;

use Livewire\Component;
use App\Models\Ayam;
use App\Models\Kandang;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Cache;
use App\Helpers\ForgetCache;


class EditAyam extends Component
{
    public $ayam, $kandang;
    public $jumlahAyam_mati, $pakan, $tanggal, $total_ayam;
    public $bulan, $tahun;

    public function mount($id)
    {
        // user relation
        $user = auth()->user();
        $this->kandang = $user->kandang;

        $this->ayam = Ayam::where('kandang_id', $this->kandang->id)
        ->findOrFail($id);

        // tampilkan ke form input
        $this->jumlahAyam_mati = $this->ayam->jumlah_ayam_mati;
        $this->pakan = $this->ayam->jumlah_pakan;
        $this->tanggal = $this->ayam->tanggal;

        $this->hitungTotalAyam();
    }

    private function hitungTotalAyam()
    {
        $ayamMati = Ayam::where('kandang_id', $this->kandang->id)->sum('jumlah_ayam_mati');
        $this->total_ayam = $this->kandang->jumlah_ayam - $ayamMati;
    }

    public function editAyam(){
         // cek validasi
         $this->validate([
            'jumlahAyam_mati' => 'required|numeric|min:0',
            'pakan' => 'required|numeric|min:0',
            'tanggal' => 'required|date'
        ],[
            'jumlahAyam_mati.required' => 'Masukan jumlah ayam mati',
            'jumlahAyam_mati.numeric' => 'Data harus berisi angka',
            'pakan.required' => 'Masukan jumlah pakan',
            'tanggal.required' => 'Tanggal harus diisi',
        ]);

        // forget  to cache
        ForgetCache::getForgetCacheChikens($this->kandang?->id, $this->bulan, $this->tahun);
        
        $this->ayam->update([
            'user_id' => auth()->user()->id,
            'kandang_id' => $this->kandang->id,
            'total_ayam' => $this->total_ayam,
            'jumlah_ayam_mati' => $this->jumlahAyam_mati,
            'jumlah_pakan' => $this->pakan,
            'tanggal' => $this->tanggal,
        ]);

        return redirect()->route('ayam')->with('success', 'Data kandang berhasil diubah.');
    }

    #[Title('Edit Ayam')] 
    public function render()
    {
        return view('livewire.ayam.edit-ayam')->layout('layouts.app');;
    }
}
