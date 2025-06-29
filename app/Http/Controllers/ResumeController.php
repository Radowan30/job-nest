<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

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
        $resume = DB::table('resumes')->where('user_id', Auth::id())->first();
        return Inertia::render('Resume/Analyze', [
            'resume' => $resume
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'resume_text' => 'required|string',
        ]);

        $resumeText = preg_replace('/\s+/', ' ', $request->resume_text);

        DB::table('resumes')->updateOrInsert(
            ['user_id' => Auth::id()],
            ['resume_text' => $resumeText]
        );

        return back()->with('message', 'Resume saved!');
    }

    public function show()
    {
        $user = Auth::user();

        return Inertia::render('Resume/Upload', [
            'filePath' => $user->resume_path,
        ]);
    }
}
