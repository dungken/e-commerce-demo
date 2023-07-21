<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    //

    use SoftDeletes;
    //
    protected $fillable = ['name', 'price', 'desc', 'detail', 'thumbnail', 'cat_id', 'status'];

    function cat()
    {
        return $this->belongsTo('App\ProductCat');
    }
}
