@extends ('layouts.main')

@section('title', "$post->post_title")

@section('content')
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
          <h1>{{ $post->post_title }}</h1>
          @foreach ($post->post_details as $post_detail)
              {!! (new Parsedown())->text($post_detail->post_text) !!}
          @endforeach
          <hr>
          @if ($post->category != null)
              <p>Posted In:{{ $post->category->name }}</p>
          @endif
          <div class="tags">
              @foreach ($post->tags as $tag)
                  <span class="label label-default">{{ $tag->name }}</span>
              @endforeach
          </div>
          @foreach ($post->imgs as $img)
              <a href="{{ route('image.show', $img->id) }}">
                  <img src="{{ asset('img') . '/' . $img->name }}" alt="" width="125">
              </a>
          @endforeach

          @include('partials._disqus')
          
      </div>
    </div>
@endsection
