<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Repositories\PostRepositoryInterface;
use App\Post;
use App\Post_detail;
use App\User;
use App\Category;
use App\Tag;
use App\Img;
use Auth;
use Session;
use Image;
use Validator;

class PostController extends Controller
{

    protected $post;

    public function __construct(PostRepositoryInterface $post)
    {
        $this->post = $post;
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->post->getLatestPostsbyCurrentUserPaginated();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tagsAndCategories = $this->post->getAllTagsAndCategories();
        return view('posts.create', $tagsAndCategories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = $this->post->validatePost($request);

        if ($validator->fails()) {
            return redirect()->route('posts.create')
                             ->withErrors($validator)
                             ->withInput();
        }

        $postId = $this->post->SaveNewPostAndGetID($request);

        return redirect()->route('posts.show', $postId);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with('post_detail', 'owner', 'category')->find($id);
        if ($post == null || $post->owner_id != Auth::user()->id)
        {
            return redirect()->route('posts.index');
        }

        return view('posts.show', compact('post'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $tags = Tag::all();
        $post = Post::with('post_detail', 'owner')->find($id);

        if ($post == null || $post->owner_id != Auth::user()->id)
        {
            return redirect()->route('posts.index');
        }

        return view('posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validator = $this->post->validatePost($request, $id);

        if ($validator->fails()) {
            return redirect()->route('posts.edit', $id)
                             ->withErrors($validator)
                             ->withInput();
        }

        $post = $this->post->UpdatePostAndReturn($request, $id);
        return redirect()->route('posts.show', compact('post'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if ($post->owner_id != Auth::user()->id)
        {
            return redirect()->route('posts.index');
        }

        $post->tags()->detach();
        $post->delete();

        Session::flash('success', 'The post was succesfully deleted.');
        return redirect()->route('posts.index');
    }
}
