                                                                                                                         @extends ('layouts.main')

@section('title', 'View Image')

@section('content')
    <div class="col-md-8">
        <img src="{{ asset('img') . '/' . $img->name }}" alt="" width="400">
    </div>

    <div class="col-md-4">
        <div class="well">
            <dl class="dl-horizontal">
              <label>Post:</label>
              <p>{{ $post->post_title }}</p>
            </dl>
            <dl class="dl-horizontal">
              <label>Created At:</label>
              <p>{{ date( 'M. j, Y g:i a', strtotime($img->created_at)) }}</p>
            </dl>
            <dl class="dl-horizontal">
              <label>Last Updated:</label>
              <p>{{ date( 'M. j, Y g:i a', strtotime($img->updated_at)) }}</p>
            </dl>
            <hr>
            <div class="row">
              <div class="col-sm-12">
                  {!! Form::open(['route' => ['image.destroy', $img->id], 'method' => 'DELETE']) !!}

                  {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block']) !!}

                  {!! Form::close() !!}
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                {!! Html::linkRoute('posts.show', '<< Back to Post', [$img->post_id], ['class' => 'btn btn-default btn-block btn-h1-spacing']) !!}
              </div>
            </div>
        </div>
    </div>
@endsection
