@extends('layouts.app')

@section('content')
<h2>Student Dashboard</h2>

@if($internship)
    <p>Assigned: {{ $internship->assignment_type }} at {{ $internship->location }}</p>
    <p>Rendered hours: {{ $internship->rendered_hours }} / {{ $internship->required_hours }}</p>
    <p><a href="{{ route('student.dtr.index') }}">My DTRs</a></p>
    <p><a href="{{ route('student.biometric.register') }}">Register Biometric</a></p>
    <p><a href="{{ route('student.evaluation.index') }}">Evaluation</a></p>
@else
    <p>No active internship assigned yet.</p>
@endif
@endsection