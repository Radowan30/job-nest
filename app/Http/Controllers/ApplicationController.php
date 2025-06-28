<?php
// app/Http/Controllers/ApplicationController.php
namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    // Inertia page for applicant to view own applications
    public function index()
    {
        return Inertia::render('Applications/Index');
    }

    // Inertia page for company to view applications for a job
    public function indexByJob(Job $job)
    {
        // Only company that owns job can view its applications
        if (Auth::id() !== $job->company_id) {
            abort(403);
        }
        return Inertia::render('Applications/Index', ['jobId' => $job->id]);
    }

    // API: applicant applies to a job
    public function apiStore(Request $request)
    {
        $request->validate(['job_id' => 'required|exists:jobs,id']);
        $application = Application::firstOrCreate([
            'user_id' => Auth::id(),
            'job_id'  => $request->job_id,
        ], ['status' => 'pending']);
        return response()->json($application, 201);
    }

    // API: get current user's applications (applicant)
    public function apiIndex()
    {
        return Application::with('job')->where('user_id', Auth::id())->get();
    }

    // API: get applications for a given job (company)
    public function apiIndexByJob(Job $job)
    {
        if (Auth::id() !== $job->company_id) {
            abort(403);
        }
        return $job->applications()->with('user:id,name')->get();
    }
}
