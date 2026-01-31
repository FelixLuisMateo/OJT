@extends('layouts.app')

@section('content')
<h2>Evaluation</h2>

@if($internship)
    <p>Status: {{ $internship->status }}</p>
    <p>Rendered hours: {{ $internship->rendered_hours }} / {{ $internship->required_hours }}</p>

    @if($canEvaluate)
        <p>The internship hours are complete. You may request evaluation or download certificate (if available).</p>
        <form method="POST" action="{{ route('student.certificate.generate') }}">
            @csrf
            <button type="submit">Generate Certificate</button>
        </form>
    @else
        <p>Evaluation locked until required hours are complete.</p>
    @endif

    <h3>Evaluations</h3>
    @forelse($evaluations as $ev)
        <div>
            <strong>By:</strong> {{ $ev->evaluator->name ?? '—' }} |
            <strong>Rating:</strong> {{ $ev->rating }} |
            <p>{{ $ev->comments }}</p>
        </div>
    @empty
        <p>No evaluations yet.</p>
    @endforelse
@else
    <p>You have no internship record.</p>
@endif
@endsection