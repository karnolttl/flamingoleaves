@extends ('layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-10">
            <h1>All Posts</h1>
        </div>
        {{-- <div class="col-md-6 col-md-offset-3">
            <div class="list-group">
                @foreach ($posts as $post)
                    <div class="list-group-item">
                        <a href="/post/{{ $post->id }}">{{ $post->post_title }}</a>
                        <p>By {{ $post->owner->name }}</p>
                        <p>
                            @foreach ($post->post_details as $pd)
                                {{ $pd->post_text }}
                            @endforeach
                        </p>
                    </div>
                @endforeach
            </div>
        </div> --}}

        <div class="col-md-2">
            <a href="{{ route('posts.create') }}" class="btn btn-lg btn-block btn-primary">Create New Post</a>
        </div>
    </div>
@stop
