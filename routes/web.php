<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ApplicationController;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
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
    Route::get('/applications', [ApplicationController::class, 'index'])
         ->middleware('role:applicant')->name('applications.index');
     // Applicant applies to a job
     Route::post('/applications', [ApplicationController::class, 'store'])
     ->middleware( 'role:applicant')
     ->name('applications.store');

     // Company approves/rejects an application
     Route::put('/applications/{application}', [ApplicationController::class, 'update'])
     ->middleware( 'role:company')
     ->name('applications.update');

    // Applications page per job (company)
    Route::get('/jobs/{job}/applications', [ApplicationController::class, 'indexByJob'])
         ->middleware('role:company')->name('jobs.applications');

    // Resume pages
    Route::get('/resume/upload', [\App\Http\Controllers\ResumeController::class, 'uploadForm'])
         ->middleware('role:applicant')->name('resume.upload');
    Route::get('/resume/analyze', [\App\Http\Controllers\ResumeController::class, 'analyzeForm'])
         ->middleware('role:applicant')->name('resume.analyze');
});


require __DIR__.'/auth.php';

//   Fallback route for SPA (optional)
//   Route::get('/{any}', function () {
//      return Inertia::render('Welcome');
//   })->where('any', '.*');
