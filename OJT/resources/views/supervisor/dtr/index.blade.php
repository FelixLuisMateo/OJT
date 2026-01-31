@extends('layouts.app')

@section('content')
<h2>Assigned Internships</h2>

<table>
    <thead>
        <tr><th>Student</th><th>Course</th><th>Start</th><th>Action</th></tr>
    </thead>
    <tbody>
    @foreach($internships as $it)
        <tr>
            <td>{{ $it->student->name }}</td>
            <td>{{ $it->course->name ?? '—' }}</td>
            <td>{{ $it->start_date }}</td>
            <td><a href="{{ route('supervisor.dtr.show', $it->id) }}">View DTRs</a></td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $internships->links() }}
@endsection