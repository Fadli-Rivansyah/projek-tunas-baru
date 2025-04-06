<?php

namespace App\Livewire\Karyawan;

use Livewire\Component;
use App\Models\User;

class EditKaryawan extends Component
{
    public $email, $nama, $id_user;

    public function mount($id){
        $karyawan = User::findOrFail($id);
        $this->nama = $karyawan->name;
        $this->email = $karyawan->email;
        $this->id_user = $id;
    }
    
    public function editKaryawan(){
        $this->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        $updateKaryawan = User::findOrFail($this->id_user);
        $updateKaryawan->update([
            'name' => $this->nama,
            'email' => $this->email,
        ]);

        $this->reset();
        return redirect()->route('karyawan')->with('success', 'Data karyawan berhasil diubah.');
    }

    public function render()
    {
        return view('livewire.karyawan.edit-karyawan')->layout('layouts.app');
    }
}
