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
            $request->validate([
                'file' => 'required|mimes:jpg,png,jpeg,bmp,gif,pdf,xlsx,docx|max:' . (env('APP_MAX_UPLOAD_SIZE', 10240)), // Max 50MB or 10MB by default.
            ]);

            $file = $request->file('file');
            $filename = time() . '_' . Str::random(6) . '_' . $file->getClientOriginalName(); // To avoid filename conflicts
            $path = $file->storeAs('uploads', $filename, 'public');

            // Save file info to database
            Upload::create([
                'filename' => $filename,
                'path' => $path,
                'uploaded_by' => Auth::id(),
            ]);

            return response()->json(['message' => 'File uploaded successfully', 'path' => $path]);
        } catch (Exception $e) {
            return response()->json(['error' => 'File upload failed: ' . $e->getMessage()], 500);
        }
    }
}
