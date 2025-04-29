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

class Dashboard extends Component
{
    public $totalAyam, $ayamMatiMinggu, $kandang;
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

        // jumlah ayam awal  karyawan
        $ayamAwal = $this->kandang?->jumlah_ayam;
        $ayamMati = Ayam::where('kandang_id', $this->kandang?->id)->sum('jumlah_ayam_mati');
        $this->totalAyam = $ayamAwal - $ayamMati;

        // $this->totalAyam = Cache::remember($cacheKey, $cacheDuration, function() use ($kandangId) {
        //     $ayamAwal = $this->kandang->jumlah_ayam;
        //     $ayamMati = Ayam::where('kandang_id', $kandangId)->sum('jumlah_ayam_mati');
            
        //     return $ayamAwal - $ayamMati;
        // });
        
        // menghitung presentase
        $ayamMatiMinggu = $this->getHitungPersentaseAyamMati();
        // Hitung persentase dari ayam awal
        $this->ayamMatiMinggu = $ayamAwal > 0 ? round(($ayamMatiMinggu / $ayamAwal) * 100, 2) : 0;

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

    // count all eggs
    public function getAllEggsProperty()
    {
        // get all the eggs
        $eggs = Telur::whereBetween('tanggal', [$this->start, $this->end])->get();
        // count all the cracked eggs
        $crackedEggs = $eggs->sum('jumlah_telur_retak');
        // count all the good eggs
        $goodEggs = $eggs->sum('jumlah_telur_bagus');

        return [
           'totalEggs' => $crackedEggs + $goodEggs, 
           'crackedEggs' => $crackedEggs,
           'goodEggs' => $goodEggs,
        ];  
    }

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

    public function getTableTelurProperty()
    {
        $start = Carbon::createFromDate($this->tahun, $this->bulan, 1)->startOfMonth()->toDateString();
        $end = Carbon::createFromDate($this->tahun, $this->bulan, 1)->endOfMonth()->toDateString();

        return Telur::where('kandang_id', $this->kandang?->id)
            ->whereBetween('tanggal', [$start, $end])->paginate(5);
    }

    public function getTelurBulananProperty()
    {
        $queryTelurBagus = Telur::where('kandang_id', $this->kandang?->id)
            ->whereYear('tanggal', now()->year) // filter berdasarkan tahun aktif (bisa diganti $this->tahun)
            ->selectRaw('MONTH(tanggal) as bulan, SUM(jumlah_telur_bagus) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');
        
        $queryTelurRetak = Telur::where('kandang_id', $this->kandang?->id)
            ->whereYear('tanggal', now()->year) // filter berdasarkan tahun aktif (bisa diganti $this->tahun)
            ->selectRaw('MONTH(tanggal) as bulan, SUM(jumlah_telur_retak) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');
    
        $labels = [];
        $telurBagus = [];
        $telurRetak = [];
    
        for ($i = 1; $i <= 12; $i++) {
            $labels[] = \Carbon\Carbon::create()->month($i)->format('M');
            $telurBagus[] = $queryTelurBagus[$i] ?? 0;
            $telurRetak[] = $queryTelurRetak[$i] ?? 0;
        }
    
        return [
            'labels' => $labels,
            'telurBagus' => $telurBagus,
            'telurRetak' => $telurRetak,
        ];
    }

    public function getJumlahAyamProperty()
    {
        $ayamHidup = Ayam::where('kandang_id', $this->kandang?->id)->latest()->value('total_ayam');
        $ayamMati = Ayam::where('kandang_id', $this->kandang?->id)->sum('jumlah_ayam_mati');
        
        // nama barak
        $name = $this->kandang?->nama_kandang;
        // hitung usia ayam
        $usiaAyam = $this->kandang?->created_at;
        $rentangMinggu = Carbon::parse($usiaAyam)->diffInWeeks(now());
        $jumlahMinggu = round($rentangMinggu) + $this->kandang?->umur_ayam;

        return [
            'series' => [$ayamHidup, $ayamMati, $jumlahMinggu, $name],
        ];
    }

