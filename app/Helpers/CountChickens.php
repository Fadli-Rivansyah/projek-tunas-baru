<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\Ayam;
use App\Models\Kandang;

class CountChickens 
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
            $totalDeadChickens = Ayam::with('kandang')->whereBetween('created_at', [$start, $end])->get()
            ;
    
            $firstChickens = $totalDeadChickens->kandang?->sum('jumlah_ayam');
    
            $liveChickens = $firstChickens - $totalDeadChickens->sum('jumlah_ayam_mati');
    
           return [
                'deadChickens' => $totalDeadChickens,
                'liveChickens' => $liveChickens,
           ];
        });
    }
}