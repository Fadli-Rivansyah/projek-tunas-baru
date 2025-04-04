<?php

namespace App\Livewire\Kandang;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Kandang;

class CreateKandang extends Component
{
    public $nama_kandang, $nama_karyawan, $jumlah_ayam, $umur_ayam;

  
    public function mount()
    {
        $this->nama_karyawan = auth()->user()->name;
    }

    public function save(){
        $this->validate([
            'nama_kandang' => 'required|string|max:50|min:2',
            'nama_karyawan' => 'required|max:50|min:5',
            'jumlah_ayam' => 'required|numeric',
            'umur_ayam' => 'required|numeric',
        ],[
            'nama_kandang.unique' => 'Nama kangdang diisi dengan nama kandan yang berbeda',
            'nama_kandang.min' => 'Nama kandang minimal 2 karakter',
            'nama_kandang.max' => 'Nama kandang maksimal 50 karakter',
            'jumlah_ayam.numeric' => 'Jumlah ayam harus berisi angka',
            'umur_ayam.numeric' => 'Umur ayam harus berisi angka'
        ]);
  

        Kandang::create([
            'user_id' => auth()->id(),
            'nama_kandang' => $this->nama_kandang,
            'nama_karyawan' => $this->nama_karyawan,
            'jumlah_ayam' => $this->jumlah_ayam,
            'umur_ayam' => $this->umur_ayam,
        ]);

        session()->flash('success', 'Data ditambahkan! ');
        $this->reset();
        return redirect()->route('kandang'); 
    }

    public function render()
    {
        return view('livewire.kandang.create-kandang')->layout('layouts.app');;
    }
}
