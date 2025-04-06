<?php

namespace App\Livewire\Ayam;

use Livewire\Component;
use App\Models\Ayam;
use App\Models\Kandang;

class EditAyam extends Component
{
    public $ayam_id, $jumlahAyam_mati, $pakan, $tanggal;

    public function mount($id)
    {
        $ayam = Ayam::findOrFail($id);
        $this->jumlahAyam_mati = $ayam->jumlah_ayam_mati;
        $this->pakan = $ayam->jumlah_pakan;
        $this->tanggal = $ayam->tanggal;
        $this->ayam_id = $id;
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

        $kandang = Kandang::findOrFail(auth()->user()->kandang?->id);
        // create
        $data = Ayam::findOrFail($this->ayam_id);
        $data->update([
            'kandang_id' =>$kandang->id,
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
