<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\Contents\{
    HomeContentController,
    GeneralController,
    ProjectController,
    ProductController,
};

Route::prefix('content')
    ->name('api.content.')
    ->group(function () {
        Route::controller(GeneralController::class)->group(function () {
            Route::get('section/hero', 'getHeroSection')->name('get.section.hero');
            Route::get('section/history', 'getHistory')->name('get.section.history');
            Route::get('section/product_lines/visible', 'getAllVisibileProductLines')->name('get.section.product_lines.visible');
            Route::get('section/about_us/gallery', 'getAllAboutUsGallery')->name('get.section.about_us.gallery');
            Route::get('section/product_lines/public', 'getAllProductLinesPublic')->name('get.section.product_lines.public');
            Route::get('page/home', [HomeContentController::class, 'index'])->name('page.home');
        });

        Route::controller(ProjectController::class)->group(function () {
            Route::get('section/projects', 'getProjects')->name('get.section.projects');
            Route::get('section/projects/filtered/public', 'getProjectsPublic')->name('get.section.projects.filtered.public');
            Route::get('section/projects/highlighted/public', 'getProjectsHighlightedPublic')->name('get.section.projects.highlighted.public');
        });

        Route::controller(ProductController::class)->group(function () {
            Route::get('section/products/public', 'getProductsPublic')->name('get.section.products.public');
            Route::get('section/products/filtered/public', 'getProductsFiltered')->name('get.section.products.filtered.public');
        });
    });
