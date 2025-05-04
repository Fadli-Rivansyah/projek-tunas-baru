<?php

namespace App\Livewire\Karyawan;

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\Title;

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
        // forget to cache
        ForgetCache::getForgetCacheEmployees($this->nama);

        $updateKaryawan = User::findOrFail($this->id_user);
        $updateKaryawan->update([
            'name' => $this->nama,
            'email' => $this->email,
        ]);

        return redirect()->route('karyawan')->with('success', 'Data karyawan berhasil diubah.');
    }

    #[Title('Edit Karyawan')] 
    public function render()
    {
        return view('livewire.karyawan.edit-karyawan')->layout('layouts.app');
    }
}
