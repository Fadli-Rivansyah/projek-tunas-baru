<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\Ayam;
use App\Models\User;
use App\Models\Kandang;

class ChickensCache 
{
    public static function getTotalLiveChicken($kandangId, $firstChicken)
    {
        return Cache::remember("kandang_{$kandangId}_total_liveChicken", 300, function() use ($kandangId, $firstChicken) {
            $deadChickens = self::getTotalDeadChicken($kandangId);
            return $firstChicken - $deadChickens; 
        });
    }

    public static function getTotalDeadChicken($kandangId)
    {
        return Cache::remember("kandang_{$kandangId}_total_deadChicken", 300, function() use ($kandangId) {
            return Ayam::where('kandang_id', $kandangId)->sum('jumlah_ayam_mati');
        });
    }

    public static function getTotalChickensAge($kandangId, $firstChickenAge, $baseAge)
    {
        return Cache::remember("kandang_{$kandangId}_total_chickenAge", 300, function() use ($kandangId, $firstChickenAge, $baseAge){
            if(!$firstChickenAge){
                return $baseAge;
            }
            $weekRange = Carbon::parse($firstChickenAge)->diffInWeeks(now());
            return round($weekRange) + $baseAge ;
        });
    }

    public static function getChickensInCage($start, $end)
    {
        return Cache::remember("all_chickenInCage", 300, function() use ($start, $end){
            $totalChickens = Ayam::all();

            $totalAllDead = $totalChickens->sum('jumlah_ayam_mati'); 
            $totalDeadChickensMonthly = $totalChickens->whereBetween('tanggal', [$start, $end])->sum('jumlah_ayam_mati');
            $chickenInCage = Kandang::sum('jumlah_ayam');
            
            $liveChickens = $chickenInCage - $totalAllDead;
    
           return [
                'deadChickens' => $totalDeadChickensMonthly,
                'liveChickens' => $liveChickens,
           ];
        });
    }

    public static function getTotalChickenInCage()
    {
        return Cache::remember("total_chickenIn_cage", 300, function() {
            return Kandang::count();
        });
    }

    public static function getMonthlyChickens($kandangId, $tahun, $bulan)
    {
        return Cache::remember("kandang_{$kandangId}_chicken_{$bulan}_{$tahun}", 300, function() use ($kandangId, $tahun, $bulan) {
            $start = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth()->toDateString();
            $end = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth()->toDateString();
         
            return Ayam::where('kandang_id', $kandangId)
            ->whereBetween('tanggal', [$start, $end])
            ->get();
        });
    }
}