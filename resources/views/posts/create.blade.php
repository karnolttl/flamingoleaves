@extends('layouts.main')

@section('title', 'Create New Post')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
@endsection

@section('content')
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <h1>Create New Post</h1>
        <hr>
        {!! Form::open(['route' => 'posts.store', 'data-parsley-validate' => '']) !!}
            {{ Form::label('post_title', 'Title:')}}
            {{ Form::text('post_title',  null, ['class' => 'form-control', 'required' => '', 'maxlength' => 255 ])}}

            {{ Form::label('slug', 'Slug:')}}
            {{ Form::text('slug',  null, ['class' => 'form-control', 'required' => '', 'minlength' => '5', 'maxlength' => '255' ])}}

            {{ Form::label('category_id', 'Category:')}}
            <select class="form-control" name="category_id">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>

            {{ Form::label('post_text', "Post Body:")}}
            {{ Form::textarea('post_text', null, ['class' => 'form-control', 'required' => ''])}}

            {{ Form::submit('Create Post', ['class' => 'btn btn-success btn-lg btn-block'])}}
        {!! Form::close() !!}
      </div>
    </div>
@endsection

@section('scripts')
    {!! Html::script('js/parsley.min.js') !!}
@endsection
