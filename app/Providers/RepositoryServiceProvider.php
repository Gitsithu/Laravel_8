<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repository\Order\OrderRepositoryInterface', 'App\Repository\Order\OrderRepository');
        $this->app->bind('App\Repository\Order_detail\OrderDetailRepositoryInterface', 'App\Repository\Order_detail\OrderDetailRepository');
        $this->app->bind('App\Repository\Log\LogRepositoryInterface', 'App\Repository\Log\LogRepository');
    }
}
