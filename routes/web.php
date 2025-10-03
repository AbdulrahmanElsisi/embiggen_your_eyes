<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DatasetController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\StaticController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\NasaController;
use App\Http\Controllers\ImageSearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\NasaSearchController;


// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Datasets Page
Route::get('/datasets', [DatasetController::class, 'index'])->name('datasets.index');

// Explore Page (بتتفتح بس من زرار datasets)
Route::get('/explore/{planet?}', [ExploreController::class, 'show'])->name('explore.show');
Route::post('/ai-search', [ExploreController::class, 'aiSearch'])->name('ai.search');
Route::get('/timeline/{planet?}', [TimelineController::class, 'show'])->name('timeline');
Route::post('/compare', [TimelineController::class, 'compareImages'])->name('compare');


// Resources Page
Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');

// About Page
Route::get('/about', [AboutController::class, 'index'])->name('about');


// Contact Page
Route::get('/contact', [StaticController::class, 'contact'])->name('contact');
Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');



Route::get('/nasa/search', [NasaController::class, 'search']);

Route::get('/image-search', [ImageSearchController::class, 'show'])->name('image.search.show');
Route::post('/image-search', [ImageSearchController::class, 'search'])->name('image.search');


// Route::get('/nasa/search-image', [NasaSearchController::class, 'searchImage']);
// Route::get('/nasa', function () {
//     return view('nasa');
// });
