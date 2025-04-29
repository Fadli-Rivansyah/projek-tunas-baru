<?php

namespace App\Livewire\Karyawan;

use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
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
        $user = User::where('name', $name)
        ->with(['kandang.ayam', 'kandang.telur'])
        ->first();

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

        // Ambil data user berdasarkan nama
        $user = User::where('name', $this->name)
            ->with(['kandang.ayam' => function($query) use ($start, $end) {
                $query->whereBetween('tanggal', [$start, $end]);
            }, 'kandang.telur' => function($query)  use ($start, $end){
                $query->whereBetween('tanggal', [$start, $end]);
        }])
        ->first(); // Mengambil satu user pertama sesuai nama

        $data = [];

        // Cek jika data user ada
        $kandang = $user->kandang;

        if ($kandang) {
            $dataAyam = $kandang->ayam()
                ->whereBetween('tanggal', [$start, $end])
                ->get()
                ->groupBy('tanggal');
    
            $dataTelur = $kandang->telur()
                ->whereBetween('tanggal', [$start, $end])
                ->get()
                ->groupBy('tanggal');

            $allDates = collect($dataAyam->keys())
                ->merge($dataTelur->keys())
                ->unique()
                ->sort();
        
            // Gabungkan berdasarkan tanggal
            foreach ($allDates as $tanggal) {
                $ayamHariIni = $dataAyam->get($tanggal)?->first(); // kalau 1 data per tanggal
                $telurHariIni = $dataTelur->get($tanggal)?->first();
        
                $data[] = [
                    'tanggal' => $tanggal,
                    'liveChickens' => $ayamHariIni->total_ayam ?? 0,
                    'deadChickens' => $ayamHariIni->jumlah_ayam_mati ?? 0,
                    'productionEggs' => $telurHariIni->jumlah_telur_bagus ?? 0,
                    'crackedEggs' => $telurHariIni->jumlah_telur_retak ?? 0,
                    'feedChickens' => $ayamHariIni->jumlah_pakan ?? 0,
                ];
            }
        }

        $currentPage = request()->get('page', 1);
        $perPage = 3; // jumlah data per halaman
        $offset = ($currentPage - 1) * $perPage;

        $pagedData = new LengthAwarePaginator(
            collect($data)->slice($offset, $perPage)->values(),
            count($data),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return $pagedData;
    }

    public function getChickenComparationProperty()
    {
        $queryChickens = Ayam::where('kandang_id', $this->kandang?->id);

        $chickensAge = $this->kandang?->created_at;
        $weekRange = Carbon::parse($chickensAge)->diffInWeeks(now());
        $weekCount = round($weekRange) + $this->kandang?->umur_ayam;

        return [
            'liveChicken' =>  $this->kandang?->jumlah_ayam  -  $queryChickens->sum('jumlah_ayam_mati'),
            'deadChicken' => $queryChickens->sum('jumlah_ayam_mati'),
            'ageChickenNow' => $weekCount,
        ];
    }

    public function getEggComparationProperty()
    {
        // menghitung perbulan
        $queryGoodEgg = Telur::where('kandang_id', $this->kandang?->id)
            ->whereYear('tanggal', now()->year)
            ->selectRaw('MONTH(tanggal) as bulan, SUM(jumlah_telur_bagus) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');
    
        $queryCrackedEgg = Telur::where('kandang_id', $this->kandang?->id)
            ->whereYear('tanggal', now()->year)
            ->selectRaw('MONTH(tanggal) as bulan, SUM(jumlah_telur_retak) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');
    
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

        $liveChickens = 0;
        $deadChickens = 0;
        $totalEggs = 0;
        $crackedEggs = 0;

        foreach ($data as $item) {
            $liveChickens += $item['liveChickens'];
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
            'liveChickens' =>number_format($liveChickens, 0, ',', '.'),
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
