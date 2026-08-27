@extends('index')

@section('main')
    <h1 class="h2">Welcome, {{ auth()->user()->name }}</h1>
    <p class="text-muted">Manage your languages and practice your flashcards.</p>
@endsection
