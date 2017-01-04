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
        $posts = Post::with('post_details', 'owner')->orderBy('id', 'desc')->paginate(10);

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
            'slug' => 'required|min:5|max:255',
            'post_text' => 'required'
        ));
        // store in the database
        $post = new Post;
        $post->post_title = $request->post_title;
        $post->owner_id = Auth::user()->id;
        $post->slug = $request->slug;
        $post->save();

        $post_texts = str_split($request->post_text, 20);
        $sequenceIndex = 0;
        foreach ($post_texts as $post_text) {
            $post_detail = new Post_detail;
            $post_detail->post_text = $post_text;
            $post_detail->sequence = $sequenceIndex++;
            $post_detail->post_id = $post->id;
            $post_detail->save();
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
        // find the post in the database and save as a var
        $post = Post::with('post_details', 'owner')->find($id);
        //return the view and pass in the var we previously created
        return view('posts.edit', compact('post'));
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
            'slug' => 'required|min:5|max:255',
            'post_text' => 'required'
        ));
        // save the data to the database
        $post = Post::with('post_details', 'owner')->find($id);
        $post->post_title = $request->input('post_title');
        $post->slug = $request->slug;

        $numOfPostDetails = $post->post_details->count();

        $post_texts = str_split($request->post_text, 20);
        $sequenceIndex = 0;

        foreach ($post_texts as $post_text) {
            if ($sequenceIndex >= $numOfPostDetails) {
                $post_detail = new Post_detail;
                $post_detail->post_text = $post_text;
                $post_detail->sequence = $sequenceIndex++;
                $post_detail->post_id = $post->id;
                $post_detail->save();
            }
            else {
                $post->post_details[$sequenceIndex++]->post_text = $post_text;
            }
        }

        $post->push();

        // set flash data with success message
        Session::flash('success', 'This post was successfully saved.');

        // redirect with flash data to posts.show
        return view('posts.show', compact('post'));

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
        $post->delete();

        Session::flash('success', 'The post was succesfully deleted.');
        return redirect()->route('posts.index');
    }
}

// process variable data or params
// talk to the model
// recieve from the model
// compile or process data form the model if needed
// pass that data to the correct view
