<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckCompany
{
    public function handle($request, Closure $next)
{
    if (!Auth::guard('company')->check()) {
        abort(403, 'Only companies can manage employees');
    }

    return $next($request);
}
}