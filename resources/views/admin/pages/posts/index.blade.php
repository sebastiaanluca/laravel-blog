@extends('blog::admin/layouts/master')

@section('title')
    Posts
@stop

@section('content')
    
    <div class="container m-t-2">
        <div class="row post-cards-list">
            
            @foreach($posts as $post)
                
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-block">
                            <h3 class="card-title">
                                <a href="{{ route('blog::admin.posts.edit', $post->id) }}" title="Edit this post">{{ $post->title }}</a>
                                @if($post->is_draft)
                                    <span class="tag tag-default tag-outline">draft</span>
                                @endif
                            </h3>
                            
                            <p class="card-text ">{{ $post->intro ? str_limit($post->intro, 300) : str_limit($post->body, 300) }}</p>
                            
                            <p class="card-text margin-bottom-none d-inline-block">
                                <small class="text-muted" title="{{ $post->published_at->format('j F Y H:i') }}">{{ $post->published_at->diffForHumans() }}</small>
                            </p>
                            
                            <div class="dropdown d-inline-block float-right">
                                <button class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fa fa-gear"></span></button>
                                <div class="dropdown-menu">
                                    <h6 class="dropdown-header">Options</h6>
                                    <a class="dropdown-item" href="#">View</a>
                                    <a class="dropdown-item" href="{{ route('blog::admin.posts.edit', $post->id) }}">Edit</a>
                                    
                                    {!! Form::open(['route' => ['blog::admin.posts.update', $post->id]]) !!}
                                    {{ method_field('PUT') }}
                                    {!! Form::hidden('is_draft', (int)! $post->is_draft) !!}
                                    <button type="submit" class="dropdown-item">@if($post->is_draft) Publish @else Mark as draft @endif</button>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        
                        </div>
                    </div>
                </div>
            
            @endforeach
        
        </div>
    </div>

@stop