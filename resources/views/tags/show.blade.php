@extends('layouts.main')

@section('title', "$tag->name Tag")

@section('content')
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ $tag->name }} Tag <small>{{ $tag->posts->count() }} Post(s)</small></h1>
            </div>
        </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <table class="table">
            <thead>
                <th>#</th>
                <th>Title</th>
                <th>Tags</th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($tag->posts as $post)
                    <tr>
                        <th>{{ $post->id }}</th>
                        <td>{{ $post->post_title }}</td>
                        <td>@foreach ($post->tags as $tag)<span class="label label-default">{{ $tag->name }}</span> @endforeach</td>
                        <td><a href="{{ route('posts.show', $post->id) }}" class="btn btn-default btn-sm">View</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
      </div>
    </div>

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('tags.edit', $tag->id) }}" class="btn btn-primary btn-block btn-h1-spacing">Edit</a>
            </div>
            <div class="col-md-12">
                {{ Form::open(['route' => ['tags.destroy', $tag->id], 'method' => 'DELETE']) }}
                    {{ Form::submit('Delete', ['class' => 'btn btn-danger bten block']) }}
                {{ Form::close() }}

            </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            {!! Html::linkRoute('tags.index', '<< See All Tags', [], ['class' => 'btn btn-default btn-block btn-h1-spacing']) !!}
          </div>
        </div>
    </div>

@endsection
