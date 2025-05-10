<?php

namespace App\Livewire\Admin\Chicken;

use Livewire\Component;
use Livewire\Attributes\Title;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Ayam;
use App\Helpers\EmployeesCache;
use App\Helpers\ChickensCache;

class ChickenPageEmployee extends Component
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

    function updatedBulan()
    {
        $this->getTableChickensProperty();
    }
    
    
    public function updatedTahun()
    {
        $this->getTableChickensProperty();
    }
    
    public function getThisMonthlyProperty()
    {
        $start = Carbon::createFromDate($this->tahun, $this->bulan, 1)->startOfMonth()->toDateString();
        $end = Carbon::createFromDate($this->tahun, $this->bulan, 1)->endOfMonth()->toDateString();
        
        return $this->kandang->ayam()->whereBetween('tanggal', [$start, $end])->sum('jumlah_ayam_mati');
    }

    public function getTableChickensProperty()
    {
        $start = Carbon::createFromDate($this->tahun, $this->bulan, 1)->startOfMonth()->toDateString();
        $end = Carbon::createFromDate($this->tahun, $this->bulan, 1)->endOfMonth()->toDateString();
        
        $chickens = Ayam::where('kandang_id', $this->kandang?->id)
                ->whereBetween('tanggal', [$start, $end]);
                
        return [
            'montlyChickens' => $chickens->paginate(7),
            'montlycDeadChickens' => $chickens->sum('jumlah_ayam_mati'),
        ];
    }

    public function getChartChickensProperty()
    {
        $firstChickens = $this->kandang?->jumlah_ayam;
        $kandangId = $this->kandang?->id;
        $firstChickensAge = $this->kandang?->created_at;
        $baseAge = $this->kandang?->umur_ayam ?? 0;
        // cache
        $liveChickens = ChickensCache::getTotalLiveChicken($kandangId, $firstChickens);
        $deadChickens = ChickensCache::getTotalDeadChicken($kandangId);
        $chickenAge = ChickensCache::getTotalChickensAge($kandangId, $firstChickensAge, $baseAge);

        return [
            'liveChicken' => $liveChickens,
            'deadChicken' => $deadChickens,
            'ageChickenNow' => $chickenAge,
        ];
    }

        public function exportPdf()
    {
        $start = Carbon::createFromDate($this->tahun, $this->bulan, 1)->startOfMonth()->toDateString();
        $end = Carbon::createFromDate($this->tahun, $this->bulan, 1)->endOfMonth()->toDateString();

        $data = ChickensCache::getMonthlyChickens($this->kandang?->id, $this->tahun, $this->bulan);

         $bulan = nama_bulan($this->bulan);
        $tahun = $this->tahun;

        $live = $this->chartChickens['liveChicken'];
        $dead = $data->sum('jumlah_ayam_mati');
        $feed = $data->sum('jumlah_pakan');

        $pdf = Pdf::loadView('livewire.ayam.export-pdf', [
            'data' => $data,
            'nameChickenCoop' => $data->first()?->kandang?->nama_kandang ?? '-',
            'liveChickens' => number_format($live , 0, ',', '.'),
            'deadChickens' => number_format($dead , 0, ',', '.'),
            'feedChickens' => number_format($feed , 0, ',', '.'),
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "laporan-ayam-{$bulan}-{$tahun}.pdf");
    }


    #[title('View Karyawan')]
    public function render()
    {
        return view('livewire.admin.chicken.chicken-page-employee', [
            'name' => $this->kandang?->nama_karyawan,
            'nameChickenCoop' => $this->kandang?->nama_kandang ?? '-',
            'chickenCount' => number_format($this->kandang?->jumlah_ayam, 0, ',', '.') ?? 0,
            'chickenAge' => $this->kandang?->umur_ayam ?? 0,
            'montlyDeadChickens' => number_format($this->thisMonthly, 0, ',', '.') ?? 0,
        ])->layout('layouts.app');
    }
}
