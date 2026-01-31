<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Internship;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function generate(Internship $internship, Request $request)
    {
        // type: application, endorsement, waiver, resume, moa, dtr
        $type = $request->get('type','application');

        // ensure coordinator is authorized
        $coordinator = auth()->user();
        if ($internship->course_id != $coordinator->course_id) abort(403);

        $data = [
            'student' => $internship->student,
            'internship' => $internship,
            'coordinator' => $coordinator,
        ];

        // render blade template (resources/views/documents/templates/{type}.blade.php)
        $html = View::make("documents.templates.{$type}", $data)->render();

        // Save the rendered HTML or convert to PDF using DOMPDF in future
        $filename = "documents/{$internship->id}_{$type}_" . now()->format('YmdHis') . ".html";
        Storage::disk('local')->put($filename, $html);

        // TODO: create Document model record linking to internship (Document::create(...))

        return response()->download(storage_path("app/{$filename}"));
    }
}