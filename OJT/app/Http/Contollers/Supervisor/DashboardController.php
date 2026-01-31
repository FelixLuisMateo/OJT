<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Internship;

class DashboardController extends Controller
{
    public function index()
    {
        $supervisorId = auth()->id();
        $assignedCount = Internship::where('supervisor_id', $supervisorId)->count();
        $inProgress = Internship::where('supervisor_id', $supervisorId)->where('status','in_progress')->count();
        return view('supervisor.dashboard', compact('assignedCount','inProgress'));
    }
}