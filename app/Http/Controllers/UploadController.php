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
    private function isFileProtected($path)
    {
        $protected_contains = ['images/'];
        foreach ($protected_contains as $protected_path) {
            if (str_contains($path, $protected_path)) return true;
        }
        return false;
    }

    private function delete(string $path, bool $isPrivate = false): void
    {
        $disk = $isPrivate ? 'private' : 'public';

        // Normalize to disk-relative path
        $relativePath = ltrim($path, '/');

        // Remove URL prefixes
        if (str_starts_with($relativePath, 'storage/')) {
            $relativePath = substr($relativePath, strlen('storage/'));
        }

        if (str_starts_with($relativePath, 'public/')) {
            $relativePath = substr($relativePath, strlen('public/'));
        }

        // Protection check should use relative path
        if ($this->isFileProtected($relativePath)) {
            throw new Exception('File cannot be deleted as it is in a protected directory.');
        }

        if (!Storage::disk($disk)->exists($relativePath)) {
            throw new Exception("File not found on disk [{$disk}]: {$relativePath}");
        }

        Storage::disk($disk)->delete($relativePath);

        Log::info("File deleted successfully [{$disk}]: {$relativePath}");
    }

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

            $isPrivate = $request->boolean('is_private') ?? false;

            $uploaded = [];

            foreach ($files as $file) {
                if (!$file) continue;

                $filename = time() . '_' . Str::random(6) . '_' . $file->getClientOriginalName();
                $filetype = $file->getClientMimeType();

                if ($isPrivate) {
                    // keep private files in storage (or private disk)
                    $path = Storage::disk('private')->putFileAs('uploads', $file, $filename);
                    $url = null;
                } else {
                    $path = '/storage/' . Storage::disk('public_uploads')->putFileAs('uploads', $file, $filename);
                    $url = Storage::url($path);
                }

                $instance = Upload::create([
                    'filename'    => $filename,
                    'type'        => $filetype,
                    'path'        => $path,
                    'uploaded_by' => Auth::id(),
                    'is_private'  => $isPrivate,
                ]);

                $uploaded[] = [
                    'file_id'  => $instance->id,
                    'filename' => $filename,
                    'path'     => $path,
                    'url'      => $url,
                ];
            }

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
    public function getUploadedFileByPath($file_path)
    {
        try {
            $record = Upload::where(['path' => $file_path])->firstOrFail();

            return response()->json([
                'type' => 'success',
                'success' => true,
                'data' => $record
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'File not found. passed payload: ' . $file_path,
                'type' => 'error'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'type' => 'error',
                'message' => 'Failed to get uploaded file: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getAllUploadedFiles(Request $request)
    {
        try {
            $files = Upload::orderBy('created_at', 'desc')->get();

            return response()->json([
                'type' => 'success',
                'success' => true,
                'data' => $files
            ]);
        } catch (Exception $e) {
            Logger()->error('Failed to get uploaded files: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get uploaded files: ' . $e->getMessage(),
                'type' => 'error'
            ], 500);
        }
    }

    public function deleteUploadedFile($upload_id)
    {
        try {
            $record = Upload::findOrFail($upload_id);

            // Delete the file from storage
            if ($record->is_protected) {
                throw new Exception("This file is protected from deletion.");
            }
            $this->delete($record->path, $record->is_private);

            // Delete the database record
            $record->delete();

            // toast("File deleted successfully.", "success");
            Logger()->info('File deleted successfully: ' . $record->path);

            return response()->json([
                'success' => true,
                'message' => 'File deleted successfully.'
            ]);
        } catch (Exception $e) {
            Log::error('Failed to delete uploaded file: ' . $e->getMessage());

            // toast('Failed to delete file: ' . $e->getMessage(), "error");

            return response()->json([
                'success' => false,
                'message' => 'File deleting error:' . $e->getMessage()
            ]);
        }
    }

    public function deleteUploadedFileByPath($path)
    {
        try {
            if ($this->isFileProtected($path)) {
                Logger()->info('File cannot be deleted as it was in protected directory.');
                return false;
            }

            $record = Upload::where('path', $path)->firstOrFail();
            if ($record->is_protected) {
                throw new Exception("This file is protected from deletion.");
            }

            // Delete the file from storage
            $this->delete($record->path, $record->is_private);

            // Delete the database record
            $record->delete();

            return response()->json([
                'success' => true,
                'message' => 'File deleted successfully',
                'type' => 'success'
            ], 200);
        } catch (Exception $e) {
            Log::error('Failed to delete uploaded file (' . $path . '): ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete uploaded file: ' . $e->getMessage(),
                'type' => 'error'
            ], 404);
        }
    }
}
