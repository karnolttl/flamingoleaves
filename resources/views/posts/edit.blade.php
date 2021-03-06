@extends ('layouts.main')

@section('title', 'Edit Post')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('css/select2.min.css') !!}
@endsection

@section('content')
    <div class="row">
        {!! Form::open(['route' => ['posts.update', $post->id], 'data-parsley-validate' => '', 'files' => true]) !!}
        {{ method_field('PUT') }}
        <div class="col-md-8">
            {{ Form::label('post_title', 'Title:')}}
            {{ Form::text('post_title',  $post->post_title, ['class' => 'form-control', 'required' => '', 'maxlength' => 255 ])}}

            {{ Form::label('slug', 'Slug:')}}
            {{ Form::text('slug',  $post->slug, ['class' => 'form-control', 'required' => '', 'minlength' => '5', 'maxlength' => '255' ])}}

            {{ Form::label('category_id', 'Category:')}}
            <select class="form-control" name="category_id">
                @foreach ($categories as $category)
                    <option @if ($category->id == $post->category_id)selected="selected"@endif value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>

            {{ Form::label('tags', 'Tags:')}}
            <select class="form-control select2-multi" name="tags[]" multiple="mulitple">
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>

            {{ Form::label('image', 'Upload A Different Featured Image:')}}
            {{ Form::file('image') }}

            {{ Form::label('post_text', "Post Body:")}}
            <textarea class="form-control" required="" name="post_text" cols="50" rows="10" id="post_text">{{ $post->post_detail->post_text }}</textarea>

            <div class="col-md-8">
                <div class="row">
                    <h3>Featured Image</h3>
                    <img src="{{ asset('img') . '/' . $post->img->name }}" alt="" width="256">
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="well">
                <dl class="dl-horizontal">
                  <label>Url:</label>
                  <p><a href="{{ route('blog.single', $post->slug) }}">{{ route('blog.single', $post->slug) }}</a></p>
                </dl>
                <dl class="dl-horizontal">
                  <label>Created At:</label>
                  <p>{{ date( 'M. j, Y g:i a', strtotime($post->created_at)) }}</p>
                </dl>
                <dl class="dl-horizontal">
                  <label>Last Updated:</label>
                  <p>{{ date( 'M. j, Y g:i a', strtotime($post->updated_at)) }}</p>
                </dl>
                <hr>
                <div class="row">
                  <div class="col-sm-6">
                      {!! Html::linkRoute('posts.show', 'Cancel', [$post->id], ['class' => 'btn btn-danger btn-block']) !!}
                  </div>
                  <div class="col-sm-6">
                      {{ Form::submit('Save Changes', ['class' => 'btn btn-success btn-block']) }}
                  </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('scripts')
    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('js/select2.min.js') !!}

    <script type="text/javascript">
        var multi = $('.select2-multi').select2();
        multi.val({!! json_encode($post->tags()->getRelatedIds()) !!}).trigger('change');
    </script>
@endsection
