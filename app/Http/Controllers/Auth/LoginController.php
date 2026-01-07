<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function showForm()
    {
        if (Auth::check()) {
            return redirect()->intended(route('dashboard'));
        }
        return view('login');
    }

    public function submit(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],  // validate as string
            'password' => ['required'],
        ]);

        // Fetch user by username only
        $user = User::where('username', $request->username)->first();

        // If user exists and is archived, block immediately
        if ($user && $user->archived) {
            return back()->withErrors([
                'login_request' => 'Your account has been suspended. Please contact the administrator.',
            ])->onlyInput('username');
        }

        // Check if user is suspended or not.
        $credentials['archived'] = 0;

        if (Auth::attempt($credentials, $request->filled('remember_me'))) {
            $request->session()->regenerate();
            actLog(null, 'User has logged in.', '');
            return redirect()->intended(route('dashboard'));
        }

        // Return one error message only
        return back()->withErrors([
            'login_request' => 'Invalid username or password.',
        ])->onlyInput('username');
    }
}
