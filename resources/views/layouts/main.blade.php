<!DOCTYPE html>
<html>
    <head>
        @include('partials._head')
    </head>
    <body>
        <div class="mycontainer">
            @include('partials._l-nav')
            <div class="mycontainer-inner">
                @include('partials._t-nav')
                @include('partials._messages')
                @yield('content')
                @include('partials._footer')
                @include('partials._javascript')
                @yield('scripts')
            </div>
        </div>
    </body>
</html>
