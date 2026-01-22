<?php

namespace App\Http\Controllers\Contents;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Contents\{GeneralController, ProjectController};

class HomeContentController extends Controller
{
    public function index() {
        // Get current version, initialize if missing
        $version = Cache::get('general:version', function () {
            return Cache::forever('general:version', 1);
        });
        $cacheKey = 'general:home_public:v' . $version;

        return Cache::remember($cacheKey, env('CACHE_EXPIRATION', 600), function () {
            return [
                'hero' => app(GeneralController::class)->getHeroSection(),
                'product_lines' => app(GeneralController::class)->getAllProductLines(true),
                'history' => app(GeneralController::class)->getHistory(),
                'projects' => app(ProjectController::class)->getProjectsHighlightedPublic()
            ];
        });
    }
}
