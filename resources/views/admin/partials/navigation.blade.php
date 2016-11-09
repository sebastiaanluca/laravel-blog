<nav class="navbar navbar-full navbar-light bg-faded">
    <div class="container">
        <div class="row">
            <div class="col-md-8 flex flex-items-md-middle">
                {{--<ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Active</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Separated link</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Disabled</a>
                    </li>
                </ul>--}}
                <ul class="nav navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('admin.posts.index') }}" title="Home">Posts <span class="tag tag-default">11</span> <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" title="Home">Media</a>
                    </li>
                </ul>
            </div>
            <div id="nav-user" class="col-md-4 flex flex-items-md-right">
                <ul class="nav navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" title="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="https://s3.amazonaws.com/uifaces/faces/twitter/adhamdannaway/128.jpg" alt="Your avatar" width="30" class="user-avatar img-rounded" /> Sebastiaan Luca
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#" title="End your session">Log out</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>