<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Post;
use App\Post_detail;
use App\User;
use Session;

class PageController extends Controller
{
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
        $posts = Post::with('post_details', 'owner')
                            ->orderBy('id', 'desc')
                            ->take(5)
                            ->get();
        return view('pages.home', compact('posts'));
    }
    public function postContact(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'subject' => 'required|min:3',
            'message' => 'required|min:10',
        ]);

        $data = [
            'email' => $request->email,
            'subject' => $request->subject,
            'messageBody' => $request->message,
        ];

        Mail::send('emails.contact', $data, function ($message) use ($data) {
            $message->from($data['email']);
            $message->to('hello@flamingoleaves.com');
            $message->subject($data['subject']);
        });

        Session::flash('success', 'Thanks for the message!');
        return redirect()->route('pages.home');
    }
}
