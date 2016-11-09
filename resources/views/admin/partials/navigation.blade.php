<nav class="navbar navbar-full navbar-light bg-faded margin-bottom-lg">
    <div class="container">
        <div class="row">
            <div class="col-md-8 flex flex-items-md-middle">
                <ul class="nav navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('admin.posts.index') }}" title="Posts">Posts <span class="tag tag-default">11</span> <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" title="Media">Media</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" title="Settings">Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" title="Account">Account</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-4 text-md-right">
                <a class="btn btn-primary" href="{{ route('admin.posts.create') }}" title="Write a new post">Write</a>
            </div>
        </div>
    </div>
</nav>