<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use App\Models\Logs as ActivityLogs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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
            $cacheKey = 'activity_logs:' . md5(json_encode([
                'action'   => $request->action,
                'datetime' => $request->datetime,
                'search'   => $request->search,
                'page'     => $request->get('page', 1),
            ]));

            $result = Cache::remember(
                $cacheKey,
                env('CACHE_EXPIRATION', 3600),
                function () use ($request) {

                    $query = ActivityLogs::select([
                        'action',
                        'activity',
                        'user',
                        'details',
                        'created_at'
                    ]);

                    if ($request->filled('action')) {
                        $query->where('action', $request->action);
                    }

                    if ($request->filled('datetime')) {
                        $dt = Carbon::parse($request->datetime);
                        $query->whereBetween('created_at', [
                            $dt->startOfMinute(),
                            $dt->endOfMinute(),
                        ]);
                    }

                    if ($request->filled('search')) {
                        $search = $request->search;
                        $query->where(function ($q) use ($search) {
                            $q->where('user', 'LIKE', "%{$search}%")
                                ->orWhere('activity', 'LIKE', "%{$search}%")
                                ->orWhere('details', 'LIKE', "%{$search}%");
                        });
                    }

                    return [
                        'success' => true,
                        'data' => $query->latest()->paginate(20)
                    ];
                }
            );

            return response()->json($result);
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch activity logs'
            ], 500);
        }
    }
}
