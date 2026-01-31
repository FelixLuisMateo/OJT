@extends('layouts.app')

@section('content')
<h2>Admin Dashboard</h2>
<ul>
    <li>Courses: {{ $courses }}</li>
    <li>Departments: {{ $departments }}</li>
    <li>School Years: {{ $schoolYears }}</li>
</ul>
<p><a href="{{ route('admin.courses.index') }}">Manage Courses</a></p>
<p><a href="{{ route('admin.departments.index') }}">Manage Departments</a></p>
<p><a href="{{ route('admin.users.index') }}">User Management</a></p>
@endsection