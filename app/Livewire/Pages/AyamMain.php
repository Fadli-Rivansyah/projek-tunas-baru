<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Ayam;
use App\Models\Kandang;
use App\Models\Pakan;
use Carbon\Carbon;
use App\Charts\MonthlyAyamChart;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class AyamMain extends Component
{
    public $search='';
    public $totalAyam, $totalMati, $pakan, $kandang;
    public $tahun, $bulan;
    public $dataAyam=[];

    public function mount()
    {
        // view date
        $this->bulan = now()->format('m');
        $this->tahun = now()->format('Y');

        // ambil user
        $user = auth()->user();
        $kandang = $user->kandang;
        $this->kandang = $kandang;

        // temukan jumlah ayam
        $ayamAwal = $kandang?->jumlah_ayam;

        $ayamMati = Ayam::where('kandang_id', $kandang?->id)->sum('jumlah_ayam_mati');
        $this->totalAyam = $ayamAwal - $ayamMati;
        $this->totalMati = $ayamMati;

        // tampilkan detail pakan
        $this->pakan = $this->getDetailPakan();
    }

    // method view data filter, search
    public function getFindAyamProperty()
    {
        $start = Carbon::createFromDate($this->tahun, $this->bulan, 1)->startOfMonth()->toDateString();
        $end = Carbon::createFromDate($this->tahun, $this->bulan, 1)->endOfMonth()->toDateString();

        return Ayam::where('kandang_id', $this->kandang->id)
            ->whereBetween('tanggal', [$start, $end])
            ->when($this->search, function ($query) {
                $query->where('id', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);
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

    public function getDetailPakan()
    {
        $pakan = Pakan::latest()->first();

        return [
            'jagung' => $pakan->jumlah_jagung ?? 0,
            'multivitamin' => $pakan->jumlah_multivitamin ?? 0,
        ];
    }

    public function destroy($id)
    {
        $ayam= Ayam::findOrFail($id);
        $ayam->delete();

        return redirect()->route('ayam')->with('success', 'Data ayam berhasil dihapus.');
    }

    public function exportPdf()
    {
        $data = $this->getFindAyamProperty();

        $bulan = $this->bulan;
        $tahun = $this->tahun;

        $pdf = Pdf::loadView('exports.summary-pdf', [
            'data' => $data,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "laporan-{$bulan}-{$tahun}.pdf");
    }


    public function render()
    {
        
        $jumlahAyam = $this->kandang->jumlah_ayam;
        // $dataAyam = $kandang->ayams;
        return view('livewire.pages.ayam-main', [
            // 'ayam' => $dataAyam,
            'totalAyam' => $jumlahAyam,
            'totalAyamChart' => $this->totalAyam,
            'totalMatiChart' => $this->totalMati,
        ])->layout('layouts.app');
    }
}
