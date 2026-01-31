<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Internship;
use App\Models\User;

class AssignmentController extends Controller
{
    public function assignSupervisor(Request $request, Internship $internship)
    {
        $coordinator = auth()->user();

        if ($internship->course_id != $coordinator->course_id) abort(403);

        $data = $request->validate([
            'supervisor_id' => 'required|exists:users,id'
        ]);

        $internship->supervisor_id = $data['supervisor_id'];
        $internship->save();

        return back()->with('success','Supervisor assigned.');
    }

    public function setDepartment(Request $request, Internship $internship)
    {
        $coordinator = auth()->user();

        if ($internship->course_id != $coordinator->course_id) abort(403);

        $data = $request->validate(['department_id'=>'nullable|exists:departments,id','company_name'=>'nullable|string']);

        $internship->department_id = $data['department_id'] ?? null;
        $internship->company_name = $data['company_name'] ?? null;
        $internship->save();

        return back()->with('success','Assignment updated.');
    }
}