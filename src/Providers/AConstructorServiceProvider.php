<?php

namespace Nieeonliv\AConstructor\Providers;

use Illuminate\Support\ServiceProvider;
class AConstructorServiceProvider extends ServiceProvider
{
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
        $this->loadRoutesFrom(__DIR__.'/../Routes/api.php');
    }
}
