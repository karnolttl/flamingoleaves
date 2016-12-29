@extends('layouts.main')
@section('title', 'Contact')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <h1>Contact Me</h1>
      <hr>
      <form method="POST" action="">
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="email" placeholder="">
          </div>

          <div class="form-group">
            <label for="subject">Subject</label>
            <input type="text" class="form-control" id="subject" placeholder="">
          </div>

          <div class="form-group">
            <label for="message">Message:</label>
            <textarea type="text" class="form-control" id="message" placeholder="Type your message here..."></textarea>
          </div>

          <button type="submit" class="btn btn-success">Send Message</button>
      </form>
    </div>
  </div>
@endsection
