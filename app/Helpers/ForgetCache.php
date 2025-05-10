<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\Telur;

class ForgetCache {
    public static function getForgetCacheChickens($kandangId, $bulan, $tahun)
    {
        $keys = [
            "kandang_{$kandangId}_total_liveChicken",
            "kandang_{$kandangId}_total_deadChicken",
            "kandang_{$kandangId}_total_chickenAge",
            "all_chickenInCage",
            "total_chickenIn_cage",
            "kandang_{$kandangId}_chicken_{$bulan}_{$tahun}",
            "summary_activities_employees",
            "kandang_{$kandangId}_count_persentase_chicken_dashboard",
        ];
    
        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }

    public static function getForgetCacheEggs($kandangId, $bulan, $tahun)
    {
        $latestTanggal = Telur::orderByDesc('tanggal')->value('tanggal');
        $latestDate = Carbon::parse($latestTanggal);

        $startLastMonth = $latestDate->copy()->subMonth()->startOfMonth();
        $endLastMonth = $latestDate->copy()->subMonth()->endOfMonth();
        $nameMonth = $startLastMonth->format('m');

         $keys = [
            "kandang_{$kandangId}_monthly_{$bulan}_{$tahun}_eggs",
            "kandang_{$kandangId}_lastMonth_{$nameMonth}_good_eggs",
            "kandang_{$kandangId}_thisMonth_{$nameMonth}_good_eggs",
            "kandang_{$kandangId}_totalEggsInTheCage_{$bulan}_{$tahun}_eggs",
            "kandang_{$kandangId}_monthly_goodEggs_dashboard",
            "kandang_{$kandangId}_monthly_crakedEggs_dashboard",
            "kandang_{$kandangId}_eggs_{$bulan}_{$tahun}",
            "kandang_{$kandangId}_eggs_{$bulan}_{$tahun}_export",
            "summary_activities_employees",
        ];

        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }

    public static function getForgetCacheEmployees($name)
    {
        $employee = [
            "user_{$name}_employee",
            "total_employees",
            "total_employees_export",
            "summary_activities_employees",
        ];
    
        foreach ($employee as $key) {
            Cache::forget($key);
        }
    }

    public static function getForgetCacheFeeds($bulan, $tahun)
    {
        $keys = [
            "total_feed_corn&multivitamin",
            "total_all_feed_{$bulan}_{$tahun}",
            "total_allMonthly_feeds_{$bulan}_{$tahun}",
        ];
    
        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }

    public static function getForgetCacheCage()
    {
        Cache::forget("kandang_user_karyawan");
    }

}