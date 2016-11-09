@extends('blog::admin/layouts/master')

@section('title')
    Add a new post
@stop

@section('content')
    
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                
                <h2>New post</h2>
                
                <div class="margin-top-lg">
                    {!! Form::open(['route' => ['admin.posts.store']]) !!}
                    
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            Please check your input and correct any errors.
                        </div>
                    @endif
                    
                    <div class="form-group {{ Html::highlightOnError('title') }}">
                        <label for="title" class="form-control-label">Title</label>
                        {!! Form::text('title', null, ['id' => 'title', 'class' => 'form-control', 'maxlength' => 80, 'required']) !!}
                        {!! Html::error('title') !!}
                    </div>
                    
                    <div class="form-group {{ Html::highlightOnError('slug') }}">
                        <label for="slug" class="form-control-label">Slug</label>
                        {!! Form::text('slug', null, ['id' => 'slug', 'class' => 'form-control', 'maxlength' => 80, 'required']) !!}
                        {!! Html::error('slug') !!}
                    </div>
                    
                    {{--
                    <div class="form-group form-optional {{ Html::highlightOnError('end_at') }}">
                        <label for="end_at" class="form-control-label">Deadline</label>
                        {!! Form::date('end_at', null, ['id' => 'end_at', 'class' => 'form-control', 'maxlength' => 9]) !!}
                        {!! Html::error('end_at') !!}
                    </div>
                    --}}
                    
                    <div class="form-group {{ Html::highlightOnError('body') }}">
                        {!! Form::textarea('body', null, ['id' => 'reason', 'class' => 'form-control', 'maxlength' => 16383, 'rows' => 20]) !!}
                        {!! Html::error('body') !!}
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Create</button>
                    
                    {!! Form::close() !!}
                </div>
            
            </div>
        </div>
    </div>

@stop