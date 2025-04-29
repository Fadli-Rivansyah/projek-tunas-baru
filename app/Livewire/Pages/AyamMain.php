<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Ayam;
use App\Models\Kandang;
use App\Models\Pakan;
use Carbon\Carbon;
use App\Charts\MonthlyAyamChart;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Title;

class AyamMain extends Component
{
    public $search='';
    public $totalAyam, $totalMati, $pakan, $kandang, $chickenAge;
    public $tahun, $bulan;
    public $dataAyam=[];

    public function mount()
    {
        // view date
        $this->bulan = now()->format('m');
        $this->tahun = now()->format('Y');

        // ambil user
        $user = auth()->user();
        $this->kandang = $user->kandang;
      
        if($this->kandang){
            // temukan jumlah ayam
            $ayamAwal = $this->kandang?->jumlah_ayam;
            $ayamMati = Ayam::where('kandang_id', $this->kandang?->id)->sum('jumlah_ayam_mati');
            $this->totalAyam = $ayamAwal - $ayamMati;
            $this->totalMati = $ayamMati;
            // chicken age
            $usiaAyam = $this->kandang?->created_at;
            $rentangMinggu = Carbon::parse($usiaAyam)->diffInWeeks(now());
            $this->chickenAge = round($rentangMinggu) + $this->kandang?->umur_ayam;
        }
        // tampilkan detail pakan
        $this->pakan = cache()->remember('detail_pakan', 60, function() {
            $pakan = Pakan::latest()->first();
            return [
                'jagung' => $pakan->jumlah_jagung ?? 0,
                'multivitamin' => $pakan->jumlah_multivitamin ?? 0,
            ];
        });
    }

    // hook livewire 
    public function updatedBulan()
    {
        $this->getFindAyamProperty();
    }

    public function updatedTahun()
    {
        $this->getFindAyamProperty();
    }

    // method view data filter, search
    public function getFindAyamProperty()
    {
        $start = Carbon::createFromDate($this->tahun, $this->bulan, 1)->startOfMonth()->toDateString();
        $end = Carbon::createFromDate($this->tahun, $this->bulan, 1)->endOfMonth()->toDateString();
      
        return  Ayam::with('kandang')
            ->where('kandang_id', $this->kandang->id)
            ->whereBetween('tanggal', [$start, $end])
            ->when($this->search, function ($query) {
                $query->where('tanggal', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);
    }


    public function destroy($id)
    {
        $ayam= Ayam::findOrFail($id);
        $ayam->delete();

        return redirect()->route('ayam')->with('success', 'Data ayam berhasil dihapus.');
    }

    public function exportPdf()
    {
        $start = Carbon::createFromDate($this->tahun, $this->bulan, 1)->startOfMonth()->toDateString();
        $end = Carbon::createFromDate($this->tahun, $this->bulan, 1)->endOfMonth()->toDateString();

        $data = Ayam::with('kandang')
            ->where('kandang_id', $this->kandang->id)
            ->whereBetween('tanggal', [$start, $end])
            ->limit(500) 
            ->get();

        $bulan = nama_bulan($this->bulan);
        $tahun = $this->tahun;

        $live = $this->totalAyam;
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

    #[Title('Ayam')] 
    public function render()
    {
        $jumlahAyam = $this->kandang?->jumlah_ayam ?? 0;
        
        return view('livewire.pages.ayam-main', [
            'totalAyam' => $jumlahAyam,
            'totalAyamChart' => $this->totalAyam,
            'totalMatiChart' => $this->totalMati,
        ])->layout('layouts.app');
    }
}
