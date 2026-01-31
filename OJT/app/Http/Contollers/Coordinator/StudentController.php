<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class StudentController extends Controller
{
    public function index()
    {
        $coordinator = auth()->user();
        $students = User::where('role','student')->where('course_id', $coordinator->course_id)->paginate(25);
        return view('coordinator.students.index', compact('students'));
    }

    public function show(User $student)
    {
        $coordinator = auth()->user();
        if ($student->course_id !== $coordinator->course_id) {
            abort(403);
        }
        return view('coordinator.students.show', compact('student'));
    }

    public function destroy(User $student)
    {
        $coordinator = auth()->user();
        if ($student->course_id !== $coordinator->course_id) {
            abort(403);
        }
        $student->delete();
        return redirect()->route('coordinator.students.index')->with('success','Student removed.');
    }
}