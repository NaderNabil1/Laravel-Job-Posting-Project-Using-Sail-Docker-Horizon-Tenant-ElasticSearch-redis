<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use App\Services\TenantManager;
use Illuminate\Console\Command;

class TenantMigrate extends Command
{
    protected $signature = 'tenant:migrate';
    public function handle(\App\Services\TenantManager $tenants)
    {
        foreach (\App\Models\Tenant::cursor() as $tenant) {
            $this->info("Migrating tenant: {$tenant->slug}");
            $tenants->setTenant($tenant);
            $this->call('migrate', [
                '--path' => 'database/migrations/tenant',
                '--database' => 'tenant',
                '--force' => true,
            ]);
        }
        return self::SUCCESS;
    }
}
