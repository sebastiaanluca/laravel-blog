@extends('blog::admin/layouts/master')

@section('title')
    Posts
@stop

@section('content')
    
    <h2>Posts</h2>
    
    @foreach($posts as $post)
    
        {{ $post->title }}
        
    @endforeach
@stop