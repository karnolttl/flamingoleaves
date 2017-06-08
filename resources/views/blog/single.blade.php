@extends ('layouts.main')

@section('title', "$post->post_title")

@section('content')
      <div class="article">
          <img src="{{ asset('img') . '/' . $post->img->name }}" alt="" width="256">
          <h1>{{ $post->post_title }}</h1>
          <h5>Published: {{ date( 'M. j, Y', strtotime($post->created_at)) }} BY <em>{{ $post->owner->name}}</em></h5>
          {!! (new Parsedown())->text($post->post_detail->post_text) !!}
          <hr>
          @if ($post->category != null)
              <p>Posted In:{{ $post->category->name }}</p>
          @endif
          <div class="tags">
              @foreach ($post->tags as $tag)
                  <span class="label label-default">{{ $tag->name }}</span>
              @endforeach
          </div>
          <hr>
          @include('partials._disqus')
      </div>
@endsection
