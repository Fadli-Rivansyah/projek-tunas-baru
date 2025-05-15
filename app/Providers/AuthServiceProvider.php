<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Telur;
use App\Models\Ayam;
use App\Models\Kandang;
use Illuminate\Support\Facades\Gate;
use App\Policies\TelurPolicy;
use App\Policies\AyamPolicy;
use App\Policies\KandangPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Telur::class => TelurPolicy::class,
        Ayam::class => AyamPolicy::class,
        Kandang::class => kandangPolicy::class,
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::policy(Kandang::class, KandangPolicy::class);
        Gate::policy(Telur::class, TelurPolicy::class);
        Gate::policy(Ayam::class, AyamPolicy::class);
    }
}
