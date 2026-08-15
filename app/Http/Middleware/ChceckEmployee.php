<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckEmployee
{
    public function handle($request, Closure $next)
    {
        // ✅ Kontrollo nëse është logged in si Employee
        if (!Auth::guard('employee')->check()) {
            abort(403);
        }

        return $next($request);
    }
}