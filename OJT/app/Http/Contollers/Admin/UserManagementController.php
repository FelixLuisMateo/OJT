<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('course','department')->paginate(25);
        $courses = Course::all();
        $departments = Department::all();
        return view('admin.users.index', compact('users','courses','departments'));
    }

    public function create()
    {
        $courses = Course::all();
        $departments = Department::all();
        return view('admin.users.create', compact('courses','departments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|confirmed|min:6',
            'role'=>'required|in:admin,coordinator,supervisor,student',
            'course_id'=>'nullable|exists:courses,id',
            'department_id'=>'nullable|exists:departments,id',
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('admin.users.index')->with('success','User created.');
    }

    public function edit(User $user)
    {
        $courses = Course::all();
        $departments = Department::all();
        return view('admin.users.edit', compact('user','courses','departments'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users,email,'.$user->id,
            'role'=>'required|in:admin,coordinator,supervisor,student',
            'course_id'=>'nullable|exists:courses,id',
            'department_id'=>'nullable|exists:departments,id',
            'password'=>'nullable|confirmed|min:6',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success','User updated.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success','User deleted.');
    }
}