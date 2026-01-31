<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Internship;
use App\Models\Evaluation;

class EvaluationController extends Controller
{
    public function create(Internship $internship)
    {
        if ($internship->supervisor_id !== auth()->id()) abort(403);
        return view('supervisor.evaluations.create', compact('internship'));
    }

    public function store(Request $request, Internship $internship)
    {
        if ($internship->supervisor_id !== auth()->id()) abort(403);

        $data = $request->validate([
            'rating'=>'required|integer|min:1|max:5',
            'comments'=>'nullable|string',
        ]);

        Evaluation::create([
            'internship_id' => $internship->id,
            'evaluator_id' => auth()->id(),
            'rating' => $data['rating'],
            'comments' => $data['comments'] ?? null,
        ]);

        // Optionally mark internship completed if ratings given after completion
        return redirect()->route('supervisor.dtr.index')->with('success','Evaluation submitted.');
    }
}