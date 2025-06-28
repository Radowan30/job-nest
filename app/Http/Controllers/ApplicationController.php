<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApplicationController extends Controller
{
    use AuthorizesRequests;
    // Applicant: submit a new application
    public function store(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:jobs,id',
        ]);

        Application::firstOrCreate(
            ['user_id' => Auth::id(), 'job_id' => $request->job_id],
            ['status' => 'pending']
        );

        return redirect()->back()->with('success', 'Applied successfully.');
    }

    // Company: approve or reject
    public function update(Request $request, Application $application)
    {
        $this->authorize('view', $application->job); // ensure company owns the job

        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $application->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Application updated.');
    }

    // Applicant dashboard
    public function index()
    {
        $applications = Application::with('job:id,title')
            ->where('user_id', Auth::id())
            ->get();

        return Inertia::render('Applications/Index', [
            'applications' => $applications,
        ]);
    }

    // Company view per job
    public function indexByJob(Job $job)
    {
        $this->authorize('viewApplications', $job);

        $applications = $job->applications()->with('user:id,name')->get();

        return Inertia::render('Applications/Index', [
            'applications' => $applications,
            'jobId' => $job->id,
            'jobTitle' => $job->title,
        ]);
    }
}
