<footer class="container margin-top-xl">
    <div class="row">
        <div class="col-md-12">
            
            <nav class="nav nav-inline">
                {!! Form::open(['route' => 'blog::admin.auth.logout.post']) !!}
                <button type="submit" class="btn-link nav-link">Log out</button>
                {!! Form::close() !!}
            </nav>
        
        </div>
    </div>
</footer>