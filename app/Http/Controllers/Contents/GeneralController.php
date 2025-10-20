<?php

namespace App\Http\Controllers\Contents;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contents\General;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\UploadController;

class GeneralController extends Controller
{

    // CREATE | POST
    public function setHeroSection(Request $request)
    {
        try {
            $uploadController = new UploadController();
            $uploadResponse = $uploadController->upload($request); // Call directly

            // Get the data as array if it's a JsonResponse
            $data = $uploadResponse->getData(true);

            if(!$data || !$data['success']) {
                throw new Exception($data['message']);
            }

            Log::info($data);

            General::updateOrCreate(['section' => 'hero'], [
                'image_path' => $data['files'][0]['path'] ?? null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Hero section updated.',
                'type' => 'success',
            ]);

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    // READ | GET
    public function getHeroSection(Request $request)
    {
        try {
            $response = General::where('section', 'hero')->first("image_path");
            return response()->json($response);
        } catch (Exception $e) {
            return redirect()->back()->with('toast', [
                'message' => $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    // UPDATE | POST

    // DELETE | POST

}
