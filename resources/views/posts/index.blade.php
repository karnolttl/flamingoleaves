@extends ('layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-10">
            <h1>All Posts</h1>
        </div>
        <div class="col-md-2">
            <a href="{{ route('posts.create') }}" class="button">Create New Post</a>
        </div>
        <div class="col-md-12">
          <hr>
        </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <table class="table">
            <thead>
                <th>#</th>
                <th>Title</th>
                <th>Body</th>
                <th>Category</th>
                <th>Created At</th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <th>{{ $post->id }}</th>
                        <td>{{ $post->post_title }}</td>
                        <td>
                            {!! (new Parsedown())->text(substr($post->post_detail->post_text, 0, 50)) !!}
                            {{ strlen($post->post_detail->post_text) > 50 ? "..." : ""}}
                        </td>
                        <td>{{ $post->category->name }}</td>
                        <td>{{ date('M j, Y', strtotime($post->created_at)) }}</td>
                        <td><a href="{{ route('posts.show', $post->id) }}" class="btn btn-default btn-sm">View</a> <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-default btn-sm">Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-center">
            {!! $posts->links(); !!}
        </div>
      </div>
    </div>

@stop
