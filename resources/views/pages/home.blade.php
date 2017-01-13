@extends('layouts.main')
@section('title', 'Home')
@section('content')
    <div class="row">
      <div class="col-md-12">
          <div class="jumbotron">
              <h1>Welcome to the Flamingoleaves Blog!</h1>
              <p class="lead">Thank you so much for visiting. This is my test website built with Laravel. Please read the latest post.</p>
        </div>
      </div>
  </div> <!-- end of .row -->
  <div class="row">
      <div class="col-md-8">
          @foreach ($posts as $post)
              <div class="post">
                  <h3>{{ $post->post_title }}</h3>
                  <h5>Published: {{ date( 'M. j, Y', strtotime($post->created_at)) }} BY <em>{{ $post->owner->name}}</em></h5>
                  <p>{{ substr($post->post_details[0]->post_text, 0, 50) }}{{ strlen($post->post_details[0]->post_text) > 50 ? "..." : ""}}</p>
                  <a href="{{ route('blog.single', $post->slug) }}" class="btn btn-primary">Read More</a>
              </div>
              <hr>
          @endforeach
      </div>
      <div class="col-md-3 col-md-offset-1">
          <h2>Sidebar</h2>
      </div>
  </div>
@endsection
