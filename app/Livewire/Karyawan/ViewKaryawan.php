<?php

namespace App\Livewire\Karyawan;

use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use App\Helpers\ChickensCache;
use App\Helpers\EggsCache;
use App\Helpers\EmployeesCache;
use Livewire\Attributes\Title;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Telur;
use App\Models\Ayam;
use App\Models\Kandang;
use Carbon\Carbon;


class ViewKaryawan extends Component
{
    public $name, $kandang;
    public $bulan, $tahun;

    public function mount($name){
        // cache for user
        $user = EmployeesCache::getUserEmployee($name);

        $this->kandang = $user->kandang;
        $this->name = $name;

        $this->bulan = now()->format('m');
        $this->tahun = now()->format('Y');
    }

    public function updatedBulan()
    {
        $this->getSummaryEmployeeProperty();
    }

    public function updatedTahun()
    {
        $this->getSummaryEmployeeProperty();
    }

    public function getSummaryEmployeeProperty()
    {
        $start = Carbon::createFromDate($this->tahun, $this->bulan, 1)->startOfMonth()->toDateString();
        $end = Carbon::createFromDate($this->tahun, $this->bulan, 1)->endOfMonth()->toDateString();

        //  cache
        $data = EmployeesCache::getUserRelations($this->name, $start, $end);

        $page = request()->get('page', 1);
        $perPage = 5; // jumlah data per halaman
        $collection = new Collection($data);

        $currentPageItems = $collection->slice(($page - 1) * $perPage, $perPage)->values();
        return new LengthAwarePaginator(
            $currentPageItems,
            $collection->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }

    public function getChickenComparationProperty()
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

    public function getEggComparationProperty()
    {
        // cache
        $queryGoodEgg = EggsCache::getGoodEggMonthly($this->kandang?->id);
        $queryCrackedEgg = EggsCache::getCrackedEggMontly($this->kandang?->id);

        $goodEggs = [];
        $crackedEggs = [];
        $labels = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = \Carbon\Carbon::create()->month($i)->format('M');
            $goodEggs[] = $queryGoodEgg[$i] ?? 0;
            $crackedEggs[] = $queryCrackedEgg[$i] ?? 0;
        }

        return  [
            'labels' => $labels,
            'crackedEggs' => $crackedEggs,
            'goodEggs' => $goodEggs,
        ];
    }

    
    public function exportPdf()
    {
        $start = Carbon::createFromDate($this->tahun, $this->bulan, 1)->startOfMonth()->toDateString();
        $end = Carbon::createFromDate($this->tahun, $this->bulan, 1)->endOfMonth()->toDateString();

        $data = $this->getSummaryEmployeeProperty();

        $deadChickens = 0;
        $totalEggs = 0;
        $crackedEggs = 0;

        foreach ($data as $item) {
            $deadChickens += $item['deadChickens'];
            $totalEggs += $item['productionEggs'];
            $crackedEggs += $item['crackedEggs'];
        }

        $bulan = nama_bulan($this->bulan);
        $tahun = $this->tahun;
        
        $pdf = Pdf::loadView('livewire.karyawan.export-karyawan-pdf', [
            'data' => $data,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'liveChickens' =>number_format($this->chickenComparation['liveChicken'], 0, ',', '.'),
            'deadChickens' => number_format($deadChickens, 0, ',', '.'),
            'totalEggs' => number_format($totalEggs, 0, ',', '.'),
            'crackedEggs' => number_format($crackedEggs, 0, ',', '.'),
            'totalChickenCoops' => $this->kandang?->nama_kandang,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "laporan-telur-{$bulan}-{$tahun}.pdf");
    }

    #[Title('View Karyawan')] 
    public function render()
    {
        return view('livewire.karyawan.view-karyawan', [
            'name' => $this->kandang?->nama_karyawan,
            'nameChickenCoop' => $this->kandang?->nama_kandang ?? '-',
            'chickenCount' => number_format($this->kandang?->jumlah_ayam, 0, ',', '.') ?? 0,
            'chickenAge' => $this->kandang?->umur_ayam ?? 0,
            'labels' =>  $this->eggComparation['labels'],
            'goodEggs' => $this->eggComparation['goodEggs'],
            'crackedEggs' => $this->eggComparation['crackedEggs'],
            'liveChicken' =>  $this->chickenComparation['liveChicken'],
            'deadChicken' =>  $this->chickenComparation['deadChicken'],
            'ageChickenNow' =>  $this->chickenComparation['ageChickenNow'],
        ])->layout('layouts.app');
    }
}
