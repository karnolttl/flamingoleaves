@extends ('layouts.main')

@section('title', 'Profile')

@section('content')
    <div class="col-md-8">
        <img src="{{ asset('img') . '/' . $user->img }}" alt="" width="256">
        <h1>{{ $user->name }}</h1>
        <p>{{ $user->email }}</p>
        {!! Form::open(['route' => ['profile.update'], 'data-parsley-validate' => '', 'files' => true]) !!}
            {{ method_field('PUT') }}
            {{ Form::label('image', 'Upload A Different Profile Image:')}}
            {{ Form::file('image') }}

    </div>

    <div class="col-md-4">
        <div class="well">
            <dl class="dl-horizontal">
              <label>Member Since:</label>
              <p>{{ date( 'M. j, Y g:i a', strtotime($user->created_at)) }}</p>
            </dl>
            <div class="row">
              <div class="col-md-12">
                  {{ Form::submit('Save Changes', ['class' => 'btn btn-success btn-block hidden']) }}
                  {!! Form::close() !!}
                  {!! Html::linkRoute('posts.index', '<< See All Posts', [], ['class' => 'btn btn-default btn-block btn-h1-spacing']) !!}
              </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/profile.js"></script>
@endsection
