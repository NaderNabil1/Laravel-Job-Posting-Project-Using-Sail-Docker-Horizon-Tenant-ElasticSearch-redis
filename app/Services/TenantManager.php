<?php
namespace App\Services;

use App\Models\Tenant;
use Illuminate\Support\Facades\DB;

class TenantManager
{
    protected ?Tenant $tenant = null;

    public function setTenant(Tenant $tenant): void
    {
        $this->tenant = $tenant;

        config(['database.connections.tenant' => [
            'driver'   => 'mysql',
            'host'     => $tenant->db_host,
            'port'     => $tenant->db_port,
            'database' => $tenant->db_database,
            'username' => $tenant->db_username,
            'password' => $tenant->db_password,
            'charset'  => 'utf8mb4',
            'collation'=> 'utf8mb4_unicode_ci',
            'prefix'   => '',
            'strict'   => true,
        ]]);

        DB::purge('tenant');
        DB::reconnect('tenant');
    }

    public function current(): ?Tenant { return $this->tenant; }
}
