<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\Telur;

class EggsCache 
{
    public static function getMonthlyEggs($kandangId, $tahun, $bulan)
    {
        return Cache::remember("kandang_{$kandangId}_monthly_{$bulan}_{$tahun}_eggs", 300, function() use ($kandangId, $tahun, $bulan) {
            $start = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth()->toDateString();
            $end = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth()->toDateString();
            
            return Telur::where('kandang_id', $kandangId)
               ->whereBetween('tanggal', [$start, $end])->get();
        });
    }

    public static function getLastMonthGoodEggs($kandangId, $latestDate)
    {
        $startLastMonth = $latestDate->copy()->subMonth()->startOfMonth();
        $endLastMonth = $latestDate->copy()->subMonth()->endOfMonth();
        $nameMonth = $startLastMonth->format('m');

        return Cache::remember("kandang_{$kandangId}_lastMonth_{$nameMonth}_good_eggs", 300, function() use ($kandangId, $startLastMonth, $endLastMonth) {
            return Telur::where('kandang_id', $kandangId)
            ->whereBetween('tanggal', [$startLastMonth, $endLastMonth])
            ->sum('jumlah_telur_bagus');
        });
    }

    public static function getThisMonthGoodEggs($kandangId, $latestDate)
    {
        $startOfThisMonth = $latestDate->copy()->startOfMonth();
        $endOfThisMonth = $latestDate->copy()->endOfMonth();
        $nameMonth = $startOfThisMonth->format('m');

        return Cache::remember("kandang_{$kandangId}_thisMonth_{$nameMonth}_good_eggs", 300, function() use ($kandangId, $startOfThisMonth, $endOfThisMonth) {
            return Telur::where('kandang_id', $kandangId)
            ->whereBetween('tanggal',  [$startOfThisMonth, $endOfThisMonth])
            ->sum('jumlah_telur_bagus');
        });
    }

    public static function getTotalEggInTheCage($kandangId, $tahun, $bulan)
    {
        return Cache::remember("kandang_{$kandangId}_totalEggsInTheCage_{$bulan}_{$tahun}_eggs", 300, function() use ($kandangId, $tahun, $bulan) {   
            $eggs = self::getMonthlyEggs($kandangId, $tahun, $bulan);
            return $eggs->sum('jumlah_telur_bagus') + $eggs->sum('jumlah_telur_retak');
        });
    }
    public static function getGoodEggMonthly($kandangId)
    {
        return Cache::remember("kandang_{$kandangId}_monthly_goodEggs_dashboard", 300, function() use ($kandangId) {
            return Telur::where('kandang_id', $kandangId)->whereYear('tanggal', now()->year)
                   ->selectRaw('MONTH(tanggal) as bulan, SUM(jumlah_telur_bagus) as total')->groupBy('bulan')->orderBy('bulan')
                   ->pluck('total', 'bulan');
        });
    }

    public static function getCrackedEggMontly($kandangId)
    {
        return Cache::remember("kandang_{$kandangId}_monthly_crakedEggs_dashboard", 300, function() use ($kandangId){
            return Telur::where('kandang_id', $kandangId)
                    ->whereYear('tanggal', now()->year)
                    ->selectRaw('MONTH(tanggal) as bulan, SUM(jumlah_telur_retak) as total')->groupBy('bulan')->orderBy('bulan')
                    ->pluck('total', 'bulan');
        });
    }

    public static function getTableEggs($kandangId, $tahun, $bulan)
    {
         return Cache::remember("kandang_{$kandangId}_eggs_{$bulan}_{$tahun}", 300, function() use ($kandangId, $tahun, $bulan) {
            $start = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth()->toDateString();
            $end = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth()->toDateString();
         
            return Telur::where('kandang_id', $kandangId)
            ->whereBetween('tanggal', [$start, $end])
            ->paginate(10);
        });
    }







}