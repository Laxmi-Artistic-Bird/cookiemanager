<?php

namespace Artisticbird\Cookies;


use Artisticbird\Cookies\Console\Commands\GetUserdetail;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Session;

class CookiesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                GetUserdetail::class,
            ]);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views','addCookiesClient');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');

    }
}
