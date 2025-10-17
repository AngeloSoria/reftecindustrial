<?php

namespace App\Http\Controllers\Contents;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Contents\General;
use App\Http\Controllers\UploadController;

class GeneralController extends Controller
{
    private $UploadController;

    function __construct() {
        $this->UploadController = new UploadController();
    }

    // CREATE | POST
    public function setHeroSection(Request $request)
    {
        try {

            // Call UploadController->upload and inspect JSON response
            $response = $this->UploadController->upload($request);

            // Determine status code (JsonResponse) if available
            $status = method_exists($response, 'getStatusCode') ? $response->getStatusCode() : 200;

            // Convert JSON response to array
            $data = method_exists($response, 'getData') ? $response->getData(true) : (is_array($response) ? $response : []);

            if ($status >= 400) {
                $err = $data['error'] ?? 'Upload failed';
                throw new Exception($err);
            }

            // Expect 'paths' from upload response; support single 'path' as fallback
            $paths = $data['paths'] ?? ($data['path'] ?? null);

            if (empty($paths)) {
                throw new Exception('No uploaded path returned from upload controller.');
            }

            // If single path string provided, normalize to first element
            $imagePath = is_array($paths) ? reset($paths) : $paths;

            // Create General record for hero section (you can change to updateOrCreate if desired)
            General::create([
                'section' => 'hero',
                'image_path' => $imagePath
            ]);

            return redirect()->back()->with('toast', [
                'message' => 'Hero section image saved successfully.',
                'type' => 'success'
            ]);

        } catch (Exception $e) {
            return redirect()->back()->with('toast', [
                'message' => $e->getMessage(),
                'type' => 'error'
            ]);
        }

    }

    // READ | GET
    public function getHeroSection(Request $request) {
        try {
            return General::where('section', 'hero')->first();
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
