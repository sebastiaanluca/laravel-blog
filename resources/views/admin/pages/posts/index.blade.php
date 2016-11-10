@extends('blog::admin/layouts/master')

@section('title')
    Posts
@stop

@section('content')
    
    <div class="container m-t-2">
        @foreach($posts as $post)
            <div class="row">
                <div class="col-md-12">
                    
                    <div>
                        <h3>
                            <a href="{{ route('admin.posts.edit', $post->id) }}" title="Edit this post">{{ $post->title }}</a>
                            @if($post->is_draft)
                                <span class="tag tag-default">draft</span>
                            @endif
                        </h3>
                        {{ $post->published_at->format('j F Y') }}
                        <p>{{ $post->intro }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@stop