<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Active
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $type = null): Response
    {
        $user = $request->user();
        if (($type == 'member' && !in_array($user['status'], ['active', 'paused', 'suspended']))
            || (!$type && $user['status'] != 'active')
        ) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Your account has been deactivated.',
                ], 401);
            } else {
                if (!$type) {
                    auth()->logout();
                    return to_route('login');
                }
                auth('member')->logout();
                return to_route('member.login');
            }
        }
        return $next($request);
    }
}
