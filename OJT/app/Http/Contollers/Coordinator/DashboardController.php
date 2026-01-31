<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $courseId = $user->course_id;

        // basic stats for the coordinator's course
        $studentCount = User::where('course_id', $courseId)->where('role','student')->count();
        // internships and other data are added later
        return view('coordinator.dashboard', compact('studentCount'));
    }
}