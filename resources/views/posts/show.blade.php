@extends('layouts.app')

@section('title', $post->title)
@section('description', Str::limit(strip_tags($post->body), 150))

@section('content')
    <h2>{{ $post->title }}</h2>
   
    <p>{{ $post->body }}</p>
    @if($post->image)
        <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" class="img-fluid mb-3">
    @endif
    <hr>

    <h4>Comments</h4>

    @if($post->comments->count())
        @foreach($post->comments as $comment)
            <div class="mb-3">
                <strong>{{ $comment->user->name }}</strong> <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                <p>{{ $comment->comment }}</p>
            </div>
        @endforeach
    @else
        <p>No comments yet.</p>
    @endif

    @auth
        <hr>
        <h5>Add a Comment</h5>
        <form action="{{ route('comments.store', $post->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <textarea name="comment" class="form-control" rows="3" required></textarea>
                @error('comment')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    @endauth

    @guest
        <p><a href="{{ route('login') }}">Login</a> to add a comment.</p>
    @endguest

    <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back to Posts</a>
@endsection
