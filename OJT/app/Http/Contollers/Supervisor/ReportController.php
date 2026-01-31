<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;

class ReportController extends Controller
{
    public function sendReport(Request $request)
    {
        $data = $request->validate([
            'to_user_id'=>'required|exists:users,id',
            'subject'=>'required|string',
            'body'=>'required|string',
            'related_internship_id'=>'nullable|exists:internships,id'
        ]);

        $data['from_user_id'] = auth()->id();
        Message::create($data);

        return back()->with('success','Report sent to coordinator/student.');
    }
}