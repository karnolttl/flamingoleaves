<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Post_detail;
use App\Comment;
use App\User;

class PageController extends Controller
{
    public function index()
    {
        $posts = Post::with('post_details', 'owner')->get();
        return view('posts.index', compact('posts'));
    }
    public function about()
    {
        return view('pages.about');
    }
    public function contact()
    {
        return view('pages.contact');
    }
    public function home()
    {
        return view('pages.home');
    }
}
