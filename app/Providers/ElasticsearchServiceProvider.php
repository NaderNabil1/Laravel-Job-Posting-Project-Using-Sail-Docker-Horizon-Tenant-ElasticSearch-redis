<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ElasticsearchServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Client::class, function () {
            return ClientBuilder::create()
                ->setHosts([config('elastic.host')])
                ->build();
        });
    }

    public function boot(): void
    {
        
    }
}
