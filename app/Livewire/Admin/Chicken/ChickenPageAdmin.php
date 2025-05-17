<?php

namespace App\Livewire\Admin\Chicken;

use Livewire\Component;
use Livewire\Attributes\Title;
use Carbon\Carbon;
use App\Models\Kandang;
use App\Models\Ayam;
use App\Helpers\ChickensCache;

class ChickenPageAdmin extends Component
{
    public $tahun, $bulan;

    public function mount()
    {
        $this->bulan = now()->format('m');
        $this->tahun = now()->format('Y');
    }

    public function getCountChickensProperty()
    {
        $start = Carbon::createFromDate($this->tahun, $this->bulan, 1)->startOfMonth()->toDateString();
        $end = Carbon::createFromDate($this->tahun, $this->bulan, 1)->endOfMonth()->toDateString();
        
        return ChickensCache::getChickensInCage($start, $end);
    }

    public function getChickensFarmersProperty()
    {
         $kandangData = Ayam::join('kandangs', 'ayams.kandang_id', '=', 'kandangs.id')
            ->selectRaw('
                kandangs.id as kandang_id, 
                kandangs.nama_kandang,
                kandangs.nama_karyawan,
                kandangs.jumlah_ayam,
                MAX(ayams.tanggal) as tanggal,
                SUM(ayams.jumlah_pakan) as jumlah_pakan, 
                SUM(ayams.jumlah_ayam_mati) as jumlah_ayam_mati
                ')
            ->groupBy('kandangs.nama_kandang', 'kandangs.nama_karyawan', 'kandangs.jumlah_ayam')
            ->paginate(10);

        foreach ($kandangData as $kandang) {
            $kandang->total_ayam_terbaru = $kandang->jumlah_ayam - $kandang->jumlah_ayam_mati;
        }

        return $kandangData;
    }


    #[Title('Ayam')] 
    public function render()
    {
        return view('livewire.admin.chicken.chicken-page-admin')->layout('layouts.app');
    }
}
