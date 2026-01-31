<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Internship;
use App\Models\Dtr;
use Illuminate\Support\Facades\Storage;

class DTRController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $internship = Internship::where('student_id', $user->id)->first();
        if (!$internship) return view('student.dtr.none');

        $dtrs = $internship->dtrs()->orderBy('date','desc')->paginate(20);
        return view('student.dtr.index', compact('internship','dtrs'));
    }

    public function create()
    {
        return view('student.dtr.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $internship = Internship::where('student_id', $user->id)->firstOrFail();

        $data = $request->validate([
            'date'=>'required|date',
            'time_in'=>'nullable|date_format:H:i',
            'time_out'=>'nullable|date_format:H:i',
            'break_minutes'=>'nullable|integer|min:0',
            'source'=>'nullable|in:manual_entry,manual_upload',
            'dtr_file'=>'nullable|file|mimes:pdf,jpg,png'
        ]);

        if ($request->hasFile('dtr_file')) {
            $path = $request->file('dtr_file')->store('dtr_uploads');
            $data['uploaded_file_path'] = $path;
            $data['source'] = 'manual_upload';
        }

        // calculate hours if time_in and time_out provided
        $hours = 0;
        if (!empty($data['time_in']) && !empty($data['time_out'])) {
            $in = \Carbon\Carbon::createFromFormat('H:i', $data['time_in']);
            $out = \Carbon\Carbon::createFromFormat('H:i', $data['time_out']);
            $diff = $out->floatDiffInHours($in);
            $break = $data['break_minutes'] ?? 0;
            $hours = max(0, round($diff - ($break/60), 2));
        }

        $dtr = Dtr::create([
            'internship_id'=>$internship->id,
            'date'=>$data['date'],
            'time_in'=>$data['time_in'] ?? null,
            'time_out'=>$data['time_out'] ?? null,
            'break_minutes'=>$data['break_minutes'] ?? 0,
            'hours'=>$hours,
            'source'=>$data['source'] ?? 'manual_entry',
            'uploaded_file_path'=>$data['uploaded_file_path'] ?? null,
            'status'=>'pending',
        ]);

        return redirect()->route('student.dtr.index')->with('success','DTR submitted.');
    }
}