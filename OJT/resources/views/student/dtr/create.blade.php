@extends('layouts.app')

@section('content')
<h2>Submit DTR (Manual)</h2>

<form method="POST" action="{{ route('student.dtr.store') }}" enctype="multipart/form-data">
    @csrf
    <div>
        <label>Date</label>
        <input type="date" name="date" required>
    </div>
    <div>
        <label>Time In (HH:MM)</label>
        <input type="time" name="time_in">
    </div>
    <div>
        <label>Time Out (HH:MM)</label>
        <input type="time" name="time_out">
    </div>
    <div>
        <label>Break Minutes</label>
        <input type="number" name="break_minutes" min="0" value="0">
    </div>
    <div>
        <label>Upload DTR (optional)</label>
        <input type="file" name="dtr_file" accept=".pdf,.jpg,.png">
    </div>
    <button type="submit">Submit</button>
</form>
@endsection