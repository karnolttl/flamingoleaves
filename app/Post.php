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
    protected $fillable = ['post_title', 'owner_id', 'slug', 'category_id'];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function post_detail()
    {
        return $this->hasOne(Post_detail::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function img()
    {
        return $this->hasOne(Img::class);
    }
}
