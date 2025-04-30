<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\Telur;

class CountEggs 
{
    public static function getMonthlyEggs($kandangId, $tahun, $bulan)
    {
        return Cache::remember("kandang_{$kandangId}_monthly_eggs", 300, function() use ($kandangId, $tahun, $bulan) {
            $start = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth()->toDateString();
            $end = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth()->toDateString();
            
            return Telur::where('kandang_id', $kandangId)
               ->whereBetween('tanggal', [$start, $end])->get();
        });
    }

    public static function getLastWeekGoodEggs($kandangId, $startLastWeek, $endLastWeek)
    {
        return Cache::remember("kandang_{$kandangId}_lastweek_good_eggs", 300, function() use ($kandangId, $startLastWeek, $endLastWeek) {
            return Telur::where('kandang_id', $kandangId)
            ->whereDate('tanggal', '>=', $startLastWeek)
            ->whereDate('tanggal', '<=', $endLastWeek)
            ->sum('jumlah_telur_bagus');
        });
    }

    public static function getThisWeekGoodEggs($kandangId, $startThisWeek, $endThisWeek)
    {
        return Cache::remember("kandang_{$kandangId}_thisweek_good_eggs", 300, function() use ($kandangId, $startThisWeek, $endThisWeek) {
            return Telur::where('kandang_id', $kandangId)
            ->whereDate('tanggal', '>=', $startThisWeek)
            ->whereDate('tanggal', '<=', $endThisWeek)
            ->sum('jumlah_telur_bagus');
        });
    }

    public static function getTotalEggInTheCage($kandangId, $tahun, $bulan)
    {
        return Cache::remember("kandang_{$kandangId}_totalEggsInTheCage_eggs", 300, function() use ($kandangId, $tahun, $bulan) {
            $start = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth()->toDateString();
            $end = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth()->toDateString();
            
            $eggs = Telur::where('kandang_id', $kandangId)
               ->whereBetween('tanggal', [$start, $end])->get();

            return $eggs->sum('jumlah_telur_bagus') + $eggs->sum('jumlah_telur_retak');
        });
    }







}