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
    
}
