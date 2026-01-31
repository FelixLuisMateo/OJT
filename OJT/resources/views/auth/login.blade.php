@extends('layouts.app')

@section('content')
<h2>Sign In</h2>

<form method="POST" action="{{ url('login') }}">
    @csrf
    <div>
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
        @error('email') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div>
        <label>Password</label>
        <input type="password" name="password" required>
        @error('password') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div>
        <input type="checkbox" name="remember" id="remember">
        <label for="remember">Remember me</label>
    </div>

    <button type="submit">Sign In</button>
</form>

<p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
@endsection