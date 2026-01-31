@extends('layouts.app')

@section('content')
<h2>DTRs for {{ $internship->student->name }}</h2>

<table>
    <thead>
        <tr><th>Date</th><th>In</th><th>Out</th><th>Hours</th><th>Status</th><th>Actions</th></tr>
    </thead>
    <tbody>
    @foreach($dtrs as $dtr)
        <tr>
            <td>{{ $dtr->date->format('Y-m-d') }}</td>
            <td>{{ $dtr->time_in }}</td>
            <td>{{ $dtr->time_out }}</td>
            <td>{{ $dtr->hours }}</td>
            <td>{{ $dtr->status }}</td>
            <td>
                @if($dtr->status === 'pending')
                <form action="{{ route('supervisor.dtr.approve', $dtr->id) }}" method="POST" style="display:inline">@csrf<button>Approve</button></form>
                <form action="{{ route('supervisor.dtr.reject', $dtr->id) }}" method="POST" style="display:inline">@csrf<button>Reject</button></form>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection