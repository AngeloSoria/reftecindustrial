<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Upload;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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
                $filetype = $file->getClientMimeType();
                $path = $file->storeAs('uploads', $filename, $disk);

                $instance = Upload::create([
                    'filename'    => $filename,
                    'type' => $filetype,
                    'path'        => $path,
                    'uploaded_by' => Auth::id(),
                    'is_private'  => $isPrivate,
                ]);

                $uploaded[] = [
                    'file_id' => $instance->id,
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

    public function getUploadedFile($upload_id)
    {
        try {

            $record = Upload::findOrFail($upload_id);

            return response()->json([
                'type' => 'success',
                'success' => true,
                'data' => $record
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'File not found.',
                'type' => 'error'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get uploaded file: ' . $e->getMessage(),
                'type' => 'error'
            ], 500);
        }
    }

    public function getAllUploadedFiles(Request $request)
    {
        $request->validate([
            'type' => 'nullabe|string' // Determine file type request for proper sorting.
        ]);

        // TODO: complete this api.
    }

    public function deleteUploadedFile($upload_id)
    {
        try {
            $record = Upload::findOrFail($upload_id);
            // Delete the file from storage
            $disk = $record->is_private ? 'private' : 'public';
            Storage::disk($disk)->delete($record->path);

            // Delete the database record
            $record->delete();

            session()->flash('toast', [
                'type' => 'success',
                'message' => 'File deleted successfully.',
            ]);

            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            session()->flash('toast', [
                'type' => 'error',
                'message' => 'File not found.',
            ]);

            return redirect()->back();
        } catch (Exception $e) {
            Log::error('Failed to delete uploaded file: ' . $e->getMessage());

            session()->flash('toast', [
                'type' => 'error',
                'message' => 'Failed to delete file: ' . $e->getMessage(),
            ]);

            return redirect()->back();
        }
    }
}
