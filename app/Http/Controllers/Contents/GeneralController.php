<?php

namespace App\Http\Controllers\Contents;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contents\General;
use Illuminate\Support\Facades\Log;
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

            if (!$data || !$data['success']) {
                throw new Exception($data['message']);
            }

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

    public function setHistory(Request $request)
    {
        try {
            $request->validate([
                'context' => 'string',
                'data_history' => 'nullable|string',
                'file' => 'nullable|file|mimes:jpg,png,jpeg,bmp,gif,pdf,xlsx,docx|max:' . env('APP_MAX_UPLOAD_SIZE', 10240),
            ]);

            $context = $request->get('context');

            if (!$context) {
                throw new Exception("context value was missing.");
            }

            if ($context == 'content_text') {
                General::updateOrCreate(['section' => 'history'], [
                    'content' => $request->get('data_history')
                ]);

                return redirect()->back()->with('toast', [
                    'message' => 'History text saved successfully!',
                    'type' => 'success',
                ]);
            } elseif ($context == 'content_image') {
                $uploadController = new UploadController();
                $uploadResponse = $uploadController->upload($request); // Call directly

                // Get the data as array if it's a JsonResponse
                $data = $uploadResponse->getData(true);

                if (!$data || !$data['success']) {
                    throw new Exception($data['message']);
                }

                General::updateOrCreate(['section' => 'history'], [
                    'image_path' => $data['files'][0]['path'] ?? null
                ]);

                return redirect()->back()->with('toast', [
                    'message' => 'History image has been updated!',
                    'type' => 'success',
                ]);
            }
        } catch (Exception $e) {
            Log::error('Error saving history: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to save history: ' . $e->getMessage(),
                'type' => 'error',
            ], 500);
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

    public function getHistory(Request $request)
    {
        try {
            $response = General::where('section', 'history')->first(['content', 'image_path']);
            return response()->json($response);
        } catch (Exception $e) {
            Log::error('Error fetching history: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch history: ' . $e->getMessage(),
                'type' => 'error',
            ], 500);
        }
    }

    // UPDATE | POST

    // DELETE | POST

}
