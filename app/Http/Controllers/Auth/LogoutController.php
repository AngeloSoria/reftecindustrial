<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        // actually log them out
        Auth::logout();

        // invalidate the session
        $request->session()->invalidate();

        // regenerate CSRF token
        $request->session()->regenerateToken();

        // redirect based on role
        return redirect()->route('login');
    }
}
