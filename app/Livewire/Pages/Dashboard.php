<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Title;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\Ayam;
use App\Models\Telur;
use App\Models\Kandang;
use App\Models\Pakan;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use App\Helpers\EggsCache;
use App\Helpers\FeedsCache;
use App\Helpers\ChickensCache;
use App\Helpers\EmployeesCache;

class Dashboard extends Component
{
    public $kandang;
    public $hasil;
    public $bulan,$tahun;
    public $start,$end;

    public function mount()
    {
        // ambil user (karyawan)
        $user = auth()->user();
        $this->kandang = $user->kandang;
        // view date
        $this->bulan = now()->format('m');
        $this->tahun = now()->format('Y');

        $this->start = Carbon::createFromDate($this->tahun, $this->bulan, 1)->startOfMonth()->toDateString();
        $this->end = Carbon::createFromDate($this->tahun, $this->bulan, 1)->endOfMonth()->toDateString();

        // daftarkan method
        $this->hasil = $this->getHasilPersentaseTelur();
        // $this->getJumlahAyamMati();
    }

    public function updatedBulan()
    {
        $this->getTableTelurProperty();
        $this->getSummaryEmployeesProperty();
    }

    public function updatedTahun()
    {
        $this->getTableTelurProperty();
        $this->getSummaryEmployeesProperty();
    }
    /**
     * ======== dashboard employee =========
     */
    public function getTableTelurProperty()
    {
        return EggsCache::getTableEggs($this->kandang?->id, $this->tahun, $this->bulan);
    }

    public function getMonthlyEggsProperty()
    {
        // cache
        $queryEggsGood = EggsCache::getGoodEggMonthly($this->kandang?->id);
        $queryEggsCracked = EggsCache::getCrackedEggMontly($this->kandang?->id);

        $labels = [];
        $goodEggs = [];
        $crackedEggs = [];
    
        for ($i = 1; $i <= 12; $i++) {
            $labels[] = \Carbon\Carbon::create()->month($i)->format('M');
            $goodEggs[] = $queryEggsGood[$i] ?? 0;
            $crackedEggs[] = $queryEggsCracked[$i] ?? 0;
        }
    
        return [
            'labels' => $labels,
            'goodEggs' => $goodEggs,
            'crackedEggs' => $crackedEggs,
        ];
    }

    public function getCountChickensProperty()
    {
        $firstChickens = $this->kandang?->jumlah_ayam;
        $kandangId = $this->kandang?->id;
        $firstChickensAge = $this->kandang?->created_at;
        $baseAge = $this->kandang?->umur_ayam ?? 0;
        // cache
        $totalChickens = ChickensCache::getTotalLiveChicken($kandangId, $firstChickens);
        $deadChickens = ChickensCache::getTotalDeadChicken($kandangId);
        $chickenAge = ChickensCache::getTotalChickensAge($kandangId, $firstChickensAge, $baseAge);

        return [
            'totalChickensInCage' => $totalChickens,
            'deadChickens' => $deadChickens, 
            'chickenAge' => $chickenAge,
        ];
    }
    // count presentase the eggs
    public function getHasilPersentaseTelur()
    {
        $latestTanggal = Telur::orderByDesc('tanggal')->value('tanggal');
        $latestDate = Carbon::parse($latestTanggal);
        //  last month
        $lastMonthEgg = EggsCache::getLastMonthGoodEggs($this->kandang?->id, $latestDate);
        // this month
        $eggOfTheMonth = EggsCache::getThisMonthGoodEggs($this->kandang?->id, $latestDate);
        
        if ($lastMonthEgg > 0) {
            $selisih = $eggOfTheMonth - $lastMonthEgg;
            $persentase = round(($selisih / $lastMonthEgg) * 100);
            $naik = $selisih > 0;
        }elseif($eggOfTheMonth === $lastMonthEgg){
            $persentase = 0.00;
            $naik = false;
        }else{
            $persentase = $eggOfTheMonth > 0 ? 100 : 0.00;
            $naik = true;
        }
                
        return [
            'jumlah' => $eggOfTheMonth,
            'persentase' => $persentase,
            'naik' => $naik
        ];
    }
    // count presentase dead chicken
    public function getPersentaseDeadchickenProperty()
    {
        $firstChickens = $this->kandang?->jumlah_ayam;
        // Ambil data 7 hari terakhir
        $week = Carbon::now()->subDays(7);
        $deadChickens = Cache::remember("kandang_{$this->kandang?->id}_count_persentase_chicken_dashboard", 300, function() use ($week) {
            return Ayam::where('kandang_id', $this->kandang?->id)
               ->where('created_at', '>=', $week)
               ->sum('jumlah_ayam_mati') ?? 0;
        });

        return $firstChickens > 0 ? round(($deadChickens / $firstChickens) * 100, 2) : 0;
    }

