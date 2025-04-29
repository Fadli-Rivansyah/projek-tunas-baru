<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Pakan;
use Livewire\Attributes\Title;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use  Illuminate\Database\Eloquent\Collection;

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

        $pakan = Pakan::all();

        $totalCorn = $pakan->sum('jumlah_jagung') ?? 0;
        $totalMultivitamin = $pakan->sum('jumlah_multivitamin') ?? 0;

        $this->totalFeed = $pakan->sum('total_pakan'); 
        $this->jagung = $totalCorn;
        $this->multivitamin = $totalMultivitamin;
        $this->leftOverFeed = $pakan->sum('sisa_pakan');
    }

    public function updatedBulan()
    {
        $this->getSearchPakanProperty();
    }

    public function updatedTahun()
    {
        $this->getSearchPakanProperty();
    }

    public function getSearchPakanProperty()
    {
        $start = Carbon::createFromDate($this->tahun, $this->bulan, 1)->startOfMonth()->toDateString();
        $end = Carbon::createFromDate($this->tahun, $this->bulan, 1)->endOfMonth()->toDateString();

        return Pakan::when($this->search, function ($query) {
            $query->where('id', 'like', '%' . $this->search . '%');
        })->whereBetween('tanggal', [$start, $end])
        ->paginate(5);
    }

    public function exportPdf()
    {
        $data = $this->getSearchPakanProperty();

        $bulan = nama_bulan($this->bulan);
        $tahun = $this->tahun;

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
        return view('livewire.pages.pakan-main')->layout('layouts.app');
    }
}
