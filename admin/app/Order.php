<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['product_id', 'client_id', 'qty', 'price', 'sub_total'];
    
}
