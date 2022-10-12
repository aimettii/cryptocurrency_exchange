<?php

namespace App\Providers;

use App\Services\BlockchainAPI\BlockchainAPIService;
use App\Services\CoingeckoAPI\CoingeckoAPIService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(BlockchainAPIService::class, function ($app) {
            return new BlockchainAPIService(new \GuzzleHttp\Client());
        });

        $this->app->singleton(CoingeckoAPIService::class, function ($app) {
            return new CoingeckoAPIService(new \GuzzleHttp\Client());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
