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
use App\Repositories\ImgRepositoryInterface;

class ProfileController extends Controller
{

    protected $img;

    public function __construct(ImgRepositoryInterface $img)
    {
        $this->middleware('auth');
        $this->img = $img;
    }

    public function display() {
        $user = Auth::user();
        return view('profile.display', compact('user'));
    }

    public function update(Request $request)
    {

        $this->validate($request, array (
            'image' => 'image'
        ));

        $this->img->saveImg($request);
        $user = Auth::user();
        return redirect()->route('profile.display', compact('user'));

    }
}
