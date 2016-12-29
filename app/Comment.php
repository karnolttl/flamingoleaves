<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['text'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

}
