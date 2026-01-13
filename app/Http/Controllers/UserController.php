<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function addUser(Request $request)
    {
        try {
            // NOTE: You can only create Super Admin if your'e also a super admin.
            // dd($request);
            $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:100'
                ],
                'role' => [
                    'required',
                    'string',
                    Rule::in(['Super Admin', 'Admin'])
                ],
                'username' => [
                    'required',
                    'string',
                    'max:50',
                    'alpha_dash',
                    'unique:users,username',
                ],
                'password' => [
                    'required',
                    Password::min(8)->letters()->numbers()->symbols(),
                    'confirmed'
                ]
            ]);

            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => $request->password,
                'role' => $request->role
            ]);
            actLog('create', 'Registered a user', 'A user ' . $request->username . ' (' . $request->role . ') has been registered.');
            toast('A user ' . $request->username . ' (' . $request->role . ') has been registered.', 'success');
            return back();
        } catch (Exception $e) {
            Logger()->error($e->getMessage());
            toast($e->getMessage(), 'error');
            return back();
        }
    }

    public function removeUser(Request $request)
    {
        try {

            $request->validate([
                'id' => [
                    'required',
                    'exists:users,id'
                ],
            ]);

            $sender = $request->user();
            $user = User::findOrFail($request->id);

            if ($user->id === $sender->id) {
                throw new Exception("You can't delete your own user data.");
            }

            if ($user->role === 'Super Admin' && $sender->role !== 'Super Admin') {
                abort(406, "You don't have a higher role access to delete this user. Error(406)");
            }

            $user->deleteOrFail();

            actLog('delete', 'Deleted a user', 'User '. $user->name . ' has been deleted (archived)');
            toast('User has been removed.', 'success');
            return back();
        } catch (Exception $e) {
            Logger()->error($e->getMessage());
            toast($e->getMessage(), 'error');
            return back();
        }
    }

    public function archiveUser(Request $request)
    {
        try {

            $request->validate([
                'id' => [
                    'required',
                    'exists:users,id'
                ],
            ]);

            $sender = $request->user();
            $user = User::findOrFail($request->id);

            if ($user->id === $sender->id) {
                throw new Exception("You can't archive your own user data.");
            }

            if ($user->role === 'Super Admin' && $sender->role !== 'Super Admin') {
                abort(406, "You don't have a higher role access to delete this user. Error(406)");
            }

            $user->updateOrFail([
                'archived' => 1
            ]);

            actLog('delete', 'Deactivated a user', 'User '. $user->name . ' has been deactivated');
            toast('User has been deactivated.', 'success');
            return back();
        } catch (Exception $e) {
            Logger()->error($e->getMessage());
            toast($e->getMessage(), 'error');
            return back();
        }
    }

    public function updateUser(Request $request)
    {
        try {
            dd($request);
            $request->validate([
                'id' => [
                    'required',
                    'exists:users,id'
                ],
                'role' => [
                    'required',
                    'string',
                    Rule::in(['Super Admin', 'Admin']),
                ],
                'username' => [
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('users', 'username')->ignore($request->id),
                ],
                'password' => [
                    'nullable',
                    Password::min(8)->letters()->numbers()->symbols(),
                    'confirmed',
                ],
                'archived' => [
                    'nullable',
                ]
            ]);

            // dd($request);

            $sender = $request->user();
            $user   = User::findOrFail($request->id);

            // Prevent lower roles from modifying Super Admin
            if ($user->role === 'Super Admin' && $sender->role !== 'Super Admin') {
                abort(403, "You don't have sufficient access to update this user.");
            }

            // Prevent role escalation
            if ($request->role === 'Super Admin' && $sender->role !== 'Super Admin') {
                abort(403, "You cannot assign Super Admin role.");
            }

            // Build update payload
            $blueprint = [
                'username' => $request->username,
                'role'     => $request->role,
            ];

            if ($request->filled('archived')) {
                if ($sender->id === $user->id && $request->archived === "true") {
                    throw new Exception('You cannot suspend yourself.');
                }
                $blueprint['archived'] = $request->archived === "true" ? 1 : 0;
            }

            // Only touch password if provided
            if ($request->filled('password')) {
                $blueprint['password'] = $request->password;
            }

            // dd($request, $blueprint);
            $user->update($blueprint);
            actLog('update', 'Updated a user', 'A user has been updated its data.');
            toast('User data has been updated successfully.', 'success');
            return back();
        } catch (Exception $e) {
            Logger()->error($e->getMessage());
            toast('Failed to update user: ' . $e->getMessage(), 'error');
            return back();
        }
    }

    public function getAllUsers(Request $request)
    {
        try {

            $query = User::select(['id', 'name', 'username', 'role', 'archived']);

            $filtersMap = [
                'role' => 'role',
                'archived' => 'archived'
            ];

            foreach ($filtersMap as $requestKey => $dbColumn) {
                if ($request->filled($requestKey)) {
                    $query->where($dbColumn, $request->input($requestKey));
                }
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->when($search, function ($q) use ($search) {
                    $q->where(function ($sub) use ($search) {
                        $sub->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('username', 'LIKE', "%{$search}%");
                    });
                });
            }

            $users = $query->latest()->paginate(15);

            // actLog('read', 'Retrieved all users', 'All users retrieved .');

            return response()->json([
                'success' => true,
                'data' => $users
            ]);
        } catch (Exception $e) {
            Logger()->error($e->getMessage());
            toast($e->getMessage(), 'error');
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
