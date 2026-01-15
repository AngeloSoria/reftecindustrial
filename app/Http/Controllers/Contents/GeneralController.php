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
use Symfony\Component\HttpFoundation\File\Exception\NoFileException;

class GeneralController extends Controller
{
    public function test(Request $request)
    {
        try {
            throw new Exception("Toast Exception");
        } catch (Exception $e) {
            Log::error($e->getMessage());

            toast($e->getMessage(), "error");

            return redirect()->back();
        }
    }

    // CREATE | POST
    public function addProductLine(Request $request)
    {
        try {

            // dd($request);

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
            $product_line = ProductLines::create([
                'name' => $request->product_line_name,
                'upload_id' => $data['files'][0]['file_id'],
                'visibility' => $visible
            ]);

            // Clear cache for product lines section after updating
            Cache::forget('section_product_lines_public');
            Cache::forget('section_product_lines_private');
            Cache::forget('section_product_lines_visible');
            Cache::forget('home_page_public');

            session()->flash('content', [
                'tab' => 'general',
                'section' => 'products'
            ]);

            toast("New product line has been added.", "success");
            actLog('create', 'Added new Product Line', 'A product line ' . '(' . $product_line->name . ') has been registered.');

            return back();
        } catch (Exception $e) {
            Log::error("Failed to add product line: " . $e->getMessage());
            toast("Failed to add product line: " . $e->getMessage(), "error");
            return back();
        }
    }

