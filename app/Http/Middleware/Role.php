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
        if ($user['id'] != 1 &&
            (($request->routeIs('dashboard') && !$user->canAccess(RoleModel::PERMISSION_DASHBOARD))
            || ($request->routeIs('locations.*') && !$user->canAccess(RoleModel::PERMISSION_LOCATIONS))
            || ($request->routeIs('members.*') && !$user->canAccess(RoleModel::PERMISSION_MEMBERS))
            || ($request->routeIs('activity.*') && !$user->canAccess(RoleModel::PERMISSION_ACTIVITY))
            || ($request->routeIs('invoices.*') && !$user->canAccess(RoleModel::PERMISSION_INVOICES))
            || ($request->routeIs('users.*') && !$user->canAccess(RoleModel::PERMISSION_USERS))
            || ($request->routeIs('settings.*') && !$user->canAccess(RoleModel::PERMISSION_SETTINGS)))
        ) {
            return redirect()->route('profile.edit');
        }
        return $next($request);
    }
}
