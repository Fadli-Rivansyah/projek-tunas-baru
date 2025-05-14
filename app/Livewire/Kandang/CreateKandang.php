<?php

namespace App\Livewire\Kandang;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Kandang;
use App\Models\Ayam;
use Livewire\Attributes\Title;

class CreateKandang extends Component
{
    public $nama_kandang, $nama_karyawan, $jumlah_ayam, $umur_ayam; 

    public function mount()
    {
        $this->nama_karyawan = auth()->user()->name;
    }

    public function save(){

        $this->validate([
            'nama_kandang' => 'required|string|max:50|min:2|unique:kandangs,nama_kandang',
            'nama_karyawan' => 'required|string|max:50|min:2',
            'jumlah_ayam' => 'required|numeric',
            'umur_ayam' => 'required|numeric',
        ],[
            'nama_kandang.unique' => 'Nama kandang tidak boleh sama dengan nama kandang yang lain',
            'nama_kandang.min' => 'Nama kandang minimal 2 karakter',
            'nama_kandang.max' => 'Nama kandang maksimal 50 karakter',
            'jumlah_ayam.numeric' => 'Jumlah ayam harus berisi angka',
            'umur_ayam.numeric' => 'Umur ayam harus berisi angka'
        ]);

        $kandang = Kandang::create([
            'user_id' => auth()->user()->id,
            'nama_kandang' => $this->nama_kandang,
            'nama_karyawan' => $this->nama_karyawan,
            'jumlah_ayam' => $this->jumlah_ayam,
            'umur_ayam' => $this->umur_ayam,
        ]);

        Ayam::create([
            'user_id' => auth()->user()->id,
            'kandang_id' => $kandang->id,
            'total_ayam' => $this->jumlah_ayam,
            'jumlah_ayam_mati' => 0,
            'jumlah_pakan' => 0,
            'tanggal' => now(),
        ]);
        
        return redirect()->route('kandang')->with('success', 'Data kandang telah dibuat.');
    }

    #[Title('Buat Kandang')] 
    public function render()
    {
        return view('livewire.kandang.create-kandang')->layout('layouts.app');
    }
}
