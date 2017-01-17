@extends('layouts.main')

@section('title', "$category->name Category")

@section('content')
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ $category->name }} Category <small>{{ $category->posts->count() }} Post(s)</small></h1>
            </div>
        </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <table class="table">
            <thead>
                <th>#</th>
                <th>Title</th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($category->posts as $post)
                    <tr>
                        <th>{{ $post->id }}</th>
                        <td>{{ $post->post_title }}</td>
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
                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary btn-block btn-h1-spacing">Edit</a>
            </div>
            <div class="col-md-12">
                {{ Form::open(['route' => ['categories.destroy', $category->id], 'method' => 'DELETE']) }}
                    {{ Form::submit('Delete', ['class' => 'btn btn-danger bten block']) }}
                {{ Form::close() }}
            </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            {!! Html::linkRoute('categories.index', '<< See All Categories', [], ['class' => 'btn btn-default btn-block btn-h1-spacing']) !!}
          </div>
        </div>
    </div>

@endsection
