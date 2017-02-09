<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use App\Comment;
use Auth;
use Session;

class CommentRepository {

    public function saveComment(Request $request)
    {
        $comment = new Comment;
        $comment->text = $request->text;
        $comment->post_id = $request->post_id;
        $comment->owner_id = Auth::user()->id;
         if ($request->reply_id != null) {
             $comment->reply_id = $request->reply_id;
        }

        $comment->save();

        return $comment->post->slug;

    }

    public function sortComments(Collection $comments){

        if ($comments->isEmpty()) {
            return null;
        }

        //TODO implement a better solution that the unfinished one below

        $index = 0;
        $sorted = false;
        $sortedComments = new Collection;
        $sortedComments->push($comments->pull($index++));

        while (!$sorted) {
            if ($comments->filter()->isEmpty()) {
                $sorted = true;
                break;
            }

            foreach ($comments as $key => $comment) {
                if ($sortedComments[$index]->id == $comment->reply_id) {
                    $sortedComments->push($comments->pull($key));
                    $index++;
                }
            }
        }

        return $sortedComments;
    }
}
