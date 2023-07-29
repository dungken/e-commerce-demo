<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    //

    use SoftDeletes;
    //
    protected $fillable = ['name', 'product_code', 'slug', 'price', 'desc', 'detail', 'thumbnail', 'cat_id', 'status', 'qty_on_hand'];

    function cat()
    {
        return $this->belongsTo('App\ProductCat');
    }
}
