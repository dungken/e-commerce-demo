<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCat extends Model
{
    //
    protected $fillable = ['name', 'slug', 'parent_id', 'url', 'status'];

    function products()
    {
        return $this->hasMany('App\Product');
    }
}
