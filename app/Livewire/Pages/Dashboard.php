<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Title;
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
        $kandang = $user->kandang;
        $this->kandang = $kandang;

        // view date
        $this->bulan = now()->format('m');
        $this->tahun = now()->format('Y');

        $this->start = Carbon::createFromDate($this->tahun, $this->bulan, 1)->startOfMonth()->toDateString();
        $this->end = Carbon::createFromDate($this->tahun, $this->bulan, 1)->endOfMonth()->toDateString();

        // jumlah ayam awal  karyawan
        $ayamAwal = $kandang?->jumlah_ayam;
        $ayamMati = Ayam::where('kandang_id', $kandang?->id)->sum('jumlah_ayam_mati');
        $this->totalAyam = $ayamAwal - $ayamMati;
        
        // menghitung presentase
        $ayamMatiMinggu = $this->getHitungPersentaseAyamMati();
        // Hitung persentase dari ayam awal
        $this->ayamMatiMinggu = $ayamAwal > 0
        ? round(($ayamMatiMinggu / $ayamAwal) * 100, 2)
        : 0;

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

    public function getAllEggsProperty()
    {
        $eggs = Telur::all()->whereBetween('tanggal', [$this->start, $this->end]);
        $crackedEggs = $eggs->sum('jumlah_telur_retak');
        $goodEggs = $eggs->sum('jumlah_telur_bagus');

        return [
           'totalEggs' => $crackedEggs + $goodEggs, 
           'crackedEggs' => $crackedEggs,
           'goodEggs' => $goodEggs,
        ];  
    }

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

    public function getAllChickensProperty()
    {
        $totalChickens = Ayam::whereHas('kandang.user', function ($query) {
            $query->where('is_admin', false); // hanya user yang bukan admin
            $query->whereBetween('tanggal', [$this->start, $this->end]);
        });

        $firstChickens = Kandang::all()->sum('jumlah_ayam') - $totalChickens->sum('jumlah_ayam_mati');

       return [
            'deadChickens' => $totalChickens->sum('jumlah_ayam_mati'),
            'liveChickens' => $firstChickens,
       ];
    }

    public function getHitungPersentaseAyamMati()
    {
        // Ambil data 7 hari terakhir
        $mingguLalu = Carbon::now()->subDays(7);

        return Ayam::where('kandang_id', $this->kandang?->id)
            ->where('created_at', '>=', $mingguLalu)
            ->sum('jumlah_ayam_mati') ?? 0;
    }

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

    public function getAllEmployeesProperty()
    {
        return User::where('is_admin', false)->count();
    }

     public function getAllChickenCoopsProperty()
    {
        return Kandang::all()->count();
    }

    public function getSummaryEmployeesProperty()
    {
        $users = User::where('is_admin', false)
            ->with(['kandang.ayam', 'kandang.telur'])
            ->paginate(5);

        $data = [];

        foreach ($users as $user) {
            $kandang = $user->kandang;
            $ayamMati =  $kandang?->ayam
                ->where('kandang_id', $kandang->id)
                ->sum('jumlah_ayam_mati') ?? 0;

            $totalAyam = $kandang?->jumlah_ayam - $ayamMati ?? 0;
           
            $eggs = $kandang && $kandang->telur
                ? $kandang?->telur
                    ->where('kandang_id', $kandang->id)
                    ->sum('jumlah_telur_bagus') : 0;
            
            $data[] = [
                    'name' => $kandang->nama_karyawan,
                    'chickenCoop' => $kandang->nama_kandang ?? '-',
                    'totalChicken' => $totalAyam,
                    'deadChicken' => $ayamMati,
                    'eggs' => $eggs,
                ];
            }

        return $data;
}

    #[Title('Dashboard')] 
    public function render()
    {
        return view('livewire.pages.dashboard', [
            'totalEmployees' => $this->allEmployees,
            'totalChickenCoops' => $this->allChickenCoops,
            'totalEggs' => number_format($this->allEggs['totalEggs'], 0, ',', '.'),
            'goodEggs' => $this->allMonthlyEggs['goodEggs'],
            'crackedEggs' => $this->allMonthlyEggs['crackedEggs'],
            'deadChickens' => number_format($this->allChickens['deadChickens'], 0, ',', '.'),
            'liveChickens' => number_format($this->allChickens['liveChickens'], 0, ',', '.'),
            'feed' => $this->feedAmount,
        ])->layout('layouts.app');
    }
}
