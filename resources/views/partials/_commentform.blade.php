<form action="{{ route('comments.store') }}" method="POST">
    {{ csrf_field() }}

    {{ Form::hidden ('post_id', $post->id) }}
    {{ Form::hidden ('reply_id', $reply_id) }}

    <div class="form-group">
      <textarea id="text" name="text" class="form-control" placeholder="Type your comment here..."></textarea>
    </div>

    <button type="submit" value="Add Comment"class="btn btn-success">Add Comment</button>
</form>
