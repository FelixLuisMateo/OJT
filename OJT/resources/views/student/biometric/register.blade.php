@extends('layouts.app')

@section('content')
<h2>Register Biometric</h2>

<p>Note: This demo assumes a base64 string or template is sent from a biometric adapter.</p>

<form method="POST" action="{{ route('student.biometric.register.store') }}">
    @csrf
    <div>
        <label>Template (paste base64 / template string)</label>
        <textarea name="template" rows="5" required></textarea>
    </div>
    <div>
        <label>Device ID (optional)</label>
        <input type="text" name="device_id">
    </div>
    <button type="submit">Register</button>
</form>
@endsection