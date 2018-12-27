<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $timestamps = false;

    protected $table = 'cart';

    // product_id => products.id
    public function product(){
    	return $this->belongsTo(Product::class);
    }
}
