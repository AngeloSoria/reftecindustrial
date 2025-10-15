<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;
use MonishRoy\VisitorTracking\Helpers\Visitor as VisitorTrackingHelper;

class VisitorController extends Controller
{
    public function getTotalVisitors()
    {
        return response()->json(['total_visitors' => VisitorTrackingHelper::totalVisitors()]);
    }

    public function getUniqueVisitors()
    {
        return response()->json(['unique_visitors' => VisitorTrackingHelper::uniqueVisitors()]);
    }

    public function getTopVisitedPages($limit = 5)
    {
        return response()->json(['top_visited_pages' => VisitorTrackingHelper::topVisitedPages($limit)]);
    }

    public function getCountries()
    {
        return response()->json(['countries' => VisitorTrackingHelper::countries()]);
    }

    public function getOs()
    {
        return response()->json(['os' => VisitorTrackingHelper::os()]);
    }

    public function getDevices()
    {
        return response()->json(['devices' => VisitorTrackingHelper::devices()]);
    }

    public function getVisitsByCountryThisMonth()
    {
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();

        $visits = Visitor::select('country')
            ->whereBetween('visited_at', [$start, $end])
            ->selectRaw('COUNT(*) as total')
            ->groupBy('country')
            ->orderByDesc('total')
            ->limit(10)
            ->get();


        return response()->json($visits);
    }

    public function getTotalVisitsThisMonthValue()
    {
        $start = now()->startOfMonth();
        $end   = now()->endOfMonth();

        return Visitor::whereBetween('visited_at', [$start, $end])->count();
    }

    public static function getTotalVisitsLastMonthValue()
    {
        return Visitor::whereBetween('visited_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])->count();
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
