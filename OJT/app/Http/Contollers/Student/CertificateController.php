<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Internship;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function generate()
    {
        $user = auth()->user();
        $internship = Internship::where('student_id', $user->id)->firstOrFail();

        if ($internship->rendered_hours < $internship->required_hours) {
            return back()->withErrors('Required hours not yet completed.');
        }

        $data = [
            'student' => $user,
            'internship' => $internship,
        ];

        $html = View::make('documents.templates.certificate', $data)->render();
        $filename = "documents/generated/certificate_{$user->id}_" . now()->format('YmdHis') . ".html";
        Storage::put($filename, $html);

        return response()->download(storage_path("app/{$filename}"));
    }
}