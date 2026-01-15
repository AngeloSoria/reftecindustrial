<?php

namespace App\Http\Controllers\Contents;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Contents\{GeneralController, ProjectController};

class HomeContentController extends Controller
{
    public function index() {
        return Cache::remember('home_page_public', env('CACHE_EXPIRATION', 3600), function () {
            return [
                'hero' => app(GeneralController::class)->getHeroSection(),
                'product_lines' => app(GeneralController::class)->getAllProductLines(true),
                'history' => app(GeneralController::class)->getHistory(),
                'projects' => app(ProjectController::class)->getProjectsHighlightedPublic()
            ];
        });
    }
}
