<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthCheck
{
    public function handle($request, Closure $next)
    {
        // ✅ Kontrollo nëse është logged in në ndonjë guard
        if (!Auth::guard('company')->check() && !Auth::guard('employee')->check()) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}