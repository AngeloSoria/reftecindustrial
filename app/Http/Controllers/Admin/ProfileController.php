<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function show($id = null)
    {
        $user = $id ? User::findOrFail($id) : Auth::user();
        return view('auth.profile', compact('user'));
    }
}
