<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showForm()
    {
        if (Auth::check()) {
            return redirect()->intended(route('dashboard'));
        }
        return view('auth.login');
    }

    public function submit(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],  // validate as string
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->filled('remember_me'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        // Return one error message only
        return back()->withErrors([
            'login_request' => 'Invalid username or password.',
        ])->onlyInput('username');
    }
}
