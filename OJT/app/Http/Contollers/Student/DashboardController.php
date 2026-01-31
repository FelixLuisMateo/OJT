<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Internship;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $internship = Internship::where('student_id', $user->id)->latest()->first();
        return view('student.dashboard', compact('internship'));
    }
}