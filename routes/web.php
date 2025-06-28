<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
});

// Protect all app routes with Sanctum auth
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Job pages
    Route::get('/jobs', [\App\Http\Controllers\JobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/create', [\App\Http\Controllers\JobController::class, 'create'])
         ->middleware('role:company')->name('jobs.create');
    Route::get('/jobs/{job}', [\App\Http\Controllers\JobController::class, 'show'])->name('jobs.show');
    Route::get('/jobs/{job}/edit', [\App\Http\Controllers\JobController::class, 'edit'])
         ->middleware('role:company')->name('jobs.edit');

    // Applications page (applicant)
    Route::get('/applications', [\App\Http\Controllers\ApplicationController::class, 'index'])
         ->middleware('role:applicant')->name('applications.index');

    // Applications page per job (company)
    Route::get('/jobs/{job}/applications', [\App\Http\Controllers\ApplicationController::class, 'indexByJob'])
         ->middleware('role:company')->name('jobs.applications');

    // Resume pages
    Route::get('/resume/upload', [\App\Http\Controllers\ResumeController::class, 'uploadForm'])
         ->middleware('role:applicant')->name('resume.upload');
    Route::get('/resume/analyze', [\App\Http\Controllers\ResumeController::class, 'analyzeForm'])
         ->middleware('role:applicant')->name('resume.analyze');
});

// Fallback route for SPA (optional)
Route::get('/{any}', function () {
    return Inertia::render('Welcome');
})->where('any', '.*');
