<nav class="l-nav">
  <ul>
    {{-- <li class="hr"><a id="l-nav-close" href="#">X</a></li> --}}
    <li class="l-nav-close"><span></span></li>
    <hr>
    <li><a href="/">Home</a></li>
    <li><a href="/blog">Blog</a></li>
    <li><a href="/about">About</a></li>
    <li><a href="/contact">Contact</a></li>
    <hr>
    @if (Auth::guest())
        <li><a href="{{ url('/login') }}">Login</a></li>
        <li><a href="{{ url('/register') }}">Register</a></li>
    @else
        <li>{{ Auth::user()->name }}</li>
        <li><a href="{{ url('/posts') }}">Posts</a></li>
        <li><a href="{{ route('categories.index') }}">Categories</a></li>
        <li><a href="{{ route('tags.index') }}">Tags</a></li>
        <li>
            <a href="{{ url('/logout') }}"
                onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                Logout
            </a>

            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>
        <hr>
    @endif
  </ul>
</nav>
