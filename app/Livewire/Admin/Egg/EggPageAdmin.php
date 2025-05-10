<?php

namespace App\Livewire\Admin\Egg;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Helpers\EggsCache;
use Carbon\Carbon;
use App\Models\Kandang;
use App\Models\Telur;

class EggPageAdmin extends Component
{
    public $bulan, $tahun;

    public function mount()
    {
        $this->bulan = now()->format('m');
        $this->tahun = now()->format('Y');
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['bulan', 'tahun'])) {
            $this->getTableEggsProperty();
            $this->getCountEggsProperty();
        }
    }

    public function getCountEggsProperty()
    {
        $start = Carbon::createFromDate($this->tahun, $this->bulan, 1)->startOfMonth()->toDateString();
        $end = Carbon::createFromDate($this->tahun, $this->bulan, 1)->endOfMonth()->toDateString();
        
        $egg = Telur::whereBetween('tanggal', [$start, $end])->get();
        $totalEggs = $egg->sum('jumlah_telur_bagus') + $egg->sum('jumlah_telur_retak');

        return [
            'goodEggs' => $egg->sum('jumlah_telur_bagus'),
            'crackedEggs' => $egg->sum('jumlah_telur_retak'),
            'totalEggs' => $totalEggs
        ];
    }

    public function getTableEggsProperty()
    {
        $start = Carbon::createFromDate($this->tahun, $this->bulan, 1)->startOfMonth()->toDateString();
        $end = Carbon::createFromDate($this->tahun, $this->bulan, 1)->endOfMonth()->toDateString();

        $kandangData = Telur::join('kandangs', 'telurs.kandang_id', '=', 'kandangs.id')
            ->selectRaw('
                kandangs.id as kandang_id, 
                kandangs.nama_kandang,
                kandangs.nama_karyawan,
                MAX(telurs.tanggal) as tanggal,
                SUM(telurs.jumlah_telur_bagus) as telur_bagus, 
                SUM(telurs.jumlah_telur_retak) as telur_retak
                ')
            ->groupBy('kandangs.nama_kandang', 'kandangs.nama_karyawan')
            ->whereBetween('tanggal', [$start, $end])
            ->paginate(10);

        foreach ($kandangData as $kandang) {
            $kandang->produksi_telur = $kandang->telur_bagus + $kandang->telur_retak;
        }

        return $kandangData;
    }

    #[Title('Telur')] 
    public function render()
    {
        return view('livewire.admin.egg.egg-page-admin', [
            'totalEggs' => number_format( $this->countEggs['totalEggs'], 0, ',', '.'),
            'goodEggs' => number_format( $this->countEggs['goodEggs'], 0, ',', '.'),
            'crackedEggs' => number_format( $this->countEggs['crackedEggs'], 0, ',', '.'),
        ])->layout('layouts.app');
    }
}
