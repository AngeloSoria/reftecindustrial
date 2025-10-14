<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visit;

class VisitController extends Controller
{
    public function track(Request $request)
    {
        $visitorId = $request->cookie('visitor_id');

        if (!$visitorId) {
            // Generate unique visitor ID
            $visitorId = uniqid('v_', true);

            // Save to DB if not exists
            Visit::firstOrCreate(['visitor_id' => $visitorId, 'ip_address' => $request->input('ip'), 'country' => $request->input('country')]);
        }

        $response = response()->json([
            'total_visits' => Visit::count(),
        ]);

        // Store the visitor ID for 30 days
        return $response->cookie('visitor_id', $visitorId, 60 * 24 * 30);
    }

    public function getTotalVisits()
    {
        return response()->json(['total_visits' => Visit::count()]);
    }

    public function getTotalVisitsThisMonth()
    {
        $start = now()->startOfMonth();
        $end   = now()->endOfMonth();
        $result = Visit::whereBetween('visited_at', [$start, $end])->count();
        return response()->json(['this_month_result' => $result]);
    }

    public static function getTotalVisitsThisMonthValue()
    {
        $start = now()->startOfMonth();
        $end   = now()->endOfMonth();

        return Visit::whereBetween('visited_at', [$start, $end])->count();
    }

    public static function getTotalVisitsLastMonthValue()
    {
        return Visit::whereBetween('visited_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])->count();
    }

    public static function getTotalVisitsTodayValue()
    {
        return Visit::whereDate('visited_at', now()->toDateString())->count();
    }

    public static function getTotalVisitsThisWeekValue()
    {
        return Visit::whereBetween('visited_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
    }

    public function getVisitsByCountryThisMonth()
    {
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();

        $visits = Visit::select('country')
            ->whereBetween('visited_at', [$start, $end])
            ->selectRaw('COUNT(*) as total')
            ->groupBy('country')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return response()->json($visits);
    }

    public function getDataForWidgetCounter()
    {
        $visitsThisMonth = self::getTotalVisitsThisMonthValue();
        $visitsFromLastMonth = self::getTotalVisitsLastMonthValue();
        $visitsChangeFromLastMonth = $visitsThisMonth - $visitsFromLastMonth;

        if ($visitsFromLastMonth > 0) {
            $visitChangeRatio = round(($visitsChangeFromLastMonth / $visitsFromLastMonth) * 100, 2);
        } else {
            // If last month = 0
            $visitChangeRatio = $visitsThisMonth > 0 ? 100 : 0;
        }

        // Determine ratio type
        if ($visitsFromLastMonth === 0 && $visitsThisMonth === 0) {
            $visitsRatioType = 'null'; // no data at all
        } elseif ($visitsThisMonth > $visitsFromLastMonth) {
            $visitsRatioType = 'increase';
        } elseif ($visitsThisMonth < $visitsFromLastMonth) {
            $visitsRatioType = 'decrease';
        } else {
            $visitsRatioType = 'neutral'; // same value
        }

        return response()->json([
            'counter' => $visitsThisMonth,
            'change' => $visitsChangeFromLastMonth,
            'ratio' => $visitChangeRatio,
            'ratioType' => $visitsRatioType,
        ]);
    }
}
