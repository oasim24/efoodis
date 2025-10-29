@extends('admin.layouts.app')

@section('title', 'Home Page')

@section('content')
    <div class="text-center">
        <h1>Welcome to {{ config('app.name') }}</h1>
        <p>This is your homepage content.</p>
    </div>
@endsection