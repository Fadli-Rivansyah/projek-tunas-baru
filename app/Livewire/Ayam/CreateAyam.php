<?php

namespace App\Livewire\Ayam;

use Livewire\Component;
use App\Models\Ayam;
use App\Models\Kandang;
use App\Models\Pakan;
use Carbon\Carbon;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Cache;
use App\Helpers\ForgetCache;


class CreateAyam extends Component
{
    public  $jumlahAyam_mati, $pakan, $tanggal, $total_ayam;
    public $kandang;
    public $bulan, $tahun;

    public function mount()
    {
        // user relation
        $user = auth()->user();
        $this->kandang = $user->kandang;

        $this->bulan = now()->format('m');
        $this->tahun = now()->format('Y');

        $ayam = Ayam::where('kandang_id', $this->kandang->id)->sum('jumlah_ayam_mati') - $this->kandang->jumlah_ayam ?? $this->kandang->jumlah_ayam;
        $this->total_ayam =abs($ayam);
    }

    public function save()
    {
        // cek validasi
        $this->validate([
            'jumlahAyam_mati' => 'required|numeric|min:0',
            'pakan' => 'required|numeric|min:0',
            'tanggal' => 'required|date'
        ],[
            'jumlahAyam_mati.required' => 'Masukan jumlah ayam mati',
            'jumlahAyam_mati.numeric' => 'Data harus berisi angka',
            'pakan.required' => 'Masukan jumlah pakan',
            'tanggal.required' => 'Tanggal harus diisi',
        ]);

        // create
        $pakan = Pakan::latest()->first();

        $pakan->decrement('jumlah_jagung', $this->pakan/2);
        $pakan->decrement('jumlah_multivitamin', $this->pakan/2);
        $pakan->decrement('sisa_pakan', $this->pakan);

        if ($pakan->jumlah_jagung < $this->pakan || $pakan->jumlah_multivitamin < $this->pakan) 
        {
            session()->flash('error', 'Stok jagung atau multivitamin tidak cukup.');
            return;
        }

        // forget to cache
        ForgetCache::getForgetCacheChikens($this->kandang?->id, $this->bulan, $this->tahun);

        Ayam::create([
            'user_id' => auth()->user()->id,
            'kandang_id' =>$this->kandang?->id,
            'total_ayam' => $this->total_ayam,
            'jumlah_ayam_mati' => $this->jumlahAyam_mati,
            'jumlah_pakan' => $this->pakan,
            'tanggal' => $this->tanggal,
        ]);

        return redirect()->route('ayam')->with('success', 'Data ayam berhasil dibuat.');
    }

    #[Title('Buat Data Ayam')] 
    public function render()
    {
        return view('livewire.ayam.create-ayam')->layout('layouts.app');
    }
}
 