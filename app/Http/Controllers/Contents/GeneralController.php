<?php

namespace App\Http\Controllers\Contents;

use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

use App\Models\Contents\General;
use App\Models\Contents\GeneralProductLines as ProductLines;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UploadController;


class GeneralController extends Controller
{

    // CREATE | POST
    public function addProductLine(Request $request)
    {
        try {

            // Normalize checkbox input before validation
            $request->merge([
                'visibility' => $request->has('visibility') ? 1 : 0,
            ]);

            $request->validate([
                'product_line_name' => 'string',
                'file' => 'file|mimes:jpg,png,jpeg,bmp,gif|max:' . env('APP_MAX_UPLOAD_SIZE', 10240), // Image only
                'visibility' => 'boolean'
            ]);

            Log::info($request);

            // upload
            $uploadController = new UploadController();
            $uploadResponse = $uploadController->upload($request); // Call directly

            // Get the data as array if it's a JsonResponse
            $data = $uploadResponse->getData(true);

            if (!$data || !$data['success']) {
                throw new Exception($data['message']);
            }

            // Check visibility
            $visible = $request->visibility ?? false;

            // Save to database.
            ProductLines::create([
                'name' => $request->product_line_name,
                'image_path' => $data['files'][0]['path'],
                'visibility' => $visible
            ]);

            // Clear cache for hero section after updating
            Cache::forget('section_product_lines');

            session()->flash('content', [
                'tab' => 'general',
                'section' => 'products'
            ]);

            return redirect(url()->previous())->with('toast', [
                'type' => 'success',
                'message' => 'New product line has been added.'
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('toast', [
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function test(Request $request)
    {
        try {
            // Log::info($request->product_line_name);
            throw new Exception($request->product_line_name);
            // return response()->json($request);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('toast', [
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    // READ | GET
    public function getHeroSection(Request $request)
    {
        try {
            $response = Cache::remember('section_hero', env('CACHE_EXPIRATION', 3600), function () {
                $record = General::where('section', 'hero')->first(['image_path']);

                return [
                    'success' => true,
                    'data' => [
                        'image' => $record && $record->image_path
                            ? asset('storage/' . $record->image_path)
                            : asset('images/reftec_logo_transparent_16x9.png'), // Default
                    ],
                ];
            });

            return response()->json($response);
        } catch (Exception $e) {
            Log::error('Error fetching hero section: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to load hero section.',
            ], 500);
        }
    }

    public function getHistory(Request $request)
    {
        try {
            $response = Cache::remember('section_history', env('CACHE_EXPIRATION', 3600), function () {
                $record = General::where('section', 'history')->first(['content', 'image_path']);

                return [
                    'success' => true,
                    'data' => [
                        'description' => $record->content,
                        'image' => $record && $record->image_path
                            ? asset('storage/' . $record->image_path)
                            : asset('images/reftec_logo_transparent_16x9.png'),
                    ],
                ];
            });
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

    public function getAllProductLines(Request $request)
    {
        try {
            $response = Cache::remember('section_product_lines', env('CACHE_EXPIRATION', 3600), function () {
                $record = ProductLines::get(['id', 'name', 'image_path', 'visibility']);

                return [
                    'success' => true,
                    'data' => $record
                ];
            });
            return response()->json($response);
        } catch (Exception $e) {
            Log::error('Error fetching product lines: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch product lines: ' . $e->getMessage(),
                'type' => 'error',
            ], 500);
        }
    }

    // UPDATE | POST
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

            // Clear cache for hero section after updating
            Cache::forget('section_hero');

            session()->flash('content', [
                'tab' => 'general',
                'section' => 'hero'
            ]);

            return redirect(url()->previous())->with('toast', [
                'type' => 'success',
                'message' => 'Hero image has been updated!'
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            session()->flash('content', [
                'tab' => 'general',
                'section' => 'hero'
            ]);

            return redirect(url()->previous())->with('toast', [
                'success' => false,
                'message' => 'Failed to update hero content: ' . $e->getMessage(),
                'type' => 'error',
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

            switch ($context) {
                case 'content_text':
                    General::updateOrCreate(['section' => 'history'], [
                        'content' => $request->get('data_history')
                    ]);

                    Cache::forget('section_history');

                    session()->flash('content', [
                        'tab' => 'general',
                        'section' => 'history'
                    ]);

                    return redirect()->back()->with('toast', ['type' => 'success', 'message' => 'History text saved successfully!']);

                case 'content_image':
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

                    Cache::forget('section_history');

                    session()->flash('content', [
                        'tab' => 'general',
                        'section' => 'history'
                    ]);

                    return redirect(url()->previous())->with('toast', [
                        'type' => 'success',
                        'message' => 'History image has been updated!'
                    ]);
            }
        } catch (Exception $e) {
            Log::error('Error saving history: ' . $e->getMessage());

            session()->flash('content', [
                'tab' => 'general',
                'section' => 'history'
            ]);

            return redirect(url()->previous())->with('toast', [
                'success' => false,
                'message' => 'Failed to update history content: ' . $e->getMessage(),
                'type' => 'error',
            ]);
        }
    }

    // DELETE | POST

}
