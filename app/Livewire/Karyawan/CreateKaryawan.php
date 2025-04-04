<?php

namespace App\Livewire\Karyawan;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Session;

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

        session()->flash('success', 'Data ditambahkan! ');
        return redirect()->route('karyawan'); 
    }

    public function render()
    {
        return view('livewire.karyawan.create-karyawan')->layout('layouts.app');
    }
}
