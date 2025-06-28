<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ResumeController extends Controller
{
    public function uploadForm()
    {
        $user = Auth::user();
        $filePath = $user->resume_path;

        return Inertia::render('Resume/Upload', [
            'filePath' => $filePath,
        ]);
    }

    public function analyzeForm()
    {
        return Inertia::render('Resume/Analyze');
    }

    public function store(Request $request)
{
    $request->validate([
        'resume' => 'required|mimes:pdf,doc,docx|max:2048',
    ]);

    $path = $request->file('resume')->store('resumes', 'public');

    $user = Auth::user();
    $user->resume_path = $path;
    $user->save();

    return redirect()->route('resume.upload')
                     ->with('success', 'Resume uploaded.')
                     ->with('filePath', $path);
}

    public function show()
    {
        $user = Auth::user();

        return Inertia::render('Resume/Upload', [
            'filePath' => $user->resume_path,
        ]);
    }
}
