                                                                                                                         @extends ('layouts.main')

@section('title', 'View Post')

@section('content')
    <div class="col-md-8">
        <h1>{{ $post->post_title }}</h1>
        <p class="lead">@foreach ($post->post_details as $post_detail){{ $post_detail->post_text }}@endforeach</p>
    </div>

    <div class="col-md-4">
        <div class="well">
            <dl class="dl-horizontal">
              <dt>Created At:</dt>
              <dd>{{ date( 'M. j, Y g:i a', strtotime($post->created_at)) }}</dd>
              <dt>Last Updated:</dt>
              <dd>{{ date( 'M. j, Y g:i a', strtotime($post->updated_at)) }}</dd>
            </dl>
            <hr>
            <div class="row">
              <div class="col-sm-6">
                  {!! Html::linkRoute('posts.edit', 'Edit', [$post->id], ['class' => 'btn btn-primary btn-block']) !!}
              </div>
              <div class="col-sm-6">
                  {!! Form::open(['route' => ['posts.destroy', $post->id], 'method' => 'DELETE']) !!}

                  {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block']) !!}

                  {!! Form::close() !!}
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                {!! Html::linkRoute('posts.index', '<< See All Posts', [], ['class' => 'btn btn-default btn-block btn-h1-spacing']) !!}
              </div>
            </div>
        </div>
    </div>
@endsection
