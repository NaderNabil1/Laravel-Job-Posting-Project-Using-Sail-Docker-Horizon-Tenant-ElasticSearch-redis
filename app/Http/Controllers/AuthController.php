<?php

namespace App\Http\Controllers;

use App\Services\TenantManager;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request, TenantManager $tenants)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $tenant = $tenants->current();
        if (! $tenant) {
            return response()->json([
                'message' => 'Tenant not resolved. Provide X-Tenant header or use a tenant subdomain.',
            ], 400);
        }

        $user = User::where('tenant_id', $tenant->id)->where('email', $request->email)->first();

        if (! $user || ! \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 422);
        }

        $token = $user->createToken("tenant-{$tenant->slug}")->accessToken;

        return response()->json([
            'token'  => $token,
            'tenant' => $tenant->slug,
            'user'   => $user->only('id','name','email'),
        ]);
    }

}
