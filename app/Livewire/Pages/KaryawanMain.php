<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\User;
use App\Models\Kandang;
use Carbon\Carbon;
use Livewire\Attributes\Title;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Cache;

class KaryawanMain extends Component
{
    public $search='';
    public $user, $kandang;
    public $tahun, $bulan;

    public function mount()
    {
        $this->user = Cache::remember('non_admin_users_count', 100, function() {
            return User::where('is_admin', false)->count();
        });
        
        $this->kandang = Cache::remember('kandangs_count', 100, function() {
            return Kandang::count();
        });
        
        // show date this mount and this years
        $this->bulan = now()->format('m');
        $this->tahun = now()->format('Y');
    }
    //show number of employees
    public function getSearchKaryawanProperty()
    {
        return User::with('kandang')
            ->where('is_admin', false)
            // based on input search
            ->when($this->search, function ($query) {
                $query->where('id', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);
    }
    // export to pdf
    public function exportPdf()
    {
        // data from method getSearchKaryawanProperty();
        $data = $this->getSearchKaryawanProperty();
        // helper month
        $bulan = nama_bulan($this->bulan);
        $tahun = $this->tahun;
        $totalEmployees = $data->count();
        $totalChickenCoops =  $this->kandang;
        
        $pdf = Pdf::loadView('livewire.karyawan.export-pdf', [
            'data' => $data,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'totalEmployees' => $totalEmployees,
            'totalChickenCoops' => $totalChickenCoops,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "laporan-karyawan-{$bulan}-{$tahun}.pdf");
    }

    public function destroy($id)
    {
        $karyawan = User::findOrFail($id);
        $karyawan->delete();

        return redirect()->route('karyawan')->with('success', 'Data karyawan berhasil dihapus.');
    }


    #[Title('Karyawan')] 
    public function render()
    {
        return view('livewire.pages.karyawan-main',[
            'totalEmployees' => $this->user,
            'totalChickenCoops' => $this->kandang,
        ])->layout('layouts.app');
    }
}
