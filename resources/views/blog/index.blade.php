@extends('layouts.main')
@section('title', 'Index')
@section('content')
  <div class="row">
      <div class="col-md-8 col-md-offset-2">
          @foreach ($posts as $post)
              <div class="post">
                  <h2>{{ $post->post_title }}</h2>
                  <h5>Published: {{ date( 'M. j, Y', strtotime($post->created_at)) }} BY <em>{{ $post->owner->name}}</em></h5>
                  <p>{{ substr($post->post_details[0]->post_text, 0, 50) }}{{ strlen($post->post_details[0]->post_text) > 50 ? "..." : ""}}</p>
                  @if ($post->category != null)
                      <p>Posted In: <strong>{{ $post->category->name }}</strong></p>
                  @endif
                  <a href="{{ route('blog.single', $post->slug) }}" class="btn btn-primary">Read More</a>
              </div>
              <hr>
          @endforeach
      </div>
      <div class="col-md-12 text-center">
          {!! $posts->links(); !!}
      </div>

  </div>
@endsection
