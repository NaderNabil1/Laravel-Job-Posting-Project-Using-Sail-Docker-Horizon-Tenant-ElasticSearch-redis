<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use App\Services\TenantManager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SetTenant
{
    public function __construct(protected TenantManager $tenants) {}

    public function handle(Request $request, Closure $next)
    {
        $slug = $request->header('X-Tenant');

        if (! $slug) {
            $host = $request->getHost();
            $parts = explode('.', $host);
            $slug = (count($parts) > 1) ? $parts[0] : null;
        }

        $tenant = $slug ? Tenant::where('slug', $slug)->first() : null;

        if (! $tenant) throw new NotFoundHttpException('Tenant not found');

        $this->tenants->setTenant($tenant);

        return $next($request);
    }
}
