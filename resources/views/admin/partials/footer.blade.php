<footer class="container margin-top-xl">
    <div class="row">
        <div class="col-md-12">
            
            {{-- TODO: fix padding (check which class adds the padding)--}}
            <nav class="nav nav-inline">
                {!! Form::open(['route' => 'blog::admin.auth.logout.post']) !!}
                <button type="submit" class="btn-link nav-link padding-none text-muted">Log out</button>
                {!! Form::close() !!}
            </nav>
        
        </div>
    </div>
</footer>