    public function addAboutUsGalleryImage(Request $request)
    {
        try {
            $COLUMN_NAME = 'about_us_gallery';

            // find in database.
            $about_us_data = General::where('section', $COLUMN_NAME)->first(['extra_data']);

            if ($about_us_data) {
                if (!$request->hasFile('files')) {
                    throw new NoFileException("File not found in the request.");
                }

                $uploadController = new UploadController();
                $uploadResponse = $uploadController->upload($request)->getData(true);
                $uploadedFiles = [];

                try {
                    // decode json to convert into an array.
                    $decoded_extra_data = json_decode($about_us_data['extra_data'], true);

                    // get uploaded files info
                    $data = $uploadResponse;

                    if (!$data || !$data['success']) {
                        throw new Exception($data['message']);
                    }

                    // if empty then, create new data
                    if (empty($decoded_extra_data)) {
                        foreach ($data['files'] as $file) {
                            // insert file id into created array from earlier.
                            $decoded_extra_data[] = $file["file_id"];
                        }

                        $uploadedFiles = $decoded_extra_data;

                        // decode the array to json
                        $encoded_extra_data = json_encode($decoded_extra_data);

                        // save to database
                        General::where(['section' => $COLUMN_NAME])->update(['extra_data' => $encoded_extra_data]);

                        // Clear cache for about us section after updating
                        Cache::forget('section_about_us_gallery');

                        // notify user 
                        toast('Gallery image(s) has been added.', 'success');
                        actLog('create', 'Gallery image(s) has been added.', 'Gallery image(s) has been added.');
                    } else {
                        // if max uploaded then notify as error.
                        if (count($decoded_extra_data) >= 3) {
                            throw new Exception('Max gallery image count has been used.');
                        }

                        foreach ($data['files'] as $file) {
                            if (count($decoded_extra_data) > 3) {
                                toast("Uploaded files exceeds the remaining slots. Resulted in skipping.", "warning", 4);
                                break; // stop adding if max reached
                            }

                            // append
                            $decoded_extra_data[] = $file['file_id'];
                        }

                        $uploadedFiles = $decoded_extra_data;

                        // encode
                        $encoded_extra_data = json_encode($decoded_extra_data);

                        // Save to database
                        General::where(['section' => $COLUMN_NAME])->update(['extra_data' => $encoded_extra_data]);

                        // notify user 
                        toast('Gallery image(s) has been added.', 'success');
                        actLog('create', 'Gallery image(s) has been added.', 'Gallery image(s) has been added.');
                    }
                } catch (Exception $e) {
                    // delete uploaded files when upload failed
                    foreach ($uploadedFiles as $file_id) {
                        $uploadController->deleteUploadedFile($file_id);
                    }

                    throw $e; // rethrow to be caught by main catch block
                }

                // add content location flash
                session()->flash('content', [
                    'tab' => 'general',
                    'section' => 'about'
                ]);

                // redirect
                return back();
            } else {
                // upload
                $uploadController = new UploadController();
                $uploadResponse = $uploadController->upload($request); // Call directly
                $uploadedFiles = [];

                // Get the data as array if it's a JsonResponse
                $data = $uploadResponse->getData(true);

                try {
                    if (!$data || !$data['success']) {
                        throw new Exception($data['message']);
                    } else {
                        $gallery_data = array_column($data['files'], 'file_id');

                        General::updateOrCreate(
                            ['section' => 'about_us_gallery'],
                            ['extra_data' => json_encode($gallery_data)]
                        );

                        // Clear cache for about us section after updating
                        Cache::forget('section_about_us_gallery');

                        session()->flash('content', [
                            'tab' => 'general',
                            'section' => 'about'
                        ]);

                        toast("New gallery image(s) has been added.", "success");

                        return back();
                    }
                } catch (Exception $e) {
                    // delete uploaded files when upload failed
                    foreach ($uploadedFiles as $file_id) {
                        $uploadController->deleteUploadedFile($file_id);
                    }

                    throw $e; // rethrow to be caught by main catch block
                }
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            session()->flash('content', [
                'tab' => 'general',
                'section' => 'about'
            ]);

            toast("Failed to add gallery image: " . $e->getMessage(), "error");

            return back();
        }
    }

    // READ | GET
    public function getHeroSection()
    {
        try {

            // controller logic
            $response = Cache::remember('section_hero', env('CACHE_EXPIRATION', 3600), function () {
                $record = General::where('section', 'hero')->first(['image_path']);

                return [
                    'success' => true,
                    'data' => [
                        'image' => $record && $record->image_path
                            ? asset($record->image_path)
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

    public function getHistory()
    {
        try {
            $response = Cache::remember('section_history', env('CACHE_EXPIRATION', 3600), function () {
                $record = General::where('section', 'history')->first(['content', 'image_path']);

                return [
                    'success' => true,
                    'data' => [
                        'description' => $record->content ?? "",
                        'image' => $record && $record->image_path
                            ? asset($record->image_path)
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

    public function getAllProductLines(bool $isPublic = false)
    {
        try {

            // Build data OUTSIDE cache (no locks held)
            $data = ProductLines::query()
                ->when($isPublic, fn($q) => $q->where('visibility', 1))
                ->leftJoin('uploads', 'uploads.id', '=', 'contents_general_product_lines.upload_id')
                ->orderByDesc('contents_general_product_lines.created_at')
                ->get([
                    'contents_general_product_lines.id',
                    'contents_general_product_lines.name',
                    'contents_general_product_lines.upload_id',
                    'uploads.path as image_path',
                ]);

            // Cache ONLY the final payload (short TTL)
            $response = Cache::remember(
                'section_product_lines_' . ($isPublic ? 'public' : 'private'),
                300, // 5 minutes — safe for shared hosting
                fn() => [
                    'success' => true,
                    'data' => $data,
                ]
            );

            return response()->json($response);
        } catch (Exception $e) {
            logger()->error('Error fetching product lines', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch product lines.',
                'type' => 'error',
            ], 500);
        }
    }
    public function getAllProductLinesPublic()
    {
        return $this->getAllProductLines(true);
    }

    public function getAllVisibileProductLines()
    {
        try {
            $response = Cache::remember('section_product_lines_visible', env('CACHE_EXPIRATION', 3600), function () {

                $record = ProductLines::where('visibility', 1)->latest()->get(['id', 'name', 'upload_id']);

                // Map each product line to include image_path
                $uploadController = new UploadController();
                $newData = $record->map(function ($product_line) use ($uploadController) {
                    $uploadResponse = $uploadController->getUploadedFile($product_line->upload_id);

                    $data = $uploadResponse->getData(true);

                    if (!$uploadResponse) {
                        throw new Exception("No uploaded data found.");
                    }

                    $product_line->image_path = $data['data']['path'] ?? null;

                    return $product_line->makeHidden(['id', 'upload_id']);
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

    public function getAllAboutUsGallery()
    {
        try {
            $response = Cache::remember('section_about_us_gallery', env('CACHE_EXPIRATION', 3600), function () {
                $column_name = 'about_us_gallery';
                $record = General::where('section', $column_name)->first(['id', 'extra_data']);

                if (!$record) {
                    return response()->json([
                        'success' => true,
                        'message' => "No record found in the about us gallery.",
                        'data' => [
                            'remaining' => 3,
                            'gallery' => null
                        ],
                    ]);
                }

                $extra_data = $record['extra_data'];
                $decode_extra_data = json_decode($extra_data);

                if (empty($decode_extra_data)) {
                    return response()->json(
                        [
                            'success' => true,
                            'data' => [
                                'remaining' => 3,
                                'gallery' => null
                            ]
                        ]
                    );
                }

                $gallery_image_data = [];

                // get the image path base on upload id.
                $uploadController = new UploadController();
                foreach ($decode_extra_data as $file_id) {
                    $uploadResponse = $uploadController->getUploadedFile($file_id);
                    $data = $uploadResponse->getData(true);

                    if (!$data['success']) {
                        throw new Exception($data['message']);
                    }

                    $gallery_image_data[] = [
                        "file_id" => $data['data']['id'],
                        "path" => $data['data']['path']
                    ] ?? null;
                }

                return response()->json([
                    'success' => true,
                    'data' => [
                        'remaining' => 3 - count($gallery_image_data),
                        'gallery' => $gallery_image_data
                    ]
                ]);
            });

            return response()->json($response);
        } catch (Exception $e) {
            Log::error('Error fetching About Us gallery: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to load About Us gallery: ' . $e->getMessage(),
            ], 500);
        }
    }

    // UPDATE | POST
    public function setHeroSection(Request $request)
    {
        try {
            // dd($request);
            // Check if the request contains file, else, throw an error.
            if (empty($request->allFiles())) {
                throw new NoFileException('File not found in the request.');
            }

            $uploadController = new UploadController();
            $uploadData = $uploadController->upload($request)->getData(true); // Call directly

            if (!$uploadData['success']) {
                throw new Exception($uploadData['message']);
            }

            // Check if hero is already exists.
            // If exists, check for the image_path to delete the old file.
            $model = General::where('section', 'hero')->first();
            if (!empty($model) && !empty($model->image_path)) {
                $uploadController->deleteUploadedFileByPath($model->image_path);
            }

            General::updateOrCreate(['section' => 'hero'], [
                'image_path' => $uploadData['files'][0]['path'] ?? null
            ]);

            // Clear cache for hero section after updating
            Cache::forget('section_hero');
            Cache::forget('home_page_public');

            session()->flash('content', [
                'tab' => 'general',
                'section' => 'hero'
            ]);

            actLog('update', 'Hero has been updated.', 'Hero has been updated.');
            toast("Hero image has been updated.", "success");
            return back();
        } catch (Exception $e) {
            Log::error($e->getMessage());

            session()->flash('content', [
                'tab' => 'general',
                'section' => 'hero'
            ]);

            toast("Failed to update hero content: " . $e->getMessage(), "error");
            return back();
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
                    Cache::forget('home_page_public');

                    session()->flash('content', [
                        'tab' => 'general',
                        'section' => 'history'
                    ]);

                    toast("History text saved successfully.", "success");
                    actLog('update', 'History description has been updated.', 'History description has been updated.');
                    return back();
                case 'content_image':
                    $uploadController = new UploadController();
                    $uploadResponse = $uploadController->upload($request); // Call directly

                    // Get the data as array if it's a JsonResponse
                    $data = $uploadResponse->getData(true);

                    if (!$data || !$data['success']) {
                        throw new Exception($data['message']);
                    }

                    // Check if hero is already exists.
                    // If exists, check for the image_path to delete the old file.
                    $exisitingFile = General::where('section', 'history')->first();
                    if ($exisitingFile && $exisitingFile->image_path) {
                        // Delete the old file
                        $uploadController->deleteUploadedFileByPath($exisitingFile->image_path);
                    }

                    General::updateOrCreate(['section' => 'history'], [
                        'image_path' => $data['files'][0]['path'] ?? null
                    ]);

                    Cache::forget('section_history');
                    Cache::forget('home_page_public');

                    session()->flash('content', [
                        'tab' => 'general',
                        'section' => 'history'
                    ]);

                    actLog('update', 'History image has been updated.', 'History image has been updated.');
                    toast("History image has been updated successfully.", "success");
                    return back();
                default:
                    throw new Exception("Invalid context value.");
            }
        } catch (Exception $e) {
            Log::error('Error saving history: ' . $e->getMessage());

            session()->flash('content', [
                'tab' => 'general',
                'section' => 'history'
            ]);

            toast("Failed to update history content: " . $e->getMessage(), "error");
            return back();
        }
    }

    public function setProductLine(Request $request)
    {
        try {
            $request->validate([
                'product_line_id'   => 'required|exists:contents_general_product_lines,id',
                'product_line_name' => 'string',
                'file'              => 'file|mimes:jpg,png,jpeg,bmp,gif|max:' . env('APP_MAX_UPLOAD_SIZE', 10240),
                'visibility'        => 'boolean',
            ]);

            $uploadId = null;

            // Fetch existing row once (needed for old upload cleanup)
            $existingProductLine = ProductLines::find($request->product_line_id);

            if ($request->hasFile('file')) {
                $uploadController = new UploadController();
                $uploadResponse   = $uploadController->upload($request);
                $data             = $uploadResponse->getData(true);

                if (
                    !$data ||
                    !$data['success'] ||
                    empty($data['files'][0]['file_id'])
                ) {
                    throw new Exception($data['message'] ?? 'Upload failed or invalid response.');
                }

                // Delete old uploaded file if exists
                if ($existingProductLine?->upload_id) {
                    $uploadController->deleteUploadedFile($existingProductLine->upload_id);
                }

                $uploadId = $data['files'][0]['file_id'];
            }

            // Build update payload
            $attributes = [
                'name'       => $request->get('product_line_name'),
                'visibility' => $request->get('visibility', 0),
            ];

            if ($uploadId) {
                $attributes['upload_id'] = $uploadId;
            }

            ProductLines::updateOrCreate(
                ['id' => $request->product_line_id],
                $attributes
            );

            // Clear cache
            Cache::forget('section_product_lines_public');
            Cache::forget('section_product_lines_private');
            Cache::forget('section_product_lines_visible');
            Cache::forget('home_page_public');

            session()->flash('content', [
                'tab'     => 'general',
                'section' => 'products',
            ]);

            actLog('update', 'Product Line has been updated.', 'A product line has been updated.');
            toast('Product line has been updated.', 'success');
            return back();
        } catch (Exception $e) {
            Logger()->info($e->getMessage());

            session()->flash('content', [
                'tab'     => 'general',
                'section' => 'products',
            ]);

            toast('Failed to edit product line: ' . $e->getMessage(), 'error');
            return back();
        }
    }

    public function editAboutUsGallery(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:jpg,png,jpeg,bmp,gif|max:' . env('APP_MAX_UPLOAD_SIZE', 10240), // Image only
                'gallery_image_index' => 'required|integer'
            ]);

            $galleryImageIndex = $request->gallery_image_index;

            // retrieve data
            $data = General::where('section', 'about_us_gallery')->first(['extra_data']);

            if (empty($data['extra_data'])) {
                throw new Exception("No data found when trying to edit.");
            }

            // Decode extra_data
            $decoded_data = json_decode($data['extra_data']);

            // get the upload id base on index
            $upload_id = $decoded_data[$galleryImageIndex];

            if (empty($upload_id)) {
                throw new Exception("No upload id found when reading the extra_data.");
            }

            // get the data from upload model
            $uploadController = new UploadController();

            // upload new file
            $uploadFileInfo = $uploadController->upload($request)->getData(true);

            // validate if existing   
            if (!$uploadFileInfo['success']) {
                throw new Exception("Something went wrong when trying to upload a file.");
            }

            // get the file id
            $new_file_id = $uploadFileInfo['files'][0]['file_id'];

            if (!$new_file_id) {
                throw new Exception("Something went wrong when trying to read the new file id.");
            }

            // replace old id into new (replace)
            $decoded_data[$galleryImageIndex] = $new_file_id;

            // encode data to be saved in db
            $encoded_data = json_encode($decoded_data);

            // save to database
            General::updateOrCreate(['section' => 'about_us_gallery'], [
                'extra_data' => $encoded_data
            ]);

            // FILE DELETION
            $retrieveFileInfo = $uploadController->getUploadedFile($upload_id)->getData(true);

            if (!$retrieveFileInfo['success']) {
                throw new Exception("Uploaded file not found from passed upload id.");
            }

            // delete the file from uploaded and storage
            $deleteFileInfo = $uploadController->deleteUploadedFile($retrieveFileInfo['data']['id'])->getData(true);

            if (!$deleteFileInfo['success']) {
                throw new Exception("Something went wrong when trying to delete a file.");
            }

            session()->flash('content', [
                'tab' => 'general',
                'section' => 'about'
            ]);

            toast("Gallery image has been updated.", "success");
            actLog('update', 'Gallery image has been updated.', 'Gallery image has been updated.');
            Cache::forget('section_about_us_gallery');
            return back();
        } catch (Exception $e) {
            Logger()->info($e->getMessage());

            session()->flash('content', [
                'tab' => 'general',
                'section' => 'about'
            ]);

            toast($e->getMessage(), "error");

            return back();
        }
    }

    public function updateOrderAboutUsGallery(Request $request)
    {
        try {

            // validate
            $request->validate([
                'about_us_gallery_order' => [
                    'required',
                    'string',
                    function ($attribute, $value, $fail) {
                        $uploadController = new UploadController();
                        $ids = explode(',', $value);

                        foreach ($ids as $id) {
                            $result = $uploadController->getUploadedFile($id)->getData(true);
                            if (!$result['success']) {
                                $fail($result['message']);
                            }
                        }
                    },
                ]
            ]);

            // convert to array.
            $requestData = explode(',', $request->about_us_gallery_order);

            if (empty($requestData)) {
                throw new Exception("Passed order data is empty.");
            }

            $toNumbers = [];
            foreach ($requestData as $id) {
                $toNumbers[] = (int) $id;
            }

            // encode to json
            $encoded_data = json_encode($toNumbers);

            // dd($request, $requestData, $encoded_data, $toNumbers);

            // save to database
            General::updateOrCreate(['section' => 'about_us_gallery'], [
                'extra_data' => $encoded_data
            ]);

            session()->flash('content', [
                'tab' => 'general',
                'section' => 'about'
            ]);

            actLog('update', 'Gallery order updated', 'Gallery order updated.');
            toast("Gallery order updated successfully.", "success");
            Cache::forget('section_about_us_gallery');
            return back();
        } catch (Exception $e) {
            Logger()->error($e->getMessage());

            session()->flash('content', [
                'tab' => 'general',
                'section' => 'about'
            ]);

            toast($e->getMessage(), "error");

            return back();
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
                Cache::forget('section_product_lines_public');
                Cache::forget('section_product_lines_private');
                Cache::forget('section_product_lines_visible');
                Cache::forget('home_page_public');

                // Session tab state
                session()->flash('content', [
                    'tab' => 'general',
                    'section' => 'products'
                ]);

                toast("Product line has been removed.", "success");
                actLog('delete', 'Product line has been removed.', 'Product line has been removed.');
                return back();
            } catch (Exception $e) {
                Logger()->info('Error deleting product line: ' . $e->getMessage());
                toast($e->getMessage(), "error");
                return back();
            } finally {
                // Release the lock no matter what
                $lock->release();
            }
        } else {
            // Lock not acquired (another deletion in progress)
            toast("Another deletion is in progress. Please try again shortly.", "error");
            return back();
        }
    }

    public function deleteAboutUsGallery(Request $request)
    {
        // Define a global lock key (you can make it user-specific if needed)
        $lockKey = 'delete_about_us_gallery_item';

        // Try to acquire the lock for up to 10 seconds
        $lock = Cache::lock($lockKey, 3);

        if ($lock->get()) { // Lock acquired
            try {
                $request->validate([
                    'gallery_image_index' => 'required|integer',
                ]);

                $data = General::where(['section' => 'about_us_gallery'])->first(['extra_data']);

                if (empty($data)) {
                    throw new Exception("No data found when deleting image from gallery.");
                }
                if (empty($data['extra_data'])) {
                    throw new Exception("No data value found inside gallery model.");
                }

                // convert to table as the extra_data value is a json_encode (string).
                $decoded_data = json_decode($data['extra_data']);

                $file_id = $decoded_data[$request->gallery_image_index];

                if (empty($file_id)) {
                    throw new Exception("File id not found when referencing using index.");
                }

                $uploadController = new UploadController();

                // delete from upload model
                $uploadResponse = $uploadController->deleteUploadedFile($file_id)->getData(true);

                if (!$uploadResponse['success']) {
                    throw new Exception($uploadResponse['message']);
                }

                // remove from gallery list
                unset($decoded_data[$request->gallery_image_index]);
                $decoded_data = array_values($decoded_data); // reindex

                // encode
                $encoded_data = json_encode($decoded_data);

                // save to database
                General::updateOrCreate(['section' => 'about_us_gallery'], [
                    'extra_data' => $encoded_data ?? null
                ]);

                // Clear cache
                Cache::forget($lockKey);

                // Session tab state
                session()->flash('content', [
                    'tab' => 'general',
                    'section' => 'about'
                ]);

                toast("Gallery image has been deleted.", "success");
                actLog('delete', 'Gallery image has been deleted.', 'Gallery image has been deleted.');
                return back();
            } catch (Exception $e) {
                Logger()->info('Error deleting product line: ' . $e->getMessage());
                toast("Error deleting product line: " . $e->getMessage(), "error");
                return back();
            } finally {
                // Release the lock no matter what
                $lock->release();
            }
        } else {
            // Lock not acquired (another deletion in progress)
            toast("Another deletion is in progress. Please try again shortly.", "error");
            return back();
        }
    }
}
