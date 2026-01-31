<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolYear;

class SchoolYearController extends Controller
{
    public function index()
    {
        $years = SchoolYear::orderBy('name','desc')->get();
        return view('admin.school-years.index', compact('years'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|unique:school_years,name',
            'active'=>'nullable|boolean'
        ]);

        if (!empty($data['active']) && $data['active']) {
            // deactivate others
            SchoolYear::query()->update(['active' => false]);
        }

        SchoolYear::create($data);

        return back()->with('success','School year created.');
    }

    public function toggleActive(SchoolYear $schoolYear)
    {
        SchoolYear::query()->update(['active' => false]);
        $schoolYear->update(['active' => true]);
        return back()->with('success','Active school year updated.');
    }
}