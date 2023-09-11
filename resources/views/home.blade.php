@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Blog Posts</h1>
            <a href="{{ route('blog.create') }}" class="btn btn-primary">Add Blog</a> <!-- Add Blog Button -->
            @if ($blogs->count() > 0)
                <ul>
                    @foreach ($blogs as $blog)
                        <li>
                            <h2>{{ $blog->title }}</h2>
                            <p>{{ $blog->description }}</p>
                            <p>Start Date: {{ $blog->start_date }}</p>
                            <p>End Date: {{ $blog->end_date }}</p>
                            <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" width="200">
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No blog posts available.</p>
            @endif
        </div>
    </div>
</div>
@endsection
