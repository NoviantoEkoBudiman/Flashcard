@extends('auth.layout')

@section('title', 'Sign in')
@section('heading', 'Welcome back')
@section('subtitle', 'Sign in to continue learning with your flashcards.')

@section('content')
    <form method="POST" action="{{ route('login.attempt') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus autocomplete="email">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password" class="form-control" required autocomplete="current-password">
        </div>

        <div class="form-check mb-4">
            <input id="remember" type="checkbox" name="remember" class="form-check-input">
            <label for="remember" class="form-check-label">Remember me</label>
        </div>

        <button type="submit" class="btn btn-primary w-100">Sign in</button>
    </form>

    <p class="text-center text-muted mt-4 mb-0">
        Don't have an account? <a href="{{ route('register') }}">Create one</a>
    </p>
@endsection
