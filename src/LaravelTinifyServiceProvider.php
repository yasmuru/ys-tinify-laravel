<?php

namespace yasmuru\LaravelTinify;

use Illuminate\Support\ServiceProvider;
use yasmuru\LaravelTinify\Services\TinifyService;

class LaravelTinifyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot(): void
    {
        $configPath = __DIR__ . '/../config/tinify.php';
        
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $configPath => config_path('tinify.php')
            ], 'tinify-config');
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $configPath = __DIR__ . '/../config/tinify.php';
        $this->mergeConfigFrom($configPath, 'tinify');

        $this->app->singleton('tinify', function ($app) {
            return new TinifyService();
        });
    }
}