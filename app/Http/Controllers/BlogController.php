<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Post_detail;
use App\User;
use Auth;
use App\Repositories\CommentRepository;
use Debugbar;

class BlogController extends Controller
{
    protected $comment;

    public function __construct(CommentRepository $comment)
    {
        $this->comment = $comment;
    }

    public function index()
    {
        $posts = Post::with('post_details', 'owner', 'category')->orderBy('id', 'desc')->paginate(8);
        return view('blog.index', compact('posts'));
    }

    public function single($slug, $reply_id = null)
    {
        $post = Post::with('post_details', 'owner', 'category')->where('slug', '=', $slug)->first();
        $comments = $post->comments()->orderBy('reply_id', 'ASC')->orderBy('id', "ASC")->get();
        //return $comments->pull(2);
        return $this->comment->sortComments($comments);


        return view('blog.single', compact('post', 'reply_id', 'comments'));
    }

}
