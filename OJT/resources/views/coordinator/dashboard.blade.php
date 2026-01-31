@extends('layouts.app')

@section('content')
<h2>Coordinator Dashboard</h2>
<p>Students in your course: {{ $studentCount }}</p>
<p><a href="{{ route('coordinator.students.index') }}">View Students</a></p>
<p><a href="{{ route('coordinator.internships.index') }}">Manage Internships</a></p>
@endsection