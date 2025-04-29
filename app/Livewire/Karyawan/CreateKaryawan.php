<?php

namespace App\Livewire\Karyawan;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Livewire\Attributes\Title;

class CreateKaryawan extends Component
{
    public $nama, $email;

    public function store()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        User::create([
            'name' => $this->nama,
            'email' => $this->email,
            'password' => Hash::make('password'),
            'is_admin' => 0
        ]);

        $this->reset();
        return redirect()->route('karyawan')->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    #[Title('Buat Karyawan')] 
    public function render()
    {
        return view('livewire.karyawan.create-karyawan')->layout('layouts.app');
    }
}
