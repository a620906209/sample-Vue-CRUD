<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $table = "product";
    protected $fillable = [
      'id','product_name','product_price','product_type'
    ];
    public $timestamps = true;
}
