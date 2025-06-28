<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class JobController extends Controller
{
    use \Illuminate\Foundation\Auth\Access\AuthorizesRequests;

    // Show all jobs
    public function index()
    {
        $jobs = Job::with('company:id,name')->latest()->get();
        return Inertia::render('Jobs/Index', [
            'jobs' => $jobs,
        ]);
    }

    // Show create job form
    public function create()
    {
        return Inertia::render('Jobs/Create');
    }

    // Store new job
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data['company_id'] = Auth::id();
        Job::create($data);

        return redirect()->route('jobs.index')->with('success', 'Job created successfully.');
    }

    // Show job detail
    public function show(Job $job)
    {
        $job->load('company:id,name');
        return Inertia::render('Jobs/Show', [
            'job' => $job,
        ]);
    }

    // Show edit form
    public function edit(Job $job)
    {
        $this->authorize('update', $job);
        return Inertia::render('Jobs/Edit', [
            'job' => $job,
        ]);
    }

    // Update job
    public function update(Request $request, Job $job)
    {
        $this->authorize('update', $job);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $job->update($data);

        return redirect()->route('jobs.show', $job)->with('success', 'Job updated successfully.');
    }

    // Delete job
    public function destroy(Job $job)
    {
        $this->authorize('delete', $job);
        $job->delete();

        return redirect()->route('jobs.index')->with('success', 'Job deleted.');
    }
}
