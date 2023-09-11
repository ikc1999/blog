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
            <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($blogs as $blog)
                    <tr>
                        <td>{{ $blog->title }}</td>
                        <td>{{ $blog->description }}</td>
                        <td>{{ $blog->start_date }}</td>
                        <td>{{ $blog->end_date }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" width="100">
                        </td>
                        <td>
                            <a href="{{ route('blogs.edit', ['id' => $blog->id]) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('blogs.destroy', ['blog' => $blog->id]) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                            @if ($blog->is_active == 1)
                                <form action="{{ route('blogs.deactivate', ['id' => $blog->id]) }}" method="get" style="display: inline;">
                                    <button type="submit" class="btn btn-success">Activate</button>
                                </form>
                            @else
                                <form action="{{ route('blogs.activate', ['id' => $blog->id]) }}" method="get" style="display: inline;">
                                    <button type="submit" class="btn btn-warning">Deactivate</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection
