<?php

namespace App\Livewire\Ayam;

use Livewire\Component;
use App\Models\Ayam;
use App\Models\Kandang;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Cache;
use App\Helpers\ForgetCache;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class EditAyam extends Component
{
    public $kandang, $jumlahAyam_mati, $pakan, $tanggal, $total_ayam, $previousTotalChickens;
    public $bulan, $tahun;
    public $ayam;

    use AuthorizesRequests;

    public function mount($id)
    {
        // user relation
        $user = auth()->user();
        $this->kandang = $user->kandang;

        $ayam = Ayam::findOrFail($id);

        $this->authorize('update', $ayam);
        $this->ayam = $ayam;
        // tampilkan ke form input
        $this->previousTotalChickens = $this->ayam->jumlah_ayam_mati;
        $this->jumlahAyam_mati = $this->ayam->jumlah_ayam_mati;
        $this->pakan = $this->ayam->jumlah_pakan;
        $this->tanggal = $this->ayam->tanggal;
        $this->total_ayam = $this->ayam->total_ayam;

    }

    public function editAyam(){
        //authorization other users
        $this->authorize('update', $this->ayam);
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
        ForgetCache:: getForgetCacheChickens($this->kandang?->id, $this->bulan, $this->tahun);
        $fowardTotalChickens = $this->total_ayam + $this->previousTotalChickens;
        
        $this->ayam->update([
            'user_id' => auth()->user()->id,
            'kandang_id' => $this->kandang->id,
            'total_ayam' =>   $fowardTotalChickens - $this->jumlahAyam_mati,
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
