<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Upload;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    /**
     * Handle both single and multiple file uploads.
     */
    public function upload(Request $request)
    {
        try {
            // 1. Validate
            $request->validate([
                'file' => 'nullable|file|mimes:jpg,png,jpeg,bmp,gif,pdf,xlsx,docx|max:' . env('APP_MAX_UPLOAD_SIZE', 10240),
                'files.*' => 'nullable|file|mimes:jpg,png,jpeg,bmp,gif,pdf,xlsx,docx|max:' . env('APP_MAX_UPLOAD_SIZE', 10240),
                'is_private' => 'nullable|boolean',
            ]);

            // 2. Determine input field(s)
            $files = $request->file('files') ?? $request->file('file');

            if (!$files) {
                return response()->json([
                    'success' => false,
                    'message' => 'No file(s) received in the request.',
                ], 400);
            }

            // Normalize single upload to an array
            if (!is_array($files)) {
                $files = [$files];
            }

            $isPrivate = $request->boolean('is_private');
            $disk = $isPrivate ? 'private' : 'public';

            $uploaded = [];

            // 3. Process uploads
            foreach ($files as $file) {
                if (!$file) continue;

                $filename = time() . '_' . Str::random(6) . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('uploads', $filename, $disk);

                Upload::create([
                    'filename'    => $filename,
                    'path'        => $path,
                    'uploaded_by' => Auth::id(),
                    'is_private'  => $isPrivate,
                ]);

                $uploaded[] = [
                    'filename' => $filename,
                    'path' => $path,
                    'url' => $isPrivate ? null : asset('storage/' . $path),
                ];
            }

            session()->flash('toast', [
                'type' => 'success',
                'message' => count($uploaded) > 1
                    ? 'Files uploaded successfully.'
                    : 'File uploaded successfully.',
            ]);

            // 4. Build response
            return response()->json([
                'success' => true,
                'message' => count($uploaded) > 1
                    ? 'Files uploaded successfully.'
                    : 'File uploaded successfully.',
                'files' => $uploaded,
                'is_private' => $isPrivate,
            ], 200);
        } catch (Exception $e) {
            Log::error('Upload failed: ' . $e->getMessage());

            session()->flash('toast', [
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'File upload failed.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
