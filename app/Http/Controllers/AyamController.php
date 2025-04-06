<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ayam;
use App\Models\Kandang;

class AyamController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $kandang = $user->kandang;

        $jumlahAyam = $kandang->jumlah_ayam;
        
        $dataAyam = $kandang->ayams;
        return view('ayam', [
            'ayam' => $dataAyam,
            'totalAyam' => $jumlahAyam
        ]);
    }

    public function destroy($id)
    {
        $ayam= Ayam::findOrFail($id);
        $ayam->delete();

        return redirect()->route('ayam')->with('success', 'Data ayam berhasil dihapus!');
    }
}
