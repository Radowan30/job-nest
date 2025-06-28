<?php
// app/Http/Controllers/ResumeController.php
namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ResumeController extends Controller
{
    // Inertia page to upload/view resume
    public function uploadForm()
    {
        return Inertia::render('Resume/Upload');
    }
    public function analyzeForm()
    {
        return Inertia::render('Resume/Analyze');
    }

    // API: store uploaded resume file
    public function apiStore(Request $request)
    {
        $request->validate(['resume' => 'required|file|mimes:pdf,doc,docx']);
        $path = $request->file('resume')->store('resumes');
        $resume = Resume::updateOrCreate(
            ['user_id' => Auth::id()],
            ['file_path' => $path]
        );
        return response()->json(['file_path' => $path], 201);
    }

    // API: get current user's resume info
    public function apiShow()
    {
        $resume = Auth::user()->resume;
        return $resume ? ['file_path' => $resume->file_path] : ['file_path' => null];
    }
}
