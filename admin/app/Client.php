<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    //
    use SoftDeletes;

    
    protected $fillable = ['code_order', 'code_client', 'name', 'email', 'phone', 'address', 'note', 'payment', 'status', 'num_order', 'total'];
}
