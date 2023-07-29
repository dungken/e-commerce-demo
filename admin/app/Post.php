<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    
    use SoftDeletes;
    //
    protected $fillable = ['title', 'slug', 'desc', 'thumbnail', 'content', 'cat_id', 'user_id', 'status'];

    function cat()
    {
        return $this->belongsTo('App\PostCat');
    }

    function user()
    {
        return $this->belongsTo('App\User');
    }
}
