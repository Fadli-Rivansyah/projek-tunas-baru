<?php

namespace App\Livewire\Ayam;

use Livewire\Component;
use App\Models\Ayam;
use App\Models\Kandang;

class CreateAyam extends Component
{
    public  $jumlahAyam_mati, $pakan, $tanggal;

    public function save()
    {
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
        Ayam::create([
            'kandang_id' =>$kandang->id,
            'jumlah_ayam_mati' => $this->jumlahAyam_mati,
            'jumlah_pakan' => $this->pakan,
            'tanggal' => $this->tanggal,
        ]);

        $this->reset();
        return redirect()->route('ayam')->with('success', 'Data kandang berhasil dibuat.');
    }

    public function render()
    {
        return view('livewire.ayam.create-ayam')->layout('layouts.app');;
    }
}
