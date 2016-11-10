@extends('blog::admin/layouts/master')

@section('title')
    {{ $post->title }} (edit)
@stop

@section('content')
    
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                
                <h2>{{ $post->title }} <span class="tag tag-small tag-default">edit</span></h2>
                
                <div class="margin-top-lg">
                    {!! Form::model($post, ['route' => ['admin.posts.store']]) !!}
                    
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            Please check your input and correct any errors.
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group {{ Html::highlightOnError('title') }}">
                                <label for="title" class="form-control-label">Title</label>
                                {!! Form::text('title', null, ['id' => 'title', 'class' => 'form-control', 'maxlength' => 80, 'required']) !!}
                                {!! Html::error('title') !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group {{ Html::highlightOnError('slug') }}">
                                <label for="slug" class="form-control-label">Slug</label>
                                {!! Form::text('slug', null, ['id' => 'slug', 'class' => 'form-control', 'maxlength' => 80, 'required']) !!}
                                {!! Html::error('slug') !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group {{ Html::highlightOnError('published_at') }}">
                                <label for="published_at" class="form-control-label">Publish date and time</label>
                                {{--TODO: add datetime + datepicker datetime option--}}
                                {!! Form::text('published_at', \Carbon\Carbon::now(), ['id' => 'published_at', 'class' => 'form-control', 'maxlength' => 9]) !!}
                                {!! Html::error('published_at') !!}
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group {{ Html::highlightOnError('is_draft') }}">
                                <label for="is_draft" class="form-control-label">Draft</label>
                                <div class="onoffswitch onoffswitch-form-control">
                                    {!! Form::hidden('is_draft', false) !!}
                                    {!! Form::checkbox('is_draft', true, true, ['id' => 'is_draft', 'class' => 'onoffswitch-checkbox']) !!}
                                    <label for="is_draft" class="onoffswitch-label"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group {{ Html::highlightOnError('body') }}">
                        {!! Form::textarea('body', null, ['id' => 'body', 'class' => 'form-control text-editor', 'maxlength' => 16383, 'rows' => 20, 'data-id' => 0]) !!}
                        {!! Html::error('body') !!}
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    
                    {!! Form::close() !!}
                </div>
            
            </div>
        </div>
    </div>

@stop