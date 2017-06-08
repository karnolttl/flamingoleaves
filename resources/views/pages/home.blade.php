@extends('layouts.main')
@section('title', 'Home')
@section('content')
    <div class="masthead">
      <h1>Welcome to the <span class="logo-start">flamingo</span><span class="logo-end">leaves</span> Blog!</h1>
      <p class="lead">Thank you so much for visiting. This is my website built with Laravel. Please checkout the front-end goodness.</p>
    </div>
  @include('partials._index')
@endsection
