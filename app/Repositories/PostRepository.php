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

class PostRepository {

    public function getLatestPostsbyCurrentUserPaginated() {

        return Post::with('post_details', 'owner', 'category')
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
            'post_text' => 'required',
            'images.*' => 'image'
         ));

         $validator->after(function ($validator) use ($id, $request) {
             $post = Post::where('slug', '=', $request->slug)->get()->first();
             if ($post != null)
             {
                 if($post->id != $id)
                  $validator->errors()->add('slug', 'The slug must be unique.');
             }
         });

        return $validator;
    }

    public function SaveNewPostAndGetID(Request $request) {

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

        if ($request->hasFile('images')) {
            $i = 1;
            foreach ($request->images as $image) {
                $filename = time() . $i++ . '.' . $image->getClientOriginalExtension();
                $location = public_path('img/' . $filename);
                Image::make($image)
                    ->resize(null, 400, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();})
                    ->save($location);

                Img::create([
                    'name' => $filename,
                    'owner_id' => Auth::user()->id,
                    'post_id' => $post->id,
                ]);
            }
        }

        Session::flash('success', 'The blog post was successfully saved!');

        return $post->id;
    }

    public function UpdatePostAndReturn(Request $request, $id) {

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

        if ($request->hasFile('images')) {
            $i = 1;
            foreach ($request->images as $image) {
                $filename = time() . $i++ . '.' . $image->getClientOriginalExtension();
                $location = public_path('img/' . $filename);
                Image::make($image)
                    ->resize(null, 400, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();})
                    ->save($location);

                Img::create([
                    'name' => $filename,
                    'owner_id' => Auth::user()->id,
                    'post_id' => $post->id,
                ]);
            }
        }

        // set flash data with success message
        Session::flash('success', 'This post was successfully saved.');

        return $post;
    }

}
