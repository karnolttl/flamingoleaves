@extends ('layouts.main')

@section('title', 'Edit Post')

@section('content')
    <div class="row">
        {!! Form::open(['route' => ['posts.update', $post->id], 'data-parsley-validate' => '']) !!}
        {{ method_field('PUT') }}
        <div class="col-md-8">
            {{ Form::label('post_title', 'Title:')}}
            {{ Form::text('post_title',  $post->post_title, ['class' => 'form-control', 'required' => '', 'maxlength' => 255 ])}}

            {{ Form::label('slug', 'Slug:')}}
            {{ Form::text('slug',  $post->slug, ['class' => 'form-control', 'required' => '', 'minlength' => '5', 'maxlength' => '255' ])}}

            {{ Form::label('post_text', "Post Body:")}}
            <textarea class="form-control" required="" name="post_text" cols="50" rows="10" id="post_text">@foreach ($post->post_details as $post_detail){{ $post_detail->post_text }}@endforeach</textarea>
            {{-- {{ Form::textarea('post_text', '', ['class' => 'form-control', 'required' => ''])}} --}}
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
                      {!! Html::linkRoute('posts.show', 'Cancel', [$post->id], ['class' => 'btn btn-danger btn-block']) !!}
                  </div>
                  <div class="col-sm-6">
                      {{ Form::submit('Save Changes', ['class' => 'btn btn-success btn-block']) }}
                  </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection