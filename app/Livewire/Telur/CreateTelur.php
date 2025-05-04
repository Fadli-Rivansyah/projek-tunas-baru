<?php

namespace App\Livewire\Telur;

use Livewire\Component;
use App\Models\Telur;
use App\Models\Kandang;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Cache;
use App\Helpers\ForgetCache;

class CreateTelur extends Component
{
    public  $jumlahTelur_bagus, $jumlahTelur_retak, $tanggal, $kandang;
    public $bulan, $tahun;

    public function mount()
    {
        // user relation
        $user = auth()->user();
        $this->kandang = $user->kandang;

        $this->bulan = now()->format('m');
        $this->tahun = now()->format('Y');
    }

    public function save()
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

        // forget to cache
        ForgetCache::getForgetCacheEggs($this->kandang?->id, $this->bulan, $this->tahun);

        $kandang = Kandang::findOrFail(auth()->user()->kandang?->id);
        // create
        Telur::create([
            'user_id' => auth()->user()->id,
            'kandang_id' => $kandang->id,
            'jumlah_telur_bagus' => $this->jumlahTelur_bagus,
            'jumlah_telur_retak' => $this->jumlahTelur_retak,
            'tanggal' => $this->tanggal,
        ]);

        $this->reset();
        return redirect()->route('telur')->with('success', 'Data telur berhasil dibuat.');
    }
    
    #[Title('Buat Telur')] 
    public function render()
    {
        return view('livewire.telur.create-telur')->layout('layouts.app');
    }
}
