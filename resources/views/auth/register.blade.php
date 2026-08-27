@extends('auth.layout')

@section('title', 'Create account')
@section('heading', 'Create your account')
@section('subtitle', 'Build a private flashcard collection of your own.')

@section('content')
    <form method="POST" action="{{ route('register.store') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control" required autofocus autocomplete="name">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required autocomplete="email">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password" class="form-control" required autocomplete="new-password">
            <div class="form-text">Use at least 8 characters.</div>
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Confirm password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
        </div>

        <button type="submit" class="btn btn-primary w-100">Create account</button>
    </form>

    <p class="text-center text-muted mt-4 mb-0">
        Already have an account? <a href="{{ route('login') }}">Sign in</a>
    </p>
@endsection
