<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Biometric;
use Illuminate\Support\Facades\Crypt;

class BiometricController extends Controller
{
    public function showRegister()
    {
        $user = auth()->user();
        if ($user->biometric_registered) {
            return back()->with('info','Biometric already registered.');
        }
        return view('student.biometric.register');
    }

    public function register(Request $request)
    {
        $user = auth()->user();
        if ($user->biometric_registered) {
            return back()->with('info','Biometric already registered.');
        }

        $data = $request->validate([
            'template' => 'required|string', // base64 or template string from adapter
            'device_id' => 'nullable|string'
        ]);

        // encrypt template before storing
        Biometric::create([
            'user_id' => $user->id,
            'template_data' => Crypt::encryptString($data['template']),
            'device_id' => $data['device_id'] ?? null,
            'registered_at' => now(),
        ]);

        $user->biometric_registered = true;
        $user->save();

        return redirect()->route('student.dashboard')->with('success','Biometric registered.');
    }
}