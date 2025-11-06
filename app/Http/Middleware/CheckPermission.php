<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        // Super Admin সব অ্যাক্সেস পাবে
        if ($user->roles()->where('slug', 'super-admin')->exists()) {
            return $next($request);
        }

        $routeName = Route::currentRouteName();

        if (!$routeName) {
            return abort(403, 'Route name missing.');
        }

        $hasPermission = $user->roles()
            ->with('permissions')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('name')
            ->contains($routeName);

        if (!$hasPermission) {
            return abort(403, 'Unauthorized access to this section.');
        }

        return $next($request);
    }
}
