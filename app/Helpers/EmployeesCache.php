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
                        'name' => $user->name?? '-',
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