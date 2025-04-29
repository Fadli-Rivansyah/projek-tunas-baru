<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ayam;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ReportAyamController extends Controller
{
    public $kandang;
    
    public function mount($name)
    {
        $user = User::where('name', $name);
        $kandang = $user->kandang;

        $this->kandang = $kandang;
    }

    public function exportPdf()
    {
        $start = now()->copy()->startOfMonth(); // 2025-04-01
        $end = now()->copy()->endOfMonth(); 

        $data = Ayam::where('kandang_id', $this->kandang?->id)
            ->whereBetween('tanggal', [$start, $end])->get();

        $pdf = Pdf::loadView('report.export-pdf', [
            'data' => $data,
        ]);

         return $pdf->stream('laporan-ayam.pdf');
    }
}
