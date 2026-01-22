<?php

namespace App\Http\Controllers\Contents;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\UploadController;

use Illuminate\Validation\Rule;
use App\Models\Contents\Project;
use Symfony\Component\HttpFoundation\FileBag;
use Illuminate\Database\UniqueConstraintViolationException;

class ProjectController extends Controller
{
    private function resetAllCache()
    {
        Cache::increment('projects:version');
    }
    public function addProject(Request $request)
    {
        try {
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

            $this->resetAllCache();

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

            $this->resetAllCache();

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
            $this->resetAllCache();

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
            $this->resetAllCache();

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
    public function getProjectsFiltered(Request $request, $isPublic = false)
    {
        try {

            // Get current version, initialize if missing
            $version = Cache::get('projects:version', function () {
                return Cache::forever('projects:version', 1);
            });

            $cacheKey = 'projects:filtered:v' . $version . ':' . md5(json_encode([
                'public'   => $isPublic,
                'auth'     => $request->user() ? 1 : 0,
                'filters'  => $request->only(['status', 'visibility', 'featured', 'search']),
                'page'     => $request->get('page', 1),
            ]));

            return Cache::remember($cacheKey, ENV('CACHE_EXPIRATION', 300), function () use ($request, $isPublic) {

                // -----------------------------------
                // Columns
                // -----------------------------------
                $baseColumns = [
                    'id',
                    'images',
                    'job_order',
                    'title',
                    'description',
                    'status',
                ];

                $restrictedColumns = ['is_visible', 'is_featured'];

                $columns = $request->user()
                    ? array_merge($baseColumns, $restrictedColumns)
                    : $baseColumns;

                $query = Project::select($columns);

                // -----------------------------------
                // Public rules
                // -----------------------------------
                if ($isPublic) {
                    $query->where('is_visible', true)
                        ->where('status', '!=', 'pending');
                }

                // -----------------------------------
                // Filters
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

                $projects = $query->latest()->paginate(15);

                // -----------------------------------
                // Transform
                // -----------------------------------
                $projects->getCollection()->transform(function ($project) {
                    $imageIDs = $project->images;

                    if (is_array($imageIDs)) {
                        $project->images = array_filter(array_map(function ($id) {
                            $response = app(UploadController::class)
                                ->getUploadedFile($id)
                                ->getData(true);

                            return $response['success']
                                ? $response['data']['path']
                                : null;
                        }, $imageIDs));
                    } else {
                        $project->images = [];
                    }

                    return $project;
                });

                return [
                    'success'  => true,
                    'data'     => $projects,
                    'featured' => Project::where('is_featured', 1)->count(),
                ];
            });
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
    public function getProjectsHighlightedPublic()
    {
        try {
            // Get current version, initialize if missing
            $version = Cache::get('projects:version', function () {
                return Cache::forever('projects:version', 1);
            });

            $cacheKey = 'projects:highlighted_public:v' . $version;

            $response = Cache::remember($cacheKey, ENV('CACHE_EXPIRATION', 500), function () {
                $result = Project::where('is_featured', 1)->get([
                    'id',
                    'images',
                    'job_order',
                    'title',
                    'description',
                    'status',
                ]);

                $result->transform(function ($project) {
                    $uploadController = new UploadController();
                    $response = $uploadController->getUploadedFile($project->images[0])->getData(true);
                    if (!$response['success']) {
                        throw new Exception($response['message']);
                    }
                    $project->images = [$response['data']['path']];
                    return $project;
                });

                return [
                    'success' => true,
                    'data' => $result
                ];
            });

            return response()->json($response);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
