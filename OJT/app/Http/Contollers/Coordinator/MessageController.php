<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message; // scaffolded later
use App\Models\User;

class MessageController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $messages = Message::where('to_user_id', $user->id)->orWhere('from_user_id', $user->id)->latest()->paginate(25);
        return view('coordinator.messages.index', compact('messages'));
    }

    public function create()
    {
        $coordinator = auth()->user();
        // coordinator can message students from their course
        $students = User::where('role','student')->where('course_id', $coordinator->course_id)->get();
        return view('coordinator.messages.create', compact('students'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'to_user_id'=>'required|exists:users,id',
            'subject'=>'required|string',
            'body'=>'required|string',
        ]);

        $data['from_user_id'] = auth()->id();
        Message::create($data);

        // Add notification in the future
        return redirect()->route('coordinator.messages.index')->with('success','Message sent.');
    }
}