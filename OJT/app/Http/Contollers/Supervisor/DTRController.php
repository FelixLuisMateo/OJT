<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Internship;
use App\Models\Dtr;

class DTRController extends Controller
{
    public function index()
    {
        $supervisorId = auth()->id();
        $internships = Internship::where('supervisor_id', $supervisorId)->with('student')->paginate(20);
        return view('supervisor.dtr.index', compact('internships'));
    }

    public function showInternshipDtrs(Internship $internship)
    {
        $this->authorizeAccess($internship);
        $dtrs = $internship->dtrs()->orderBy('date','desc')->get();
        return view('supervisor.dtr.manage', compact('internship','dtrs'));
    }

    public function approveDtr(Request $request, Dtr $dtr)
    {
        $internship = $dtr->internship;
        $this->authorizeAccess($internship);

        $dtr->status = 'approved';
        $dtr->save();

        // recalc internship hours
        $this->recalculateInternshipHours($internship);

        return back()->with('success','DTR approved.');
    }

    public function rejectDtr(Request $request, Dtr $dtr)
    {
        $internship = $dtr->internship;
        $this->authorizeAccess($internship);

        $request->validate(['notes'=>'nullable|string']);
        $dtr->status = 'rejected';
        $dtr->notes = $request->notes;
        $dtr->save();

        return back()->with('success','DTR rejected.');
    }

    protected function authorizeAccess(Internship $internship)
    {
        if ($internship->supervisor_id !== auth()->id()) abort(403);
    }

    protected function recalculateInternshipHours(Internship $internship)
    {
        $sum = $internship->dtrs()->where('status','approved')->sum('hours');
        $internship->rendered_hours = $sum;
        if ($internship->rendered_hours >= $internship->required_hours) {
            $internship->status = 'completed';
        } elseif ($internship->rendered_hours > 0) {
            $internship->status = 'in_progress';
        }
        $internship->save();
    }
}