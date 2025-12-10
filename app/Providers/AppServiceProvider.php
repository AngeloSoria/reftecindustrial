<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Barryvdh\Debugbar\Facades\Debugbar;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (!app()->environment('local')) {
            return;
        }

        foreach (app()->getLoadedProviders() as $provider => $loaded) {
            Debugbar::startMeasure($provider, "Booting $provider");
            // You’re not re-registering it — just measuring
            Debugbar::stopMeasure($provider);
        }
    }
}
