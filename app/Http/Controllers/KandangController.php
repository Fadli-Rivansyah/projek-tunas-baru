<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KandangController extends Controller
{
    public function index()
    {
        return view('kandang');
    }
    
}
