<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCat extends Model
{
    //
    protected $fillable = ['name', 'parent_id', 'url', 'status'];

    function products()
    {
        return $this->hasMany('App\Product');
    }
}