     // count all the feed
     public function getFeedAmountProperty()
     {
        return FeedsCache::getTotalFeeds();
     }
    /**
     * ========== dashboard admin ===========
     */
    // count all monthly eggs
    public function getAllMonthlyEggsProperty()
    {
        $queryGoodEgg = Telur::selectRaw('MONTH(tanggal) as bulan, SUM(jumlah_telur_bagus) as total')
            ->whereYear('tanggal', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        $queryCreckedEgg = Telur::selectRaw('MONTH(tanggal) as bulan, SUM(jumlah_telur_retak) as total')
            ->whereYear('tanggal', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        $goodEggs = [];
        $crackedEggs = [];

        for ($i = 1; $i <= 12; $i++) {
            $goodEggs[] = $queryGoodEgg[$i] ?? 0;
            $crackedEggs[] = $queryCreckedEgg[$i] ?? 0;
        }

        return  [
            'crackedEggs' => $crackedEggs,
            'goodEggs' => $goodEggs,
        ];
    }

    // count all chicken like deadChicken and livechicken
    public function getAllChickensProperty()
    {
        return ChickensCache::getChickensInCage($this->start, $this->end);
    }
    // count all the employee
    public function getAllEmployeesProperty()
    {
        return EmployeesCache::getTotalEmployees();
    }
    //count all the chickens coops
     public function getAllChickenCoopsProperty()
    {
        return ChickensCache::getTotalChickenInCage();
    }
    // summary employee
    public function getSummaryEmployeesProperty()
    {
        // cache data summary employees
        $data = EmployeesCache::getEmployeesActivites();
         // Ubah array $data menjadi paginator
        $page = request()->get('page', 1); // ambil halaman dari URL
        $perPage = 5;
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

    // export pdf
    public function exportPdf()
    {
        $start = Carbon::createFromDate($this->tahun, $this->bulan, 1)->startOfMonth()->toDateString();
        $end = Carbon::createFromDate($this->tahun, $this->bulan, 1)->endOfMonth()->toDateString();

        $data = $this->getSummaryEmployeesProperty();

        $totalChickens = 0;
        $deadChickens = 0;
        $totalEggs = 0;

        foreach ($data as $item) {
            $totalChickens += $item['totalChicken'];
            $deadChickens += $item['deadChicken'];
            $totalEggs += $item['eggs'];
        }
 
        $bulan = nama_bulan($this->bulan);
        $tahun = $this->tahun;
        
        $pdf = Pdf::loadView('report.export-pdf-admin', [
            'data' => $data,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'totalChickens' =>number_format($totalChickens, 0, ',', '.'),
            'deadChickens' => number_format($deadChickens, 0, ',', '.'),
            'totalEggs' => number_format($totalEggs, 0, ',', '.'),
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "laporan-summary-karyawan-{$bulan}-{$tahun}.pdf");
    }

    #[Title('Dashboard')] 
    public function render()
    {
        return view('livewire.pages.dashboard', [
            'nameChickensCoop' => auth()->user()->kandang?->nama_kandang ?? '-',
            'totalChickens' =>  number_format($this->countChickens['totalChickensInCage'], 0, ',', '.'),
            'totalEmployees' => $this->allEmployees,
            'totalChickenCoops' => $this->allChickenCoops,
            'goodEggs' => $this->allMonthlyEggs['goodEggs'],
            'crackedEggs' => $this->allMonthlyEggs['crackedEggs'],
            'deadChickens' => number_format($this->allChickens['deadChickensMontly'], 0, ',', '.'),
            'liveChickens' => number_format($this->allChickens['liveChickens'], 0, ',', '.'),
            'feed' => $this->feedAmount,
        ])->layout('layouts.app');
    }
}
