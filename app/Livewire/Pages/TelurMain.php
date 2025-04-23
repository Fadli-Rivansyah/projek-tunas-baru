<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Telur;
use Carbon\Carbon;
use Livewire\Attributes\Url;

class TelurMain extends Component
{
    public $search = '';
    public $kandang, $bulan, $tahun;
    public $telur, $totalTelur;

    public function mount()
    {
        // user relation
        $user = auth()->user();
        $kandang = $user->kandang;
        $this->kandang = $kandang;

        // // view date now
        $this->bulan = now()->format('m');
        $this->tahun = now()->format('Y');

        
    }
    
    public function getJumlahTelurProperty()
    {
        $start = Carbon::createFromDate($this->tahun, $this->bulan, 1)->startOfMonth()->toDateString();
        $end = Carbon::createFromDate($this->tahun, $this->bulan, 1)->endOfMonth()->toDateString();

        // menghitung perbulan
        $telur = Telur::where('kandang_id', $this->kandang->id)
            ->whereBetween('tanggal', [$start, $end]);

        // menghitung telur keseluruhan
        $totalEggs = Telur::where('kandang_id', $this->kandang->id);
        $totalEggs = $totalEggs->sum('jumlah_telur_bagus') + $totalEggs->sum('jumlah_telur_retak');
        
        return [
            'totalEggs' => number_format($totalEggs, 0, ',', '.'),
            'telurBagus' => $telur->sum('jumlah_telur_bagus') ?? 0,
            'telurRetak' => $telur->sum('jumlah_telur_retak') ?? 0
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
                $query->where('id', 'like', '%' . $this->search . '%');
            })->paginate(10);
    }

    // method hapus data telur
    public function destroy($id)
    {
        $telur= Telur::findOrFail($id);
        $telur->delete();

        return redirect()->route('telur')->with('success', 'Data telur berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.pages.telur-main', [
            'totalEggs' => $this->jumlahTelur['totalEggs'],
        ])->layout('layouts.app');
    }
}
