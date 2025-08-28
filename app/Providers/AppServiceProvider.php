<?php

namespace App\Providers;

use App\Services\TenantManager;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(TenantManager::class);
    }

    public function boot(): void
    {
        Passport::loadKeysFrom('/var/www/passport_keys');
    }
}
