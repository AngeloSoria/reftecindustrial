<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use App\Models\Logs as ActivityLogs;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function create($action = null, $activity, $details)
    {
        try {
            // Get user
            $user = Auth::user();

            $blueprint = [
                'action' => $action,
                'activity' => $activity,
                'user' => $user->name . ' (' . $user->role . ')',
                'details' => $details
            ];

            ActivityLogs::create($blueprint);
        } catch (Exception $e) {
            Logger()->error($e->getMessage());
        }
    }

    public function getAll(Request $request)
    {
        try {
            // dd($request);
            $query = ActivityLogs::select([
                'action',
                'activity',
                'user',
                'details',
                'created_at'
            ]);

            // Exact filters
            if ($request->filled('action')) {
                $query->where('action', $request->action);
            }

            // Date filter
            if ($request->filled('datetime')) {
                $dt = Carbon::parse($request->datetime);

                $query->whereBetween('created_at', [
                    $dt->startOfMinute(),
                    $dt->endOfMinute(),
                ]);
            }

            // Search
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('user', 'LIKE', "%{$search}%")
                        ->orWhere('activity', 'LIKE', "%{$search}%")
                        ->orWhere('details', 'LIKE', "%{$search}%");
                });
            }

            $logs = $query->latest()->paginate(20);

            return response()->json([
                'success' => true,
                'data' => $logs
            ]);
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch activity logs'
            ], 500);
        }
    }
}
