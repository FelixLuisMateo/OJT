<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Department;
use App\Models\SchoolYear;

class FilterController extends Controller
{
    public function filters()
    {
        $courses = Course::orderBy('name')->get(['id','name']);
        $departments = Department::orderBy('name')->get(['id','name']);
        $schoolYears = SchoolYear::orderBy('name','desc')->get(['id','name','active']);

        return response()->json([
            'courses'=>$courses,
            'departments'=>$departments,
            'school_years'=>$schoolYears,
        ]);
    }
}