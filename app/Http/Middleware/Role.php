<?php

namespace App\Http\Middleware;

use App\Models\Role as RoleModel;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $permissions = explode(',', $user['role']['permissions'] ?? '');
        if ($user['id'] != 1 &&
            (($request->routeIs('dashboard') && !in_array(RoleModel::PERMISSION_DASHBOARD, $permissions))
            || ($request->routeIs('locations.*') && !in_array(RoleModel::PERMISSION_LOCATIONS, $permissions))
            || ($request->routeIs('members.*') && !in_array(RoleModel::PERMISSION_MEMBERS, $permissions))
            || ($request->routeIs('activity.*') && !in_array(RoleModel::PERMISSION_ACTIVITY, $permissions))
            || ($request->routeIs('invoices.*') && !in_array(RoleModel::PERMISSION_INVOICES, $permissions))
            || ($request->routeIs('users.*') && !in_array(RoleModel::PERMISSION_USERS, $permissions))
            || ($request->routeIs('settings.*') && !in_array(RoleModel::PERMISSION_SETTINGS, $permissions)))
        ) {
            return redirect()->route('profile.edit');
        }
        return $next($request);
    }
}