    // count presentase the eggs
    public function getHasilPersentaseTelur()
    {
        $latestTanggal = Telur::orderByDesc('tanggal')->value('tanggal');
        $latestDate = Carbon::parse($latestTanggal);

        $startOfThisWeek = $latestDate->copy()->startOfWeek();
        $endOfThisWeek = $latestDate->copy()->endOfWeek();
        
        $startOfLastWeek = $latestDate->copy()->subWeek()->startOfWeek();
        $endOfLastWeek = $latestDate->copy()->subWeek()->endOfWeek();
     
        // minggu lalu
        $telurMingguLalu = Telur::where('kandang_id', $this->kandang?->id)
            ->whereDate('tanggal', '>=', $startOfLastWeek)
            ->whereDate('tanggal', '<=', $endOfLastWeek)
            ->sum('jumlah_telur_bagus');

        // menghitung minggu ini
        $telurMingguIni = Telur::where('kandang_id', $this->kandang?->id)
            ->whereDate('tanggal', '>=', $startOfThisWeek)
            ->whereDate('tanggal', '<=', $endOfThisWeek)
            ->sum('jumlah_telur_bagus');

        if ($telurMingguLalu > 0) {
            $selisih = $telurMingguIni - $telurMingguLalu;
            $persentase = round(($selisih / $telurMingguLalu) * 100, 2);
            $naik = $selisih > 0;
        }elseif($telurMingguIni === $telurMingguLalu){
            $persentase = 0.00;
            $naik = false;
        }else{
            $persentase = $telurMingguIni > 0 ? 100 : 0.00;
            $naik = true;
        }

        return [
            'jumlah' => $telurMingguIni,
            'persentase' => $persentase,
            'naik' => $naik
        ];
    }

    // count all chicken like deadChicken and livechicken
    public function getAllChickensProperty()
    {
        $totalDeadChickens = Ayam::whereBetween('created_at', [$this->start, $this->end])
        ->whereHas('kandang.user', function ($query) {
            $query->where('is_admin', false);
        })->sum('jumlah_ayam_mati');

        $firstChickens = Kandang::whereHas('user', function ($query) {
            $query->where('is_admin', false);
        })->sum('jumlah_ayam');

        $liveChickens = $firstChickens - $totalDeadChickens;

       return [
            'deadChickens' => $totalDeadChickens,
            'liveChickens' => $liveChickens,
       ];
    }

    // count presentase dead chicken
    public function getHitungPersentaseAyamMati()
    {
        // Ambil data 7 hari terakhir
        $mingguLalu = Carbon::now()->subDays(7);

        return Ayam::where('kandang_id', $this->kandang?->id)
            ->where('created_at', '>=', $mingguLalu)
            ->sum('jumlah_ayam_mati') ?? 0;
    }

    // count all the feed
    public function getFeedAmountProperty()
    {
        $stock = Pakan::all();

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $jagung = $stock->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
        ->last()?->jumlah_jagung;

        $multivitamin = $stock->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
        ->last()?->jumlah_multivitamin;

        return [
            'jagung' => $jagung,
            'multivitamin' => $multivitamin,
        ];
    }

    // count all the employee
    public function getAllEmployeesProperty()
    {
        return User::where('is_admin', false)->count();
    }

    //count all the chickens coops
     public function getAllChickenCoopsProperty()
    {
        return Kandang::all()->count();
    }

    // summary employee
    public function getSummaryEmployeesProperty()
    {
        $users = User::where('is_admin', false)
            ->with(['kandang.ayam', 'kandang.telur'])
            ->paginate(5);

        $data = [];

        foreach ($users as $user) {
            $kandang = $user->kandang;
            $ayamMati = 0;
            if ($kandang && $kandang->ayam) {
                $ayamMati = $kandang->ayam
                    ->where('kandang_id', $kandang->id)
                    ->sum('jumlah_ayam_mati');
            }

            $totalAyam = $kandang?->jumlah_ayam - $ayamMati ?? 0;
           
            $eggs = 0;
            if ($kandang && $kandang->telur) {
                $eggs = $kandang->telur
                    ->where('kandang_id', $kandang->id)
                    ->sum('jumlah_telur_bagus');
            }
                    
            $data[] = [
                    'name' => $kandang?->nama_karyawan ?? '-',
                    'chickenCoop' => $kandang?->nama_kandang ?? '-',
                    'totalChicken' => $totalAyam ?? 0,
                    'deadChicken' => $ayamMati,
                    'eggs' => $eggs,
                ];
            }

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
            'totalChicken' =>  number_format($this->totalAyam, 0, ',', '.'),
            'totalEmployees' => $this->allEmployees,
            'totalChickenCoops' => $this->allChickenCoops,
            'totalEggs' => number_format($this->allEggs['totalEggs'], 0, ',', '.'),
            'goodEggs' => $this->allMonthlyEggs['goodEggs'],
            'crackedEggs' => $this->allMonthlyEggs['crackedEggs'],
            'deadChickens' => $this->allChickens['deadChickens'],
            'liveChickens' => $this->allChickens['liveChickens'],
            'feed' => $this->feedAmount,
        ])->layout('layouts.app');
    }
}
