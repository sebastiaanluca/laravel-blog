@extends('blog::admin/layouts/public')

@section('title')
    Login
@stop

@section('content')
    <div class="container margin-top-xl">
        <div class="row">
            <div class="offset-md-4 col-md-4">
                
                <div class="card">
                    <h2 class="card-header">Login</h2>
                    <div class="card-block">
                        {!! Form::open(['route' => 'blog::admin.auth.login.post']) !!}
                        
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <p class="margin-none">Invalid e-mail address and/or password.</p>
                            </div>
                        @endif
                        
                        {!! Form::hidden('remember', true) !!}
                        
                        <div class="form-group {{ Html::highlightOnError('email') }}">
                            <label for="email" class="form-control-label">E-mail</label>
                            {!! Form::email('email', null, ['id' => 'email', 'class' => 'form-control', 'required', 'maxlength' => 180, 'placeholder' => 'Your e-mail address', 'required', 'autofocus']) !!}
                        </div>
                        
                        <div class="form-group {{ Html::highlightOnError('password') }}">
                            <label for="password" class="form-control-label">Password</label>
                            {!! Form::password('password', ['id' => 'password', 'class' => 'form-control', 'required', 'placeholder' => 'Your password', 'required']) !!}
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-submit">Log in</button>
                        
                        {!! Form::close() !!}
                    </div>
                </div>
            
            </div>
        </div>
    </div>
@stop