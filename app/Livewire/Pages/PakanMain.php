<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Pakan;
use Livewire\Attributes\Title;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use  Illuminate\Database\Eloquent\Collection;
use App\Helpers\FeedsCache;

class PakanMain extends Component
{
    public $search = '';
    public $jagung, $multivitamin, $totalFeed, $leftOverFeed;
    public $tahun, $bulan;

    public function mount()
    {
         // view date
        $this->bulan = now()->format('m');
        $this->tahun = now()->format('Y');

        $lastFeed = FeedsCache::getTotalFeeds() ?? 0;
        $this->totalFeed = FeedsCache::getTotalAllFeeds($this->bulan, $this->tahun) ?? 0;
        $this->jagung = $lastFeed['jagung'] ?? 0;
        $this->multivitamin = $lastFeed['multivitamin'] ?? 0;
        $this->leftOverFeed = $this->jagung + $this->multivitamin;
    }

    public function updatedBulan()
    {
        $this->getMonthlyFeedsProperty();
    }

    public function updatedTahun()
    {
        $this->getMonthlyFeedsProperty();
    }

    public function getMonthlyFeedsProperty()
    {
        return  FeedsCache::getMonthlyAllFeeds($this->bulan, $this->tahun);
    }

    public function exportPdf()
    {
        $bulan = nama_bulan($this->bulan);
        $tahun = $this->tahun;

        $data = FeedsCache::getMonthlyAllFeeds($this->bulan, $this->tahun);

        $totalFeed = $data->sum('total_pakan');
        $leftOverFeed = $data->sum('sisa_pakan');

        $pdf = Pdf::loadView('livewire.pakan.export-pdf', [
            'data' => $data,
            'totalFeed' => number_format($totalFeed , 0, ',', '.'),
            'leftOverFeed' => number_format($leftOverFeed , 0, ',', '.'),
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "laporan-pakan-{$bulan}-{$tahun}.pdf");
    }

    public function destroy($id)
    {
        $telur= Pakan::findOrFail($id);
        $telur->delete();

        return redirect()->route('pakan')->with('success', 'Data pakan berhasil dihapus.');
    }

    #[Title('Pakan')] 
    public function render()
    {
        return view('livewire.pages.pakan-main',[
            'totalFeed' => $this->totalFeed,
            'jagung' =>  $this->jagung ,
            'multivitamin' => $this->multivitamin ,
            'leafOverFeed' =>  $this->leftOverFeed 
        ])->layout('layouts.app');
    }
}
