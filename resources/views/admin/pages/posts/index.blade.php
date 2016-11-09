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
                        <h3>{{ $post->title }}</h3>
                        {{ $post->published_at->format('j F Y') }}
                        <p>{{ $post->intro }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@stop