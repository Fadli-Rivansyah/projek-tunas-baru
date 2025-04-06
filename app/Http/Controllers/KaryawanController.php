<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class KaryawanController extends Controller
{
    public function index()
    {
        $users = User::with('kandang')->where('is_admin', 0)->paginate(10); 
        // $namaKandang = $users->kandang()->nama_kandang;
        // $tes = User::with('kandang')->kandang->nama_kandang;
    
        return view('karyawan',[
            'karyawan' => $users,
        ]);
    }

    public function destroy($id)
    {
        $karyawan = User::findOrFail($id);
        $karyawan->delete();

        return redirect()->route('karyawan')->with('success', 'Data karyawan berhasil dihapus!');
    }
}
