<?php

namespace App\Livewire\Admin\Egg;

use Livewire\Component;
use Livewire\Attributes\Title;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Telur;
use App\Helpers\EmployeesCache;
use App\Helpers\EggsCache;

class EggPageEmployee extends Component
{
    public $bulan, $tahun;
    public $kandang;

    public function mount($name)
    {
        $this->bulan = now()->format('m');
        $this->tahun = now()->format('Y');

        $user = EmployeesCache::getUserEmployee($name);
        $this->kandang = $user->kandang;
    }

       public function updated($propertyName)
    {
        if (in_array($propertyName, ['bulan', 'tahun'])) {
            $this->getTableEggsProperty();
            $this->getThisMonthProperty();
        }
    }

    public function getThisMonthProperty()
    {
        $start = Carbon::createFromDate($this->tahun, $this->bulan, 1)->startOfMonth()->toDateString();
        $end = Carbon::createFromDate($this->tahun, $this->bulan, 1)->endOfMonth()->toDateString();
        
        $eggs =  Telur::where('kandang_id', $this->kandang?->id)
            ->whereBetween('tanggal', [$start, $end])
            ->get();

        $totalEggs = $eggs->sum('jumlah_telur_bagus') + $eggs->sum('jumlah_telur_retak');

        return [
            'totalEggs' => $totalEggs,
            'goodEggs' =>  $eggs->sum('jumlah_telur_bagus'),
            'crackedEggs' =>  $eggs->sum('jumlah_telur_retak'),
        ];
    }

    public function getTableEggsProperty()
    {
        return EggsCache::getTableEggs($this->kandang?->id, $this->tahun, $this->bulan);
    }

       public function exportPdf()
    {
        $data = EggsCache::getMontlyEggs_export($this->kandang?->id, $this->tahun, $this->bulan);

        $bulan = nama_bulan($this->bulan);
        $tahun = $this->tahun;

        $sumEggs = $data->sum('jumlah_telur_bagus');
        $crackedEggs = $data->sum('jumlah_telur_retak');

        $pdf = Pdf::loadView('livewire.telur.export-pdf', [
            'data' => $data,
            'nameChickenCoop' => $this->kandang?->nama_kandang ?? '-',
            'goodEggs' => number_format($sumEggs , 0, ',', '.'),
            'crackedEggs' => number_format($crackedEggs , 0, ',', '.'),
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "laporan-telur-{$bulan}-{$tahun}.pdf");
    }

    #[title('View Karywan')]
    public function render()
    {
        return view('livewire.admin.egg.egg-page-employee', [
            'name' => $this->kandang?->nama_karyawan,
            'nameChickenCoop' => $this->kandang?->nama_kandang ?? '-',
            'totalEggs' => number_format($this->thisMonth['totalEggs'], 0, ',', '.') ?? 0,
            'goodEggs' =>  number_format($this->thisMonth['goodEggs'], 0, ',', '.') ?? 0,
            'crackedEggs' => number_format($this->thisMonth['crackedEggs'], 0, ',', '.') ?? 0,
        ])->layout('layouts.app');
    }
}
