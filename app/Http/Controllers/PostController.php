<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Post_detail;
use App\User;
use Auth;
use Session;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // create a variable and store all the blog posts in it from the database
        $posts = Post::with('post_details', 'owner')->get();

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
        return view('posts.create');
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
            'post_text' => 'required'
        ));
        // store in the database
        $post = new Post;
        $post->post_title = $request->post_title;
        $post->owner_id = Auth::user()->id;
        $post->save();

        $post_detail = new Post_detail;
        $post_detail->post_text = $request->post_text;
        $post_detail->sequence = 1; // TODO work out sequencing logic for long post_text
        $post_detail->post_id = $post->id;
        $post_detail->save();

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

        $post = Post::with('post_details', 'owner')->find($id);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

// process variable data or params
// talk to the model
// recieve from the model
// compile or process data form the model if needed
// pass that data to the correct view
