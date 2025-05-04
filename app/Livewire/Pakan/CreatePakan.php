<?php

namespace App\Livewire\Pakan;

use Livewire\Component;
use App\Models\Pakan;
use App\Models\Kandang;
use App\Helper\ForgetCache;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Title;

class CreatePakan extends Component
{
    public $jagung, $multivitamin, $tanggal;
    public $bulan, $tahun;

    public function mount()
    {
          // view date
          $this->bulan = now()->format('m');
          $this->tahun = now()->format('Y');
    }

    public function save()
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

        ForgetCache::getForgetCacheFeeds($this->bulan, $this->tahun);

        // create
        Pakan::create([
            'total_pakan' => $totalFeed,
            'jumlah_jagung' => $this->jagung,
            'jumlah_multivitamin' => $this->multivitamin,
            'sisa_pakan' => $totalFeed,
            'tanggal' => $this->tanggal,
        ]);

        $this->reset();
        return redirect()->route('pakan')->with('success', 'Data pakan berhasil dibuat.');
    }

    #[Title('Buat Data Pakan')] 
    public function render()
    {
        return view('livewire.pakan.create-pakan')->layout('layouts.app');
    }
}
