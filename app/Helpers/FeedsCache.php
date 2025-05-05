<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\Pakan;

class FeedsCache {
    public static function getTotalFeeds()
    {
        return Cache::remember("total_feed_corn&multivitamin", 300, function() {
            $pakan = Pakan::latest()->first();
            return [
                'jagung' => $pakan->jumlah_jagung ?? 0,
                'multivitamin' => $pakan->jumlah_multivitamin ?? 0,
            ];
        });
    }

    public static function getTotalAllFeeds($bulan, $tahun)
    {
        $start = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth()->toDateString();
        $end = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth()->toDateString();

        return Cache::remember("total_all_feed_{$bulan}_{$tahun}", 300, function() use ($start, $end) {
            $pakan = Pakan::whereBetween('tanggal', [$start, $end]);
            return $pakan->sum('total_pakan');
        });
    }

    public static function getMonthlyAllFeeds($bulan, $tahun)
    {
        $start = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth()->toDateString();
        $end = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth()->toDateString();    
        
        return Cache::remember("total_allMonthly_feeds_{$bulan}_{$tahun}", 300, function() use ($start, $end) {
            return Pakan::whereBetween('tanggal', [$start, $end])->paginate(5);
        });
    }
}