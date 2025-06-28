<?php
// app/Http/Controllers/JobController.php
namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class JobController extends Controller
{
    use \Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    // Inertia pages (web routes)
    public function index()
    {
        return Inertia::render('Jobs/Index');
    }
    public function create()
    {
        return Inertia::render('Jobs/Create');
    }
    public function edit(Job $job)
    {
        // Only company that owns job can edit
        $this->authorize('update', $job);
        return Inertia::render('Jobs/Edit', ['jobId' => $job->id]);
    }
    public function show(Job $job)
    {
        return Inertia::render('Jobs/Show', ['jobId' => $job->id]);
    }

    // API endpoints (JSON)
    public function apiIndex()
    {
        // List all jobs
        return Job::with('company:id,name')->get();
    }
    public function apiShow(Job $job)
    {
        return $job->load('company:id,name');
    }
    public function apiStore(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);
        $data['company_id'] = Auth::id();
        $job = Job::create($data);
        return response()->json($job, 201);
    }
    public function apiUpdate(Request $request, Job $job)
    {
        $this->authorize('update', $job);
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);
        $job->update($data);
        return response()->json($job);
    }
    public function apiDelete(Job $job)
    {
        $this->authorize('delete', $job);
        $job->delete();
        return response()->noContent();
    }
}

