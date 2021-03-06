<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post_detail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['post_text', 'post_id'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
