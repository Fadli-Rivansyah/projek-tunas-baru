<?php

namespace App\Livewire\Ayam;

use Livewire\Component;
use App\Models\Ayam;
use App\Models\Kandang;

class EditAyam extends Component
{
    public $ayam, $kandang;
    public $jumlahAyam_mati, $pakan, $tanggal, $total_ayam;

    public function mount($id)
    {
        // user relation
        $user = auth()->user();
        $kandang = $user->kandang;
        $this->kandang = $kandang;

        $ayam = Ayam::findOrFail($id);
        $this->ayam = $ayam;

        // tampilkan ke form input
        $this->jumlahAyam_mati = $ayam->jumlah_ayam_mati;
        $this->pakan = $ayam->jumlah_pakan;
        $this->tanggal = $ayam->tanggal;

        $ayamMati = Ayam::where('kandang_id', $kandang?->id)->sum('jumlah_ayam_mati');
        $this->total_ayam = $kandang?->jumlah_ayam - $ayamMati;
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

        
        $this->ayam->update([
            'user_id' => auth()->user()->id,
            'kandang_id' => $this->kandang->id,
            'total_ayam' => $this->total_ayam,
            'jumlah_ayam_mati' => $this->jumlahAyam_mati,
            'jumlah_pakan' => $this->pakan,
            'tanggal' => $this->tanggal,
        ]);

        $this->reset();
        return redirect()->route('ayam')->with('success', 'Data kandang berhasil diubah.');
    }

    public function render()
    {
        return view('livewire.ayam.edit-ayam')->layout('layouts.app');;
    }
}
