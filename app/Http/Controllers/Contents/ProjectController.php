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

    public function getProjectsFiltered(Request $request, $isPublic = false, $isFeatured = false)
    {
        try {
            // -----------------------------------
            // Columns to select
            // -----------------------------------
            $baseColumns = [
                'id',
                'images',
                'job_order',
                'title',
                'description',
                'status',
            ];

            $restrictedColumns = [
                'is_visible',
                'is_featured',
            ];

            // If not public, include restricted columns
            $columns = $baseColumns;
            if ($request->user()) {
                $columns = array_merge($columns, $restrictedColumns);
            }

            $query = Project::select($columns);

            // -----------------------------------
            // Public mode: 
            //    hide non-visible projects
            //    hide pending projects
            // -----------------------------------
            if ($isPublic) {
                $query->where('is_visible', true)
                    ->where('status', '!=', 'pending');
            }

            // -----------------------------------
            // Dynamic filters
            // -----------------------------------
            $filtersMap = [
                'status'     => 'status',
                'visibility' => 'is_visible',
                'featured'   => 'is_featured',
            ];

            foreach ($filtersMap as $requestKey => $dbColumn) {
                if ($request->filled($requestKey)) {
                    $query->where($dbColumn, $request->input($requestKey));
                }
            }

            // -----------------------------------
            // Search
            // -----------------------------------
            if ($request->filled('search')) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('job_order', 'LIKE', "%{$search}%")
                        ->orWhere('title', 'LIKE', "%{$search}%")
                        ->orWhere('description', 'LIKE', "%{$search}%");
                });
            }

            // -----------------------------------
            // Pagination
            // -----------------------------------
            $projects = $query->latest()->paginate(15);

            // Transform the paginated results
            $projects->getCollection()->transform(function ($project) {
                $imageIDs = $project->images;

                if (!empty($imageIDs) && is_array($imageIDs)) {

                    // If images are already an array of IDs, map them to paths
                    $project->images = array_map(function ($id) {
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
                    $project->images = array_map(fn($id) => '/uploads/' . $id, $imageIds);
                } else {
                    $project->images = [];
                }

                return $project;
            });


            return response()->json([
                'success' => true,
                'data'    => $projects,
                'featured' => Project::where('is_featured', 1)->count()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function getProjectsPublic(Request $request)
    {
        return $this->getProjectsFiltered($request, true);
    }
    public function getProjectsHighlightedPublic(Request $request)
    {
        try {
            // -----------------------------------
            // Columns to select
            // -----------------------------------
            $baseColumns = [
                'id',
                'images',
                'job_order',
                'title',
                'description',
                'status',
            ];

            return Project::get($baseColumns)->where('is_featured', true);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function updateProject(Request $request)
    {
        try {
            $uploadController = new UploadController();

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
                'images'       => json_decode($request->project_images),
            ];

            // convert path to id
            $toFileId = [];
            foreach ($projectData['images'] as $image_path) {
                $response = $uploadController->getUploadedFileByPath($image_path)->getData(true);
                if (!$response['success']) continue;
                $toFileId[] = $response['data']['id'];
            }
            
            // replace the request's images to file id.
            $projectData['images'] = $toFileId;

            $uploadedFileIds = [];

            // Check highlighted projects limit
            if ($projectData['is_featured'] == 1 && $project->is_featured == 0) {
                $currentHighlightedCount = Project::where('is_featured', 1)->count();
                if ($currentHighlightedCount >= 3) {
                    throw new Exception("You have reached the maximum limit of highlighted projects (3). Please unhighlight another project before highlighting this project.");
                }
            }

            // Handle uploaded files if any
            $allFiles = $request->files->all('files');
            if ($request->hasFile('files')) {
                // Calculate how many more files can be uploaded
                $uploadLimit = $project->images ? 6 - count($project->images) : 6;

                // if there's no slots left, throw an error.
                if ($uploadLimit <= 0) {
                    throw new Exception("No slots left when uploading new image.");
                }

                // If the uploaded files are more than the remaining slots, remove the excess.
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
                    $projectData['images'][] = $upload_id;
                }
            }

            $nonExistingFilesFromModel = array_diff($project->images, $projectData['images'] ?? []);

            // delete from files the non existing
            foreach ($nonExistingFilesFromModel as $file_id) {
                $uploadController->deleteUploadedFile($file_id);
            }

            // Save the project data
            $project->updateOrFail($projectData);

            session()->flash('content', ['tab' => 'projects']);
            toast("A project has been updated.", 'success');

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

            // Delete old uploaded files from existing product model
            $modelImages = $model->images;
            if (count($modelImages) > 0) {
                $uploadController = $uploadController ?? new UploadController();
                foreach ($modelImages as $id) {
                    $uploadController->deleteUploadedFile($id);
                }
            }

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

            // Delete old uploaded files from existing product model
            $uploadController = new UploadController();
            foreach ($decoded_project as $project_id => $project_data) {
                $project = Project::findOrFail($project_id);
                if (!$project) continue;

                $modelImages = $project_data['images'];
                if (count($modelImages) > 0) {
                    foreach ($modelImages as $imageIDs) {
                        $uploadController->deleteUploadedFile($imageIDs);
                    }
                }
                Project::destroy($project_id);
            }

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
