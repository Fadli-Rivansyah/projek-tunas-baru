<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kandang;

class KandangController extends Controller
{
    public function index()
    {
        $kandang = Kandang::where('user_id', auth()->id())->first();
        return view('kandang', [
            'kandang' => $kandang
        ]);
    }
    
    public function destroy($id)
    {
        $kandang = Kandang::findOrFail($id);
        $kandang->delete();

        return redirect()->route('kandang')->with('success', 'Data kandang berhasil dihapus!');
    }
}
