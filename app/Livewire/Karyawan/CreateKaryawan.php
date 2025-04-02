<?php

namespace App\Livewire\Karyawan;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class CreateKaryawan extends Component
{
    public function store()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|integer',
        ]);

        User::create_functionreate([
            'name' => $this->nama,
            'email' => $this->kapasitas,
            'password' => Hash::make('password')
        ]);

        session()->flash('message', $this->kandang_id ? 'Data diperbarui!' : 'Data ditambahkan!');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.karyawan.create-karyawan')->layout('layouts.app');
    }
}
