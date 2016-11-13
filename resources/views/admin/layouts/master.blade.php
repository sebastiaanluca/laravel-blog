<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    
    <title>
        @hasSection('title')
            @yield('title') - Blog
        @else
            Blog
        @endif
    </title>
    
    {{-- Styles--}}
    {{-- TODO: vendors.css --}}
    {{--<link href="{{ elixir('vendors.css', 'assets') }}" rel="stylesheet" type="text/css">--}}
    <link href="{{ elixir('blog-admin.css', 'vendor/blog') }}" rel="stylesheet" type="text/css">
    @yield('styles')
</head>

<body class="@yield('bodyClass')">
    @include('blog::admin/partials/navigation')
    
    <div id="blog-admin">
        @yield('content')
    </div>
    
    @include('blog::admin/partials/footer')
    
    {{-- Scripts --}}
    {{--TODO--}}
    {{--<script src="{{ elixir('vendors.js', 'assets/vendor/blog') }}" defer></script>--}}
    <script src="{{ elixir('blog-admin.js', 'vendor/blog') }}" defer></script>
    @yield('scripts')
</body>
</html>