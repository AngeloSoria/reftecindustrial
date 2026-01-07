<?php

namespace App\Http\Controllers\Contents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\UniqueConstraintViolationException;
use Symfony\Component\HttpFoundation\FileBag;
use Exception;

use App\Http\Controllers\UploadController;
use App\Models\Contents\Product;
use App\Http\Controllers\LogController;

class ProductController extends Controller
{
    public function addProduct(Request $request)
    {
        try {
            // dd($request);
            $request->validate([
                'product_name' => 'required|string',
                'visibility' => 'nullable|string',
            ]);

            // Synthesize
            $PRODUCT = [
                'title' => $request->product_name,
                'is_visible' => !empty($request->visibility) ? 1 : 0,
                'images' => "",
            ];

            // Final the upload of the images.
            $uploadController = new UploadController();
            $uploadIds = [];
            try {
                if (!empty($request->file('files')) && count($request->file('files')) > 0) {
                    try {
                        $uploadInfo = $uploadController->upload($request)->getData(true);
                        if (!$uploadInfo['success']) {
                            throw new Exception($uploadInfo['message']);
                        }

                        foreach ($uploadInfo['files'] as $fileInfo) {
                            $uploadIds[] = $fileInfo['file_id'];
                        }
                    } catch (Exception $e) {
                        foreach ($uploadIds as $upload_id) {
                            $uploadController->deleteUploadedFile($upload_id);
                        }
                        throw new Exception($e->getMessage());
                    }
                }

                // Save to DB
                Product::create([
                    'images' => $uploadIds,
                    'title' => $PRODUCT['title'],
                    'is_visible' => $PRODUCT['is_visible'],
                ]);
            } catch (UniqueConstraintViolationException $e) {
                foreach ($uploadIds as $uploadId) {
                    $uploadController->deleteUploadedFile($uploadId);
                }
                throw new Exception("Job order from a product already exists.");
            } catch (Exception $e) {
                foreach ($uploadIds as $uploadId) {
                    $uploadController->deleteUploadedFile($uploadId);
                }
                throw new Exception($e);
            }

            session()->flash('content', [
                'tab' => 'products',
            ]);
            actLog('create', 'Created new product titled' . $PRODUCT['title'], 'Created a new product');
            toast("Successfully added product.", "success");
            return back();
        } catch (Exception $e) {
            session()->flash('content', [
                'tab' => 'products'
            ]);
            Logger()->error($e->getMessage());
            toast($e->getMessage(), 'error');
            return back();
        }
    }

