<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class LogoutIfArchived
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->archived) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors([
                    'login_request' => 'Your account has been suspended.',
                ]);
        }

        return $next($request);
    }
}
