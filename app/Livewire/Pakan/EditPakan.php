<?php

namespace App\Livewire\Pakan;

use Livewire\Component;
use App\Models\Pakan;
use Livewire\Attributes\Title;

class EditPakan extends Component
{
    public $jagung, $multivitamin, $tanggal, $pakan_id;

    public function mount($id)
    {
        $pakan = Pakan::findOrFail($id);

        $this->jagung = $pakan->jumlah_jagung;
        $this->multivitamin = $pakan->jumlah_multivitamin;
        $this->tanggal = $pakan->tanggal;
        $this->pakan_id = $id;
    }

    public function editPakan()
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

        $totalFeed = $this->jagung + $this->multivitamin;
        // update
        $pakan = Pakan::findOrFail($this->pakan_id);
        $pakan->update([
            'total_pakan' => $totalFeed,
            'jumlah_jagung' => $this->jagung,
            'jumlah_multivitamin' => $this->multivitamin,
            'sisa_pakan' => $totalFeed,
            'tanggal' => $this->tanggal,
        ]);

        $this->reset();
        return redirect()->route('pakan')->with('success', 'Data pakan berhasil diubah.');
    }

    #[Title('Edit Karyawan')] 
    public function render()
    {
        return view('livewire.pakan.edit-pakan')->layout('layouts.app');
    }
}
