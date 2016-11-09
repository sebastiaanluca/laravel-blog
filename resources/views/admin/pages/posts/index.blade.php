@extends('blog::admin/layouts/master')

@section('title')
    Posts
@stop

@section('content')
    
    <h2>Posts</h2>
    
    @foreach($posts as $post)
        <div>
            <h3>{{ $post->title }}</h3>
            {{ $post->published_at->format('j F Y') }}
            <p>{{ $post->intro }}</p>
        </div>
    @endforeach
@stop