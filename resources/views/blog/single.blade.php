@extends ('layouts.main')

@section('title', "$post->post_title")

@section('content')

    <div class="row">
      <div class="col-md-8 col-md-offset-2">
          <h1>{{ $post->post_title }}</h1>
          <p><p class="lead">@foreach ($post->post_details as $post_detail){!! (new Parsedown())->text($post_detail->post_text) !!}@endforeach</p></p>
          @if ($post->category != null)
              <hr>
              <p>Posted In:{{ $post->category->name }}</p>
          @endif

      </div>
    </div>

@endsection
