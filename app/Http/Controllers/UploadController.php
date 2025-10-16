<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Exception;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        try {
            // Validate inputs
            $request->validate([
                'file' => 'nullable|mimes:jpg,png,jpeg,bmp,gif,pdf,xlsx,docx|max:' . env('APP_MAX_UPLOAD_SIZE', 10240),
                'files.*' => 'nullable|mimes:jpg,png,jpeg,bmp,gif,pdf,xlsx,docx|max:' . env('APP_MAX_UPLOAD_SIZE', 10240),
                'is_private' => 'nullable|boolean',
            ]);

            // Gather file(s)
            $files = $request->file('files') ?? $request->file('file');

            if (!$files) {
                return response()->json(['error' => 'No files received'], 400);
            }

            // Normalize single file into array
            if (!is_array($files)) {
                $files = [$files];
            }

            // Use Laravel’s built-in boolean helper
            $isPrivate = $request->boolean('is_private'); // replaces filter_var()


            // Choose disk dynamically
            $disk = $isPrivate ? 'private' : 'public';

            $uploadedPaths = [];

            // Handle uploads
            foreach ($files as $file) {
                if (!$file) continue;

                $filename = time() . '_' . Str::random(6) . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('uploads', $filename, $disk);

                Upload::create([
                    'filename'    => $filename,
                    'path'        => $path,
                    'uploaded_by' => Auth::id(),
                    'is_private'  => $isPrivate, // boolean; Eloquent will cast to 0/1
                ]);

                $uploadedPaths[] = $path;
            }

            // Respond
            return response()->json([
                'message' => 'File(s) uploaded successfully',
                'paths' => $uploadedPaths,
                'is_private' => $isPrivate,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'File upload failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
