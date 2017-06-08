<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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

class PostRepository implements PostRepositoryInterface {

    protected $img;

    public function __construct(ImgRepositoryInterface $img)
    {
        $this->img = $img;
    }

    public function getLatestPostsbyCurrentUserPaginated() {

        return Post::with('post_detail', 'owner', 'category')
                    ->where('owner_id', '=', Auth::user()->id)
                    ->orderBy('id', 'desc')
                    ->paginate(10);

    }

    public function getAllTagsAndCategories() {

        $categories = Category::all();
        $tags = Tag::all();

        return compact('categories', 'tags');
    }

    public function validatePost(Request $request, $id = null) {

        $validator = Validator::make($request->all(), array(
            'post_title' => 'required|max:255',
            'slug' => ['required', 'alpha_dash', 'min:5', 'max:255'],
            'category_id' => 'required|integer',
            'post_text' => ['required', 'max:1999'],
            'image' => 'image'
         ));

         $validator->after(function ($validator) use ($id, $request) {
             $post = Post::where('slug', '=', $request->slug)->get()->first();
             if (isset($post))
             {
                 if($post->id != $id)
                  $validator->errors()->add('slug', 'The slug must be unique.');
             }
             $img = Img::where('post_id',$id)->first();
             if (!isset($img) && !isset($request->image)) {
                 $validator->errors()->add('image', 'An image is required.');
             }
         });

        return $validator;
    }

    public function SaveNewPostAndGetID(Request $request) {

        // $post = new Post;
        // $post->post_title = $request->post_title;
        // $post->owner_id = Auth::user()->id;
        // $post->slug = $request->slug;
        // $post->category_id = $request->category_id;
        // $post->post_detail =
        // $post->save();

        $post = Post::create([
            'post_title' => $request->post_title,
            'owner_id' => Auth::user()->id,
            'slug' => $request->slug,
            'category_id' => $request->category_id,
        ]);

        Post_detail::create([
            'post_text' => $request->post_text,
            'post_id' => $post->id,
        ]);

        if (isset($request->tags)) {
            $post->tags()->syncWithoutDetaching($request->tags);
        }

        $this->img->saveImg($request, $post->id);

        Session::flash('success', 'The blog post was successfully saved!');

        return $post->id;
    }

    public function UpdatePostAndReturn(Request $request, $id) {

        $post = Post::with('post_detail', 'owner')->find($id);
        $post->post_title = $request->post_title;
        $post->slug = $request->slug;
        $post->category_id = $request->category_id;
        $post->post_detail->post_text = $request->post_text;
        $post->push();

        if (isset($request->tags)) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->sync([]);
        }

        $this->img->saveImg($request, $post->id);

        // set flash data with success message
        Session::flash('success', 'This post was successfully saved.');

        return $post;
    }

}
