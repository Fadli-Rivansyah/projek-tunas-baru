<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\User;

class EmployeesCache 
{
    public static function getUserEmployee($name)
    {
        return Cache::remember("user_{$name}_employee", 300, function() use ($name){
            return User::where('name', $name)
                        ->with(['kandang.ayam', 'kandang.telur'])
                        ->first();
        });
    }

    public static function getTotalEmployees(){
        return Cache::remember("total_employees", 300, function() {
            return User::where('is_admin', false)->count();
        });
    }

    public static function getEmployeesExport($tahun, $bulan){
        return Cache::remember("total_employees_export", 300, function() use ($tahun, $bulan) {
            $start = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth()->toDateString();
            $end = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth()->toDateString();
            return User::where('is_admin', false)
                    ->whereBetween('created_at', [$start, $end])
                    ->get();
        });
    }

    public static function getUserRelations($name, $start, $end)
    {
        return Cache::remember("user_relations_{$name}", 300, function() use ($name, $start, $end) {
            $user = User::where('name', $name)
                ->with(['kandang.ayam' => function($query) use ($start, $end) {
                    $query->whereBetween('tanggal', [$start, $end]);
                }, 'kandang.telur' => function($query)  use ($start, $end){
                    $query->whereBetween('tanggal', [$start, $end]);
                }])->first();

            $data = [];

            // Cek jika data user ada
            $kandang = $user->kandang;

            if ($kandang) {
                $dataAyam = $kandang->ayam()
                    ->whereBetween('tanggal', [$start, $end])
                    ->get()
                    ->groupBy('tanggal');
        
                $dataTelur = $kandang->telur()
                    ->whereBetween('tanggal', [$start, $end])
                    ->get()
                    ->groupBy('tanggal');

                $allDates = collect($dataAyam->keys())
                    ->merge($dataTelur->keys())
                    ->unique()
                    ->sort();
            
                // Gabungkan berdasarkan tanggal
                foreach ($allDates as $tanggal) {
                    $ayamHariIni = $dataAyam->get($tanggal)?->first(); // kalau 1 data per tanggal
                    $telurHariIni = $dataTelur->get($tanggal)?->first();
            
                    $data[] = [
                        'tanggal' => $tanggal,
                        'liveChickens' => $ayamHariIni->total_ayam ?? 0,
                        'deadChickens' => $ayamHariIni->jumlah_ayam_mati ?? 0,
                        'productionEggs' => $telurHariIni->jumlah_telur_bagus ?? 0,
                        'crackedEggs' => $telurHariIni->jumlah_telur_retak ?? 0,
                        'feedChickens' => $ayamHariIni->jumlah_pakan ?? 0,
                    ];
                }
            }
            return $data;
        });
    }

    public static function getEmployeesActivites()
    {
        return Cache::remember("summary_activities_employees", 300, function()  {
            $users = User::where('is_admin', false)
            ->with(['kandang.ayam', 'kandang.telur'])->paginate(5);

            $data = [];

            foreach ($users as $user) {
                $kandang = $user->kandang;
                $ayamMati = 0;
                if ($kandang && $kandang->ayam) {
                    $ayamMati = $kandang->ayam
                        ->where('kandang_id', $kandang->id)
                        ->sum('jumlah_ayam_mati');
                }

                $totalAyam = $kandang?->jumlah_ayam - $ayamMati ?? 0;
            
                $eggs = 0;
                if ($kandang && $kandang->telur) {
                    $eggs = $kandang->telur
                        ->where('kandang_id', $kandang->id)
                        ->sum('jumlah_telur_bagus');
                }
                        
                $data[] = [
                        'name' => $kandang?->nama_karyawan ?? '-',
                        'chickenCoop' => $kandang?->nama_kandang ?? '-',
                        'totalChicken' => $totalAyam ?? 0,
                        'deadChicken' => $ayamMati,
                        'eggs' => $eggs,
                    ];
                }
                return $data;
            });
    }

  
}