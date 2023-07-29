<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostCat extends Model
{
    //
    protected $fillable = ['name', 'slug', 'parent_id', 'url', 'status'];

    function posts()
    {
        return $this->hasMany('App\Post');
    }
}
