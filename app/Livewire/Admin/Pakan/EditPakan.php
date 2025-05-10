<?php

namespace App\Livewire\Admin\Pakan;

use Livewire\Component;
use App\Models\Pakan;
use App\Helpers\ForgetCache;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Title;

class EditPakan extends Component
{
    public $jagung, $multivitamin, $tanggal, $pakan_id;
    public $bulan, $tahun;

    public function mount($id)
    {
        $pakan = Pakan::findOrFail($id);

        $this->jagung = $pakan->jumlah_jagung;
        $this->multivitamin = $pakan->jumlah_multivitamin;
        $this->tanggal = $pakan->tanggal;
        $this->pakan_id = $id;

        // view date
        $this->bulan = now()->format('m');
        $this->tahun = now()->format('Y');
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
        // forget cache
        ForgetCache::getForgetCacheFeeds($this->bulan, $this->tahun);
        // update
        $pakan = Pakan::findOrFail($this->pakan_id);
        $pakan->update([
            'total_pakan' => $totalFeed,
            'jumlah_jagung' => $this->jagung,
            'jumlah_multivitamin' => $this->multivitamin,
            'sisa_pakan' => $totalFeed,
            'tanggal' => $this->tanggal,
        ]);

        return redirect()->route('pakan')->with('success', 'Data pakan berhasil diubah.');
    }

    #[Title('Edit Karyawan')] 
    public function render()
    {
        return view('livewire.admin.pakan.edit-pakan')->layout('layouts.app');
    }
}
