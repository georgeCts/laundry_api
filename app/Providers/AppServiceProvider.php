<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->share('_PAGE_TITLE', 'Miss Laundry');
        view()->share('_SYSTEM_NAME', 'Miss Laundry Panel'); 
        View()->share('_SYSTEM_FULL_NAME', 'Sistema de Administración Web');
        View()->share('_SYSTEM_DESCRIPTION', 'La forma fácil de administrar tu aplicación móvil.');
        View()->share('_SYSTEM_VERSION', 'v1.0');

        Carbon::setLocale(config('app.locale'));

        Schema::defaultStringLength(191);
    }
}
