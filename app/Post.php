<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['post_title'];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function post_details()
    {
        return $this->hasMany(Post_detail::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function addComment(Comment $comment)
    {
        return $this->comments()->save($comment);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function imgs()
    {
        return $this->hasMany(Img::class);
    }
}
