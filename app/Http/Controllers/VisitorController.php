<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;
use Exception;
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

    public function getVisitsByCountryThisMonth($unique = true)
    {
        try {
            $start = now()->startOfMonth();
            $end   = now()->endOfMonth();

            $countExpr = $unique
                ? 'COUNT(DISTINCT ip) as total'
                : 'COUNT(*) as total';

            $visits = Visitor::select('country')
                ->whereBetween('visited_at', [$start, $end])
                ->selectRaw($countExpr)
                ->groupBy('country')
                ->orderByDesc('total')
                ->limit(10)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $visits
            ]);
        } catch (Exception $e) {
            Logger()->error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    public function getTotalVisitsThisMonthValue($unique = false)
    {
        $start = now()->startOfMonth();
        $end   = now()->endOfMonth();

        $query = Visitor::whereBetween('visited_at', [$start, $end]);

        return $unique ? $query->count('ip') : $query->count();
    }

    public static function getTotalVisitsLastMonthValue($unique = false)
    {
        $start = now()->subMonth()->startOfMonth();
        $end = now()->subMonth()->endOfMonth();

        $query = Visitor::whereBetween('visited_at', [$start, $end]);

        return $unique ? $query->count('ip') : $query->count();
    }

    public function getDataForWidgetCounter()
    {
        try {
            $visitsThisMonth = self::getTotalVisitsThisMonthValue(true);
            $visitsFromLastMonth = self::getTotalVisitsLastMonthValue(true);
            $visitsChangeFromLastMonth = abs($visitsThisMonth - $visitsFromLastMonth);

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
                'success' => true,
                'data' => [
                    'counter' => $visitsThisMonth,
                    'change' => $visitsChangeFromLastMonth,
                    'ratio' => $visitChangeRatio,
                    'ratioType' => $visitsRatioType,
                ],
            ]);
        } catch (Exception $e) {
            Logger()->error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
