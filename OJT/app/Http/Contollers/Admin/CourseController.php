<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::paginate(20);
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code'=>'required|unique:courses,code|max:20',
            'name'=>'required|string|max:255',
            'internal_required_hours'=>'required|integer|min:0',
            'external_required_hours'=>'required|integer|min:0',
        ]);

        Course::create($data);

        return redirect()->route('admin.courses.index')->with('success','Course created.');
    }

    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'code'=>'required|max:20|unique:courses,code,'.$course->id,
            'name'=>'required|string|max:255',
            'internal_required_hours'=>'required|integer|min:0',
            'external_required_hours'=>'required|integer|min:0',
        ]);

        $course->update($data);

        return redirect()->route('admin.courses.index')->with('success','Course updated.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success','Course deleted.');
    }
}