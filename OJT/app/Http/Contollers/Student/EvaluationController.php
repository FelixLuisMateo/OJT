<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Internship;
use App\Models\Evaluation;

class EvaluationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $internship = Internship::where('student_id', $user->id)->first();
        $evaluations = $internship ? $internship->evaluations()->with('evaluator')->get() : collect();
        $canEvaluate = $internship && $internship->rendered_hours >= $internship->required_hours;
        return view('student.evaluation.index', compact('internship','evaluations','canEvaluate'));
    }
}