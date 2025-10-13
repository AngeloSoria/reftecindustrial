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
}
