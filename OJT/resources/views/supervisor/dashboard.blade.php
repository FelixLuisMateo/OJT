@extends('layouts.app')

@section('content')
<h2>Supervisor Dashboard</h2>
<p>Assigned internships: {{ $assignedCount ?? 0 }}</p>
<p>In progress: {{ $inProgress ?? 0 }}</p>

<p><a href="{{ route('supervisor.dtr.index') }}">Manage DTRs</a></p>
@endsection