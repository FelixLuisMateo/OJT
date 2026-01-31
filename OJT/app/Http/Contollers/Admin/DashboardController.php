<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Department;
use App\Models\SchoolYear;

class DashboardController extends Controller
{
    public function index()
    {
        $courses = Course::count();
        $departments = Department::count();
        $schoolYears = SchoolYear::count();

        return view('admin.dashboard', compact('courses','departments','schoolYears'));
    }
}