<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <--- Asegúrate de agregar esto arriba

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
    // Forzar HTTPS si la URL contiene 'ngrok' o si estamos en producción
    if($this->app->environment('local') && str_contains(config('app.url'), 'ngrok')) {
        URL::forceScheme('https');
    }
}
}
