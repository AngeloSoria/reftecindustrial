<?php

namespace App\Http\Controllers\Contents;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UploadController;
use Exception;
use Illuminate\Http\Request;

use App\Models\Contents\Project;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\FileBag;

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

            // Check highlighted projects limit
            if ($PROJECT['is_featured'] == 1) {
                $currentHighlightedCount = Project::where('is_featured', 1)->count();
                if ($currentHighlightedCount >= 3) {
                    throw new Exception("You have reached the maximum limit of highlighted projects (3). Please unhighlight another project before adding a new highlighted project.");
                }
            }

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
                            $uploadIds[] = $fileInfo['path'];
                        }
                    } catch (Exception $e) {
                        foreach ($uploadIds as $upload_id) {
                            $uploadController->deleteUploadedFile($upload_id);
                        }
                        throw new Exception($e->getMessage());
                    }
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
                'id',
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

            $highlightedCount = Project::where('is_featured', 1)->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'projects' => $projects,
                    'highlightedCount' => $highlightedCount
                ]
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
    public function getProjectsV2(Request $request)
    {
        try {
            // -----------------------------
            // Base query
            // -----------------------------
            $query = Project::select([
                'id',
                'images',
                'job_order',
                'title',
                'description',
                'status',
                'is_visible',
                'is_featured'
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
                    $q->where('job_order', 'LIKE', "%{$search}%")
                        ->orWhere('title', 'LIKE', "%{$search}%")
                        ->orWhere('description', 'LIKE', "%{$search}%");
                });
            }

            // -----------------------------
            // Pagination (15 per page)
            // -----------------------------
            $projects = $query->latest()->paginate(15);

            // Return paginator JSON (standard Laravel format)
            return response()->json([
                'success' => true,
                'data' => $projects
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateProject(Request $request)
    {
        try {
            // Validate main request
            $request->validate([
                'project_id' => ['required', 'integer', 'exists:contents_projects,id'],
                'job_order' => ['required', 'string'],
                'project_name' => ['required', 'string'],
                'description' => ['nullable', 'string'],
                'status' => ['required', 'string', Rule::in(['pending', 'on_going', 'completed'])],
                'visibility' => ['nullable', 'string'],
                'highlighted' => ['nullable', 'string'],
            ]);

            // Get project data from DB
            $project = Project::findOrFail($request->project_id);

            // Prepare the data array for update
            $projectData = [
                'job_order'    => $request->job_order,
                'title'        => $request->project_name,
                'description'  => $request->description,
                'status'       => $request->status,
                'is_visible'   => empty($request->visibility) || $request->visibility != "on" ? 0 : 1,
                'is_featured'  => empty($request->highlighted) || $request->highlighted != "on" ? 0 : 1,
                'images'       => json_decode($request->project_images), // will merge later if files uploaded
            ];

            $uploadedFilesIds = [];

            // Check highlighted projects limit
            if ($projectData['is_featured'] == 1 && $project->is_featured == 0) {
                $currentHighlightedCount = Project::where('is_featured', 1)->count();
                if ($currentHighlightedCount >= 3) {
                    throw new Exception("You have reached the maximum limit of highlighted projects (3). Please unhighlight another project before highlighting this project.");
                }
            }

            // Handle uploaded files if any
            $allFiles = $request->files->all('files');
            if (count($allFiles) > 0) {
                // Calculate how many more files can be uploaded
                $uploadLimit = 6 - count($project->images);
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
                $uploadController = new UploadController();
                $uploadResponse = $uploadController->upload($uploadRequest)->getData(true);

                if (!$uploadResponse['success']) {
                    throw new Exception($uploadResponse['message']);
                }

                // Track uploaded file IDs for rollback in case of error
                foreach ($uploadResponse['files'] as $file) {
                    $uploadedFilesIds[] = $file['file_id'];
                }

                // Merge new file paths with existing project images
                $existingImages = $projectData['images'] ?? [];
                // dd($existingImages);
                foreach ($uploadResponse['files'] as $file) {
                    $existingImages[] = $file['path'];
                }
                $projectData['images'] = $existingImages;
            }

            // Save the project data
            $project->update($projectData);

            session()->flash('content', ['tab' => 'projects']);
            toast("A project has been updated.", 'success');
            return back();
        } catch (Exception $e) {
            // Rollback uploaded files if any
            if (!empty($uploadedFilesIds)) {
                $uploadController = $uploadController ?? new UploadController();
                foreach ($uploadedFilesIds as $fileId) {
                    $uploadController->deleteUploadedFile($fileId);
                }
            }

            Logger()->error($e->getMessage());
            session()->flash('content', ['tab' => 'projects']);
            toast($e->getMessage(), 'error');
            return back();
        }
    }

    public function deleteProject(Request $request)
    {
        try {
            $request->validate([
                'project_id' => 'required|string|exists:contents_projects,id'
            ]);


            $model = Project::findOrFail($request->project_id);

            $model->deleteOrFail();

            session()->flash('content', ['tab' => 'projects']);
            toast("A project has been deleted.", 'success');
            return back();
        } catch (Exception $e) {
            Logger()->error($e->getMessage());
            session()->flash('content', ['tab' => 'projects']);
            toast($e->getMessage(), 'error');
            return back();
        }
    }

    public function deleteSelectedProjects(Request $request)
    {
        try {
            $request->validate([
                'projects' => 'required|string'
            ]);


            $decoded_project = json_decode($request->projects, true);
            if (empty($decoded_project)) {
                throw new Exception('No existing project value passed.');
            }

            Project::destroy(array_keys($decoded_project));


            // dd($request->projects, json_decode($request->projects));

            session()->flash('content', ['tab' => 'projects']);
            toast("Selected projects has been deleted.", 'success');
            return back();
        } catch (Exception $e) {
            Logger()->error($e->getMessage());
            session()->flash('content', ['tab' => 'projects']);
            toast($e->getMessage(), 'error');
            return back();
        }
    }
}
