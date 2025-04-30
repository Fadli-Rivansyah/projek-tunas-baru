<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\Pakan;

class CountFeed {
    public static function getTotalFeed()
    {
        return Cache::remember('total_feed', 300, function() {
            $pakan = Pakan::latest()->first();
            return [
                'jagung' => $pakan->jumlah_jagung ?? 0,
                'multivitamin' => $pakan->jumlah_multivitamin ?? 0,
            ];
        });
    }
}