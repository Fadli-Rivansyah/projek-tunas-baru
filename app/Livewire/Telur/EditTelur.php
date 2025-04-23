<?php

namespace App\Livewire\Telur;

use Livewire\Component;
use App\Models\Telur;
use App\Models\Kandang;

class EditTelur extends Component
{
    public $jumlahTelur_bagus, $jumlahTelur_retak, $tanggal, $kandang_id;

    public function mount($id)
    {
        $telur = Telur::findOrFail($id);
        $this->jumlahTelur_bagus = $telur->jumlah_telur_bagus;
        $this->jumlahTelur_retak = $telur->jumlah_telur_retak;
        $this->tanggal = $telur->tanggal;
        $this->kandang_id = $id;
    }

    public function editTelur()
    {
        // cek validasi
        $this->validate([
            'jumlahTelur_bagus' => 'required|numeric|min:0',
            'jumlahTelur_retak' => 'required|numeric|min:0',
            'tanggal' => 'required|date'
        ],[
            'jumlahTelur_bagus.required' => 'Masukan jumlah ayam mati',
            'jumlahTelur_bagus.numeric' => 'Data harus berisi angka',
            'jumlahTelur_retak.required' => 'Masukan jumlah ayam mati',
            'jumlahTelur_retak.numeric' => 'Data harus berisi angka',
            'tanggal.required' => 'Tanggal harus diisi',
        ]);

        $kandang = Kandang::findOrFail(auth()->user()->kandang?->id);
        // create
        $dataTelur = Telur::findOrFail($this->kandang_id);
        $dataTelur->update([
            'user_id' => auth()->user()->id,
            'kandang_id' => $kandang->id,
            'jumlah_telur_bagus' => $this->jumlahTelur_bagus,
            'jumlah_telur_retak' => $this->jumlahTelur_retak,
            'tanggal' => $this->tanggal,
        ]);

        $this->reset();
        return redirect()->route('telur')->with('success', 'Data telur berhasil diubah.');
    }

    public function render()
    {
        return view('livewire.telur.edit-telur')->layout('layouts.app');
    }
}
