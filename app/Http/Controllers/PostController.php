<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Post;
use App\Post_detail;
use App\User;
use App\Category;
Use App\Tag;
use Auth;
use Session;


class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // create a variable and store all the blog posts in it from the database
        $posts = Post::with('post_details', 'owner', 'category')->where('owner_id', '=', Auth::user()->id)->orderBy('id', 'desc')->paginate(10);

        // return a view and pass in the above variable
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the data (server-side)
        $this->validate($request, array(
            'post_title' => 'required|max:255',
            'slug' => 'required|alpha_dash|min:5|max:255|unique:posts',
            'category_id' => 'required|integer',
            'post_text' => 'required'
        ));
        // store in the database
        $post = new Post;
        $post->post_title = $request->post_title;
        $post->owner_id = Auth::user()->id;
        $post->slug = $request->slug;
        $post->category_id = $request->category_id;
        $post->save();

        $post_texts = str_split($request->post_text, 2000);
        $sequenceIndex = 0;
        foreach ($post_texts as $post_text) {
            $post_detail = new Post_detail;
            $post_detail->post_text = $post_text;
            $post_detail->sequence = $sequenceIndex++;
            $post_detail->post_id = $post->id;
            $post_detail->save();
        }

        if (isset($request->tags)) {
            $post->tags()->syncWithoutDetaching($request->tags);
        }


        Session::flash('success', 'The blog post was successfully saved!');

        // redirect to another page
        return redirect()->route('posts.show', $post->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with('post_details', 'owner', 'category')->find($id);
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
        $post = Post::with('post_details', 'owner')->find($id);

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
        // validate the data
        $this->validate($request, array(
            'post_title' => 'required|max:255',
            'slug' => ['required', 'alpha_dash', 'min:5', 'max:255', Rule::unique('posts')->ignore($id)],
            'category_id' => 'required|integer',
            'post_text' => 'required'
        ));

        $post = Post::with('post_details', 'owner')->find($id);
        $post->post_title = $request->post_title;
        $post->slug = $request->slug;
        $post->category_id = $request->category_id;
        $numOfPostDetails = $post->post_details->count();

        // split text into 2000 character chunks for Post_detail entries
        $post_texts = str_split($request->post_text, 2000);
        $sequenceIndex = 0;

        // update and add Post_detail objects if edited Post contains same or more text
        foreach ($post_texts as $post_text) {
            if ($sequenceIndex >= $numOfPostDetails) {
                $post_detail = new Post_detail;
                $post_detail->post_text = $post_text;
                $post_detail->sequence = $sequenceIndex++;
                $post_detail->post_id = $post->id;
                $post_detail->save();
                $post->post_details->add($post_detail);
            }
            else {
                $post_detail = $post->post_details->where('sequence', '=', $sequenceIndex++)->first();
                $post_detail->post_text = $post_text;
                $post_detail->save();
            }
        }

        // remove old Post_detail if updated Post contains less text
        for ($i=$numOfPostDetails-1; $i >= $sequenceIndex ; $i--) {
            $post->post_details->where('sequence', '=', $i)->first()->delete();
            $post->post_details->pop();
        }

        $post->save();

        if (isset($request->tags)) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->sync([]);
        }

        // set flash data with success message
        Session::flash('success', 'This post was successfully saved.');

        // redirect with flash data to posts.show
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
