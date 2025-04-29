<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Telur;
use Carbon\Carbon;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Cache;
use Barryvdh\DomPDF\Facade\Pdf;

class TelurMain extends Component
{
    public $search = '';
    public $kandang, $bulan, $tahun;
    public $telur, $totalTelur;

    public function mount()
    {
        // user relation
        $user = auth()->user();
        $this->kandang = $user->kandang;

        // // view date now
        $this->bulan = now()->format('m');
        $this->tahun = now()->format('Y');
    }
    
    public function getJumlahTelurProperty()
    {
        // menghitung perbulan
        $eggs = Cache::remember("kandang_{$this->kandang->id}_export_eggs", 300, function() {
            $start = Carbon::createFromDate($this->tahun, $this->bulan, 1)->startOfMonth()->toDateString();
            $end = Carbon::createFromDate($this->tahun, $this->bulan, 1)->endOfMonth()->toDateString();
            
            return Telur::where('kandang_id', $this->kandang?->id)
               ->whereBetween('tanggal', [$start, $end])->get();
        });
        // menghitung telur keseluruhan
        $totalEggs = $eggs->sum('jumlah_telur_bagus') + $eggs->sum('jumlah_telur_retak');
        return [
            'totalEggs' => number_format($totalEggs, 0, ',', '.'),
            'telurBagus' => $eggs->sum('jumlah_telur_bagus') ?? 0,
            'telurRetak' => $eggs->sum('jumlah_telur_retak') ?? 0
        ];
    }

    public function updatedBulan()
    {
        $this->getFindTelurProperty();
        $this->getJumlahTelurProperty();
    }

    public function updatedTahun()
    {
        $this->getFindTelurProperty();
        $this->getJumlahTelurProperty();
    }

    // method search dan filter
    public function getFindTelurProperty()
    {
        $start = Carbon::createFromDate($this->tahun, $this->bulan, 1)->startOfMonth()->toDateString();
        $end = Carbon::createFromDate($this->tahun, $this->bulan, 1)->endOfMonth()->toDateString();

        return Telur::where('kandang_id', $this->kandang->id)
            ->whereBetween('tanggal', [$start, $end])
            ->when($this->search, function ($query) {
                $query->where('tanggal', 'like', '%' . $this->search . '%');
            })->paginate(10);
    }

    // method hapus data telur
    public function destroy($id)
    {
        $telur= Telur::findOrFail($id);
        $telur->delete();

        return redirect()->route('telur')->with('success', 'Data telur berhasil dihapus.');
    }

    public function exportPdf()
    {
        $data = Cache::remember("kandang_{$this->kandang->id}_export_eggs", 300, function() {
            $start = Carbon::createFromDate($this->tahun, $this->bulan, 1)->startOfMonth()->toDateString();
            $end = Carbon::createFromDate($this->tahun, $this->bulan, 1)->endOfMonth()->toDateString();
            
            return Telur::with('kandang')
                ->where('kandang_id', $this->kandang->id)
                ->whereBetween('tanggal', [$start, $end])
                ->limit(50)
                ->get();
        });

        $bulan = nama_bulan($this->bulan);
        $tahun = $this->tahun;

        $sumEggs = $data->sum('jumlah_telur_bagus');
        $crackedEggs = $data->sum('jumlah_telur_retak');

        $pdf = Pdf::loadView('livewire.telur.export-pdf', [
            'data' => $data,
            'nameChickenCoop' => $this->kandang?->nama_kandang ?? '-',
            'goodEggs' => number_format($sumEggs , 0, ',', '.'),
            'crackedEggs' => number_format($crackedEggs , 0, ',', '.'),
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "laporan-telur-{$bulan}-{$tahun}.pdf");
    }

    #[Title('Telur')] 
    public function render()
    {
        return view('livewire.pages.telur-main', [
            'totalEggs' => $this->jumlahTelur['totalEggs'],
        ])->layout('layouts.app');
    }
}
