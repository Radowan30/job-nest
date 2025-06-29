<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\ResumeAnalysisController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Job;

Route::middleware('auth:sanctum')->group(function () {
    // Job routes
    Route::get('/jobs', [JobController::class, 'apiIndex']);
    Route::get('/jobs/{job}', [JobController::class, 'apiShow']);
    Route::post('/jobs', [JobController::class, 'apiStore'])->middleware('role:company');
    Route::put('/jobs/{job}', [JobController::class, 'apiUpdate'])->middleware('role:company');
    Route::delete('/jobs/{job}', [JobController::class, 'apiDelete'])->middleware('role:company');

    // Application routes
    Route::post('/applications', [ApplicationController::class, 'apiStore'])->middleware('role:applicant');
    Route::get('/applications', [ApplicationController::class, 'apiIndex'])->middleware('role:applicant');
    Route::get('/jobs/{job}/applications', [ApplicationController::class, 'apiIndexByJob'])->middleware('role:company');

    // Resume routes
    Route::post('/resume', [ResumeController::class, 'apiStore'])->middleware('role:applicant');
    Route::get('/resume', [ResumeController::class, 'apiShow'])->middleware('role:applicant');

    // AI analysis endpoint (stub)
    Route::post('/analyze-resume', [ResumeAnalysisController::class, 'analyze'])->middleware('role:applicant');
});

Route::get('/get-jobs', function (Request $request) {
    $ids = explode(',', $request->query('ids', ''));
    $jobs = Job::whereIn('id', $ids)->get();
    return response()->json($jobs);
});
