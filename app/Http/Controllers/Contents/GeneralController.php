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
                'upload_id' => $data['files'][0]['file_id'],
                'visibility' => $visible
            ]);

            // Clear cache for product lines section after updating
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
                $record = ProductLines::latest()->get(['id', 'name', 'upload_id', 'visibility']);

                // Map each product line to include image_path
                $uploadController = new UploadController();
                $newData = $record->map(function ($product_line) use ($uploadController) {
                    $uploadResponse = $uploadController->getUploadedFile($product_line->upload_id);

                    $data = $uploadResponse->getData(true);

                    if (!$uploadResponse) {
                        throw new Exception("No uploaded data found.");
                    }

                    $product_line->image_path = $data['data']['path'] ?? null;

                    return $product_line;
                });


                return [
                    'success' => true,
                    'data' => $newData
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

    public function setProductLine(Request $request)
    {
        try {
            // dd($request);
            $request->validate([
                'product_line_id' => 'required|exists:contents_general_product_lines,id',
                'product_line_name' => 'string',
                'file' => 'file|mimes:jpg,png,jpeg,bmp,gif|max:' . env('APP_MAX_UPLOAD_SIZE', 10240), // Image only
                'visibility' => 'boolean'
            ]);

            // find the model / product_line row data.
            $productLine = ProductLines::findOrFail($request->get('product_line_id'));

            if ($request->hasFile('file')) {
                // upload
                $uploadController = new UploadController();
                $uploadResponse = $uploadController->upload($request); // Call directly

                // Get the data as array if it's a JsonResponse
                $data = $uploadResponse->getData(true);

                if (!$data || !$data['success'] || empty($data['files'][0]['file_id'])) {
                    throw new Exception($data['message'] ?? "Upload failed or invalid response.");
                }

                // Update upload_id if new file uploaded
                $productLine->upload_id = $data['files'][0]['file_id'];
            }

            // Update other fields
            $productLine->name = $request->get('product_line_name');
            $productLine->visibility = $request->get('visibility', 0);

            // Clear cache for product lines section after updating
            Cache::forget('section_product_lines');

            $productLine->save();

            session()->flash('content', [
                'tab' => 'general',
                'section' => 'products'
            ]);

            return redirect()->back()->with('toast', [
                'type' => 'success',
                'message' => 'Product line has been updated.'
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with('toast', [
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    // DELETE | POST
    public function deleteProductLine(Request $request)
    {
        // Define a global lock key (you can make it user-specific if needed)
        $lockKey = 'delete_product_line_global_lock';

        // Try to acquire the lock for up to 10 seconds
        $lock = Cache::lock($lockKey, 10);

        if ($lock->get()) { // Lock acquired
            try {
                $request->validate([
                    'product_line_id' => 'required|exists:contents_general_product_lines,id',
                ]);

                // Find the product line
                $productLine = ProductLines::findOrFail($request->get('product_line_id'));
                // dd($productLine);

                // Delete the associated upload file
                $uploadController = new UploadController();
                $uploadController->deleteUploadedFile($productLine->upload_id);

                // Delete it
                $productLine->delete();

                // Clear cache
                Cache::forget('section_product_lines');

                // Session tab state
                session()->flash('content', [
                    'tab' => 'general',
                    'section' => 'products'
                ]);

                return redirect()->back()->with('toast', [
                    'type' => 'success',
                    'message' => 'Product line has been deleted.'
                ]);
            } catch (Exception $e) {
                Logger()->info('Error deleting product line: ' . $e->getMessage());
                return redirect()->back()->with('toast', [
                    'type' => 'error',
                    'message' => $e->getMessage()
                ]);
            } finally {
                // Release the lock no matter what
                $lock->release();
            }
        } else {
            // Lock not acquired (another deletion in progress)
            return redirect()->back()->with('toast', [
                'type' => 'error',
                'message' => 'Another deletion is in progress. Please try again shortly.'
            ]);
        }
    }
}
