<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use App\Models\KonselingSession;
use App\Observers\KonselingSessionObserver;

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
        KonselingSession::observe(KonselingSessionObserver::class);

        if(env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    }
}
