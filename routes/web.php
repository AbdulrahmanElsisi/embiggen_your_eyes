<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DatasetController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\StaticController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Datasets Page
Route::get('/datasets', [DatasetController::class, 'index'])->name('datasets.index');

// Explore Page (بتتفتح بس من زرار datasets)
Route::get('/explore/{planet?}', [ExploreController::class, 'show'])->name('explore.show');
Route::post('/ai-search', [ExploreController::class, 'aiSearch'])->name('ai.search');


// Resources Page
Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');

// About Page
Route::get('/about', [AboutController::class, 'index'])->name('about');


// Contact Page
Route::get('/contact', [StaticController::class, 'contact'])->name('contact');
Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');



