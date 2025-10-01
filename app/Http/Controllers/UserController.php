<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Return paginated list of users
    public function getAllUsers($perPage = 10, $page = 1)
    {
        // Get 'perPage' from query string, default to 10 if not provided
        $perPage = min($perPage, 100); // max 100 per page

        // Fetch paginated users
        $users = User::paginate($perPage, ['*'], 'page', $page);

        return UserResource::collection($users);
    }

    // Return a single user by ID
    public function getUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        return new UserResource($user);
    }

    // Test
    public function test()
    {
        return response()->json([
            'message' => 'Hello World!'
        ]);
    }
}
