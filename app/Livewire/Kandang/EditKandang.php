<?php

namespace App\Livewire\Kandang;

use Livewire\Component;
use App\Models\Kandang;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Title;

class EditKandang extends Component
{
    public $nama_kandang, $nama_karyawan, $jumlah_ayam, $umur_ayam, $kandang_id;
    public $kandang;

    use AuthorizesRequests;

    public function mount($id)
    {
        $kandang = Kandang::findOrFail($id);

        $this->authorize('update', $kandang);
        $this->kandang = $kandang;

        $this->kandang_id = $kandang->id;
        $this->nama_karyawan = auth()->user()->name;
        $this->nama_kandang = $kandang->nama_kandang;
        $this->jumlah_ayam = $kandang->jumlah_ayam;
        $this->umur_ayam = $kandang->umur_ayam;
    }

    public function editKandang(){
        $this->authorize('update', $this->kandang);

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
  
        $kandang = Kandang::findOrFail($this->kandang_id);
        $kandang->update([
            'user_id' => auth()->user()->id,
            'nama_kandang' => $this->nama_kandang,
            'nama_karyawan' => $this->nama_karyawan,
            'jumlah_ayam' => $this->jumlah_ayam,
            'umur_ayam' => $this->umur_ayam,
        ]);

        return redirect()->route('kandang')->with('success', 'Data kandang berhasil dibuat.');
    }

    #[Title('Edit Data Kandang')] 
    public function render()
    {
        return view('livewire.kandang.edit-kandang')->layout('layouts.app');;
    }
}
