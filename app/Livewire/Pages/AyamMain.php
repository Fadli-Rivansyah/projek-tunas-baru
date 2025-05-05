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
use Illuminate\Support\Facades\Cache;
use App\Helpers\ChickensCache;
use App\Helpers\FeedsCache;


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
            $firstChickens = $this->kandang?->jumlah_ayam;
            $kandangId = $this->kandang?->id;
            $firstChickensAge = $this->kandang?->created_at;
            $baseAge = $this->kandang?->umur_ayam ?? 0;
            // cache
            $this->totalAyam = ChickensCache::getTotalLiveChicken($kandangId, $firstChickens);
            $this->totalMati = ChickensCache::getTotalDeadChicken($kandangId);
            $this->chickenAge = ChickensCache::getTotalChickensAge($kandangId, $firstChickensAge, $baseAge);
            $this->pakan = FeedsCache::getTotalFeeds();
        }
    }

    // hook livewire 
    public function updatedBulan()
    {
        $this->getMonthlyChickensProperty();
    }

    public function updatedTahun()
    {
        $this->getMonthlyChickensProperty();
    }

    // method view data filter, search
    public function getMonthlyChickensProperty()
    {
        $start = Carbon::createFromDate($this->tahun, $this->bulan, 1)->startOfMonth()->toDateString();
        $end = Carbon::createFromDate($this->tahun, $this->bulan, 1)->endOfMonth()->toDateString();
     
        return Ayam::where('kandang_id', $this->kandang?->id)
        ->whereBetween('tanggal', [$start, $end])
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
        $data = ChickensCache::getMonthlyChickens($this->kandang?->id, $this->tahun, $this->bulan);

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
