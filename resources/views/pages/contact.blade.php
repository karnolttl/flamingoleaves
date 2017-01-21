@extends('layouts.main')
@section('title', 'Contact')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <h1>Contact Me</h1>
      <hr>
      <form action="{{ route('pages.postcontact') }}" method="POST">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="email">Email:</label>
            <input id="email" name="email" class="form-control" placeholder="">
          </div>

          <div class="form-group">
            <label for="subject">Subject</label>
            <input id="subject" name="subject" class="form-control" placeholder="">
          </div>

          <div class="form-group">
            <label name="message">Message:</label>
            <textarea id="message" name="message" class="form-control" placeholder="Type your message here..."></textarea>
          </div>

          <button type="submit" value="Send Message"class="btn btn-success">Send Message</button>
      </form>
    </div>
  </div>
@endsection
