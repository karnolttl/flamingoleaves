@extends('layouts.main')

@section('title', 'Edit Category')

@section('content')
    {{ Form::model($category, ['route' => ['categories.update', $category->id], 'method' => 'PUT']) }}
        {{ Form::label('name', "Name:") }}
        {{ Form::text('name', null, ['class' => 'form-control']) }}

        {{ Form::submit('Save Changes', ['class' => 'btn btn-success btn-block']) }}
    {{ Form:: close() }}
@endsection
