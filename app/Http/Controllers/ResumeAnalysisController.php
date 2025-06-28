<?php
// app/Http/Controllers/ResumeAnalysisController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResumeAnalysisController extends Controller
{
    public function analyze(Request $request)
    {
        // Dummy static job matches; in real app, analyze resume content
        return response()->json([
            'matches' => [
                ['title' => 'Software Engineer', 'score' => 95],
                ['title' => 'Frontend Developer', 'score' => 88],
                ['title' => 'Backend Developer', 'score' => 82],
            ],
        ]);
    }
}
