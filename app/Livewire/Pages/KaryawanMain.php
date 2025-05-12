<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\User;
use App\Models\Ayam;
use App\Models\Telur;
use App\Models\Kandang;
use Carbon\Carbon;
use Livewire\Attributes\Title;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Cache;
use App\Helpers\EmployeesCache;
use App\Helpers\ChickensCache;
use App\Helpers\EggsCache;
use App\Helpers\ForgetCache;

class KaryawanMain extends Component
{
    public $search='';
    public $user, $kandang;
    public $tahun, $bulan;

    public function mount()
    {
        // cache
        $this->user = EmployeesCache::getTotalEmployees();
        $this->kandang = ChickensCache::getTotalChickenInCage();
        
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
            ->paginate(7);
    }
    // export to pdf
    public function exportPdf()
    {
        // data from method getSearchKaryawanProperty();
        $data = EmployeesCache::getEmployeesExport($this->tahun, $this->bulan);
        // helper month
        $bulan = nama_bulan($this->bulan);
        $tahun = $this->tahun;
        $totalEmployees = $data->count();
        $totalChickenCoops =  $this->kandang;
        
        $pdf = Pdf::loadView('livewire.admin.karyawan.export-pdf', [
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
        $karyawan = User::with(['kandang','ayam', 'telur'])->findOrFail($id);

        $karyawan->ayam()->delete();
        ForgetCache::getForgetCacheChickens($id, $this->bulan, $this->tahun);

        $karyawan->telur()->delete();
        ForgetCache::getForgetCacheEggs($id, $this->bulan, $this->tahun);
        
        $karyawan->kandang()->delete();
        ForgetCache::getForgetCacheCage();
    
        ForgetCache::getForgetCacheEmployees($karyawan->name);
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
