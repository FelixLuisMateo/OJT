<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use App\Models\Internship; // later migration/model; scaffolded call here for structure

class InternshipController extends Controller
{
    public function index()
    {
        $coordinator = auth()->user();
        // internships will later be a model; for now return placeholder
        $internships = Internship::where('course_id', $coordinator->course_id)->with('student','supervisor')->paginate(20);
        return view('coordinator.internships.index', compact('internships'));
    }

    public function create()
    {
        $coordinator = auth()->user();
        $students = User::where('role','student')->where('course_id',$coordinator->course_id)->get();
        $supervisors = User::where('role','supervisor')->get();
        $courses = Course::all();
        return view('coordinator.internships.create', compact('students','supervisors','courses'));
    }

    public function store(Request $request)
    {
        $coordinator = auth()->user();

        $data = $request->validate([
            'student_id'=>'required|exists:users,id',
            'course_id'=>'required|exists:courses,id',
            'assignment_type'=>'required|in:internal,external',
            'supervisor_id'=>'required|exists:users,id',
            'start_date'=>'required|date',
            'location'=>'nullable|string',
        ]);

        // enforce coordinator only for their course
        if ($data['course_id'] != $coordinator->course_id) {
            abort(403);
        }

        $course = Course::findOrFail($data['course_id']);
        $required_hours = $data['assignment_type'] === 'internal' ? $course->internal_required_hours : $course->external_required_hours;

        $internship = Internship::create([
            'student_id'=>$data['student_id'],
            'course_id'=>$data['course_id'],
            'assignment_type'=>$data['assignment_type'],
            'supervisor_id'=>$data['supervisor_id'],
            'start_date'=>$data['start_date'],
            'location'=>$data['location'] ?? null,
            'status' => 'assigned',
            'required_hours' => $required_hours,
            'rendered_hours' => 0,
        ]);

        return redirect()->route('coordinator.internships.index')->with('success','Internship assigned.');
    }

    public function show(Internship $internship)
    {
        $coordinator = auth()->user();
        if ($internship->course_id != $coordinator->course_id) abort(403);
        $internship->load('student','supervisor','dtrs');
        return view('coordinator.internships.show', compact('internship'));
    }

    public function destroy(Internship $internship)
    {
        $coordinator = auth()->user();
        if ($internship->course_id != $coordinator->course_id) abort(403);
        $internship->delete();
        return redirect()->route('coordinator.internships.index')->with('success','Internship removed.');
    }
}