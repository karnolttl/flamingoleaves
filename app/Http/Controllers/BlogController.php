<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Post_detail;
use App\User;
use Auth;

class BlogController extends Controller
{

    public function index()
    {
        $posts = Post::with('post_details', 'owner')->paginate(8);
        return view('blog.index', compact('posts'));
    }

    public function single($slug)
    {
        $post = Post::with('post_details', 'owner')->where('slug', '=', $slug)->first();
        return view('blog.single', compact('post'));
    }


}
