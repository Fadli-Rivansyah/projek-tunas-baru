<?php

namespace App\Livewire\Pakan;

use Livewire\Component;
use App\Models\Pakan;
use App\Models\Kandang;

class CreatePakan extends Component
{
    public $jagung, $multivitamin, $tanggal;

    public function save()
    {
        // cek validasi
        $this->validate([
            'jagung' => 'required|numeric|min:0',
            'multivitamin' => 'required|numeric|min:0',
            'tanggal' => 'required|date'
        ],[
            'jagung.required' => 'Masukan jumlah jagung',
            'jagung.numeric' => 'Data harus berisi angka',
            'multivitamin.required' => 'Masukan jumlah multivitamin',
            'multivitamin.numeric' => 'Jumlah pakan berisi angka',
            'tanggal.required' => 'Tanggal harus diisi',
        ]);

        // create
        Pakan::create([
            'jumlah_jagung' => $this->jagung,
            'jumlah_multivitamin' => $this->multivitamin,
            'tanggal' => $this->tanggal,
        ]);

        $this->reset();
        return redirect()->route('pakan')->with('success', 'Data pakan berhasil dibuat.');
    }

    public function render()
    {
        return view('livewire.pakan.create-pakan')->layout('layouts.app');
    }
}
