<div class="post-container">
    @foreach ($posts as $post)
        <div class="post">
            <img src="{{ asset('img') . '/' . $post->img->name }}" alt="" width="256">
            <h2>{{ $post->post_title }}</h2>
            <h5>Published: {{ date( 'M. j, Y', strtotime($post->created_at)) }} BY <em>{{ $post->owner->name}}</em></h5>
            <p>
                {!! (new Parsedown())->text(substr($post->post_detail->post_text, 0, 50)) !!}
                {{ strlen($post->post_detail->post_text) > 50 ? "..." : ""}}
            </p>
            @if ($post->category != null)
                <p>Posted In: <strong>{{ $post->category->name }}</strong></p>
            @endif
            <div class="tags">
                @foreach ($post->tags as $tag)
                    <span class="label label-default">{{ $tag->name }}</span>
                @endforeach
            </div>
            <br>
            <a href="{{ route('blog.single', $post->slug) }}" class="button">Read More</a>
        </div>
    @endforeach
    @if (Request::is('/'))
        <div class="post">
            <hr>
            <a href="{{ route('blog.index') }}" class="button">See All Posts</a>
        </div>
    @endif
</div>

@if ($posts instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="col-md-12 text-center">
        {!! $posts->links(); !!}
    </div>
@else

@endif
