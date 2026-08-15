<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckCompany
{
    public function handle($request, Closure $next)
    {
        // ✅ Kontrollo nëse është logged in si Company
        if (!Auth::guard('company')->check()) {
            abort(403);
        }

        return $next($request);
    }
}