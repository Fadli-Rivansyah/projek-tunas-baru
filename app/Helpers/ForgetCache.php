<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class ForgetCache {
    public static function getForgetCacheChikens($kandangId, $bulan, $tahun)
    {
        Cache::forget("kandang_{$kandangId}_total_liveChicken");
        Cache::forget("kandang_{$kandangId}_total_deadChicken");
        Cache::forget("kandang_{$kandangId}_total_chickenAge");
        Cache::forget("all_chickenInCage");
        Cache::forget("total_chickenIn_cage");
        Cache::forget("kandang_{$kandangId}_chicken_{$bulan}_{$tahun}");
        Cache::forget("summary_activities_employees");
        Cache::forget("kandang_{$kandangId}_count_persentase_chicken_dashboard");
    }

    public static function getForgetCacheEggs($kandangId, $bulan, $tahun)
    {
        Cache::forget("kandang_{$kandangId}_monthly_{$bulan}_{$tahun}_eggs");
        Cache::forget("kandang_{$kandangId}_lastweek_good_eggs");
        Cache::forget("kandang_{$kandangId}_thisweek_good_eggs");
        Cache::forget("kandang_{$kandangId}_totalEggsInTheCage_{$bulan}_{$tahun}_eggs");
        Cache::forget("kandang_{$kandangId}_monthly_goodEggs_dashboard");
        Cache::forget("kandang_{$kandangId}_monthly_crakedEggs_dashboard");
        Cache::forget("kandang_{$kandangId}_eggs_{$bulan}_{$tahun}");
    }

    public static function getForgetCacheEmployees($name)
    {
        Cache::forget("user_{$name}_employe");
        Cache::forget("total_employees");
        Cache::forget("total_employees_export");
        Cache::forget("user_relations_{$name}");
        Cache::forget("summary_activities_employees");
    }

    public static function getForgetCacheFeeds($bulan, $tahun)
    {
        Cache::forget("total_feed");
        Cache::forget("total_all_feed");
        Cache::forget("total_all_feeds_{$bulan}_{$tahun}");
    }

    public static function getForgetCacheCage()
    {
        Cache::forget("kandang_user_karyawan");

    }

}