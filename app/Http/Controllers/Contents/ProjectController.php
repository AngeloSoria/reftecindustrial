<?php

namespace App\Http\Controllers\Contents;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UploadController;
use Exception;
use Illuminate\Http\Request;

use App\Models\Contents\Project;
use Illuminate\Database\UniqueConstraintViolationException;

class ProjectController extends Controller
{
    public function addProject(Request $request)
    {
        try {
            // dd($request);
            $request->validate([
                'job_order' => 'required|string',
                'project_name' => 'required|string',
                'description' => 'nullable|string',
                'status' => [
                    'required',
                    'string',
                    function ($attribute, $value, $fail) {
                        if (!in_array($value, ["pending", "on_going", "completed"])) {
                            $fail("Invalid project status value passed.");
                        }
                    },
                ],
                'visibility' => 'nullable|string',
                'highlighted' => 'nullable|string',
            ]);

            // Synthesize
            $PROJECT = [
                'job_order' => $request->job_order,
                'title' => $request->project_name,
                'description' => $request->description,
                'status' => $request->status,
                'is_visible' => !empty($request->visibility) ? 1 : 0,
                'is_featured' => !empty($request->highlighted) ? 1 : 0,
                'images' => "",
            ];

            // Final the upload of the images.
            $uploadController = new UploadController();
            $uploadIds = [];
            try {
                $uploadInfo = $uploadController->upload($request)->getData(true);

                if (!$uploadInfo['success']) {
                    throw new Exception($uploadInfo['message']);
                }

                // dd($uploadInfo);

                foreach ($uploadInfo['files'] as $fileInfo) {
                    $uploadIds[] = $fileInfo['path'];
                }

                // Save to DB
                Project::create([
                    'images' => $uploadIds,
                    'job_order' => $PROJECT['job_order'],
                    'title' => $PROJECT['title'],
                    'description' => $PROJECT['description'],
                    'status' => $PROJECT['status'],
                    'is_visible' => $PROJECT['is_visible'],
                    'is_featured' => $PROJECT['is_featured'],
                ]);
            } catch (UniqueConstraintViolationException $e) {
                foreach ($uploadIds as $uploadId) {
                    $uploadController->deleteUploadedFile($uploadId);
                }
                throw new Exception("Job order from a project already exists.");
            } catch (Exception $e) {
                foreach ($uploadIds as $uploadId) {
                    $uploadController->deleteUploadedFile($uploadId);
                }
                throw new Exception($e);
            }

            session()->flash('content', [
                'tab' => 'projects',
            ]);
            toast("Successfully added project.", "success");
            return back();
        } catch (Exception $e) {
            session()->flash('content', [
                'tab' => 'projects'
            ]);
            Logger()->error($e->getMessage());
            toast($e->getMessage(), 'error');
            return back();
        }
    }

    public function getProjects($filter = null)
    {
        try {

            $projects = Project::select([
                'images',
                'job_order',
                'title',
                'description',
                'status',
                'is_visible',
                'is_featured'
            ])
                ->latest()
                ->paginate(15);

            return response()->json([
                'success' => true,
                'data' => $projects
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
}
