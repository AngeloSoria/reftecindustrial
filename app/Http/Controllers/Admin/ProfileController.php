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
        if ($id && !Auth::user()->is_admin) {
            abort(403);
        }

        $user = $id ? User::findOrFail($id) : Auth::user();
        return view('admin.profile', compact('user'));
    }
}
