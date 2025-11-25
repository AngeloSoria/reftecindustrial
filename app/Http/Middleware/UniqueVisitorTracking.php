<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use MonishRoy\VisitorTracking\Middleware\VisitorTracking as Visitor;
// use Monish\VisitorTracking\Models\Visitor as VisitorModel;
use Carbon\Carbon;

class UniqueVisitorTracking
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Skip tracking for AJAX or API requests
        if ($request->ajax() || $request->wantsJson()) {
            return $next($request);
        }

        // Do not track visits in local dev environment
        if (app()->environment('local')) {
            return $next($request);
        }

        // Option 1: Track once per session
        if (!session()->has('visitor_tracked')) {
            (new Visitor())->handle($request, $next);
            session(['visitor_tracked' => true]);
        }

        return $next($request);
    }
}

// 🧩 Option 2 (alternative): track once every 6 hours per IP
/*
$ip = $request->ip();

$recentVisit = VisitorModel::where('ip', $ip)
    ->where('created_at', '>', Carbon::now()->subHours(6))
    ->exists();

if (!$recentVisit) {
    (new Visitor())->logVisitor();
}
*/