    public function getProductsPublic()
    {
        try {
            $products = Product::where('is_visible', 1)
            ->select([
                'id',
                'images',
                'title',
            ])
            ->latest()
            ->paginate(15);

            // Transform the paginated results
            $products->getCollection()->transform(function ($product) {
                $imageIDs = $product->images;

                if (!empty($imageIDs) && is_array($imageIDs)) {

                    // If images are already an array of IDs, map them to paths
                    $product->images = array_map(function ($id) {
                        $uploadController = new UploadController();
                        $response = $uploadController->getUploadedFile($id)->getData(true);

                        if (!$response['success']) {
                            return false;
                        }

                        $file = $response['data'];

                        return $file['path'];
                    }, $imageIDs);
                } elseif (!empty($imageIDs) && is_string($imageIDs)) {
                    // In case it's stored as a string (legacy)
                    $imageIds = explode(',', $imageIDs);
                    $product->images = array_map(fn($id) => '/uploads/' . $id, $imageIds);
                } else {
                    $product->images = [];
                }

                return $product;
            });

            return response()->json([
                'success' => true,
                'data' => $products
            ]);
        } catch (Exception $e) {
            Logger()->error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    public function getProductsFiltered(Request $request)
    {
        try {
            // -----------------------------
            // Base query
            // -----------------------------
            $query = Product::select([
                'id',
                'images',
                'title',
                'is_visible',
            ]);

            // -----------------------------
            // Dynamic filters map
            // -----------------------------
            $filtersMap = [
                'status'     => 'status',
                'visibility' => 'is_visible',
                'featured'   => 'is_featured',
                // Add new filters here in the future:
                // 'category' => 'category_id',
            ];

            foreach ($filtersMap as $requestKey => $dbColumn) {
                if ($request->filled($requestKey)) {
                    $query->where($dbColumn, $request->input($requestKey));
                }
            }

            // -----------------------------
            // Optional search
            // -----------------------------
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%");
                });
            }

            // -----------------------------
            // Pagination (15 per page)
            // -----------------------------
            $products = $query->latest()->paginate(15);

            // Transform the paginated results
            $products->getCollection()->transform(function ($product) {
                $imageIDs = $product->images;

                if (!empty($imageIDs) && is_array($imageIDs)) {

                    // If images are already an array of IDs, map them to paths
                    $product->images = array_map(function ($id) {
                        $uploadController = new UploadController();
                        $response = $uploadController->getUploadedFile($id)->getData(true);

                        if (!$response['success']) {
                            return null;
                        }

                        $file = $response['data'];

                        return $file['path'];
                    }, $imageIDs);
                } elseif (!empty($imageIDs) && is_string($imageIDs)) {
                    // In case it's stored as a string (legacy)
                    $imageIds = explode(',', $imageIDs);
                    $product->images = array_map(fn($id) => '/uploads/' . $id, $imageIds);
                } else {
                    $product->images = [];
                }

                return $product;
            });

            // Return paginator JSON (standard Laravel format)
            return response()->json([
                'success' => true,
                'data' => $products
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateProduct(Request $request)
    {
        try {
            $uploadController = new UploadController();

            // Validate main request
            $request->validate([
                'product_id' => ['required', 'integer', 'exists:contents_products,id'],
                'product_name' => ['required', 'string'],
                'visibility' => ['nullable', 'string'],
            ]);
            
            // Get product data from DB
            $product = Product::findOrFail($request->product_id);
            
            // Prepare the data array for update
            $productData = [
                'images'       => json_decode($request->product_images), // value: paths
                'title'        => $request->product_name,
                'is_visible'   => empty($request->visibility) || $request->visibility != "on" ? 0 : 1,
            ];

            // convert path to id
            $toFileId = [];
            foreach ($productData['images'] as $image_path) {
                $response = $uploadController->getUploadedFileByPath($image_path)->getData(true);
                if (!$response['success']) continue;
                $toFileId[] = $response['data']['id'];
            }
            
            // replace the request's images to file id.
            $productData['images'] = $toFileId;
            
            // Handle uploaded files if any
            $uploadedFileIds = [];
            $allFiles = $request->files->all('files');
            if (count($allFiles) > 0) {
                // dd($request, $product);
                // Calculate how many more files can be uploaded
                $uploadLimit = $product->images ? 6 - count($product->images) : 6;
                $trimmedFiles = array_slice($allFiles, 0, $uploadLimit);

                // Create a new Request for the UploadController only
                $uploadRequest = new Request(
                    $request->all(),                 // input data
                    $request->query(),               // query parameters
                    $request->attributes->all(),     // attributes
                    $request->cookies->all(),        // cookies
                    $trimmedFiles,                   // files
                    $request->server->all(),         // server parameters
                    $request->getContent()           // raw content
                );

                // Wrap trimmed files in a FileBag
                $uploadRequest->files = new FileBag([
                    'files' => $trimmedFiles
                ]);

                // Upload the trimmed files
                $uploadResponse = $uploadController->upload($uploadRequest)->getData(true);

                if (!$uploadResponse['success']) {
                    throw new Exception($uploadResponse['message']);
                }

                // Track uploaded file IDs for rollback in case of error
                foreach ($uploadResponse['files'] as $file) {
                    $uploadedFileIds[] = $file['file_id'];
                }

                // append to current the uploaded
                foreach ($uploadedFileIds as $upload_id) {
                    $productData['images'][] = $upload_id;
                }
            }

            $nonExistingFilesFromModel = array_diff($product->images, $productData['images'] ?? []);

            // delete from files the non existing
            foreach ($nonExistingFilesFromModel as $file_id) {
                $uploadController->deleteUploadedFile($file_id);
            }

            // Save the product data
            $product->update($productData);
            
            actLog('update', 'Product has been updated', 'The product ' . $product->title . ' has been updated');
            
            session()->flash('content', ['tab' => 'products']);
            toast("A product has been updated.", 'success');
            return back();
        } catch (Exception $e) {
            // Rollback uploaded files if any
            if (!empty($uploadedFileIds)) {
                $uploadController = $uploadController ?? new UploadController();
                foreach ($uploadedFileIds as $fileId) {
                    $uploadController->deleteUploadedFile($fileId);
                }
            }

            Logger()->error($e->getMessage());
            session()->flash('content', ['tab' => 'products']);
            toast($e->getMessage(), 'error');
            return back();
        }
    }

    public function deleteProduct(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|string|exists:contents_products,id'
            ]);


            $product = Product::findOrFail($request->product_id);

            // Delete old uploaded files from existing product model
            $uploadController = new UploadController();
            $productImages = $product->images;
            if ($productImages && count($productImages) > 0) {
                foreach ($productImages as $imagePath) {
                    $uploadController->deleteUploadedFileByPath($imagePath);
                }
            }

            $product->deleteOrFail();
            actLog('delete', 'Deleted a product', 'The product ' . $product->title . ' has been deleted');

            session()->flash('content', ['tab' => 'products']);
            toast("A product has been deleted.", 'success');
            return back();
        } catch (Exception $e) {
            Logger()->error($e->getMessage());
            session()->flash('content', ['tab' => 'products']);
            toast($e->getMessage(), 'error');
            return back();
        }
    }

    public function deleteSelectedProducts(Request $request)
    {
        try {
            $request->validate([
                'products' => 'required|string'
            ]);

            $decoded_product = json_decode($request->products, true);
            if (empty($decoded_product)) {
                throw new Exception('No existing product value passed.');
            }

            $deletedItems = [];

            $uploadController = new UploadController();
            foreach ($decoded_product as $product_id => $value) {
                // dd($product_id, $value);
                $product = Product::findOrFail($product_id);

                // Remove associated uploaded images to free storage.
                foreach ($value['images'] as $image_path) {
                    $uploadController->deleteUploadedFileByPath($image_path);
                }

                $product->delete();
                $deletedItems[] = $product->title;
            }
            actLog('delete', 'Deleted these product(s)', 'These product(s) [' . implode(', ', $deletedItems) . '] has been deleted');
            
            session()->flash('content', ['tab' => 'products']);
            toast("Selected products has been deleted.", 'success');
            return back();
        } catch (Exception $e) {
            Logger()->error($e->getMessage());
            session()->flash('content', ['tab' => 'products']);
            toast($e->getMessage(), 'error');
            return back();
        }
    }
}
