@extends('layouts.app')

@section('content')
<h2>Register</h2>

<form method="POST" action="{{ url('register') }}">
    @csrf
    <div><input name="name" value="{{ old('name') }}" placeholder="Full name" required></div>
    <div><input name="email" type="email" value="{{ old('email') }}" placeholder="Email" required></div>
    <div>
        <select name="role" required>
            <option value="student">Student</option>
            <option value="coordinator">Coordinator</option>
            <option value="supervisor">Supervisor</option>
            <option value="admin">Admin</option>
        </select>
    </div>
    <div><input name="password" type="password" placeholder="Password" required></div>
    <div><input name="password_confirmation" type="password" placeholder="Confirm Password" required></div>
    <div><button type="submit">Register</button></div>
</form>
@endsection