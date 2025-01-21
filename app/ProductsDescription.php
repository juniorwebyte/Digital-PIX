<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductsDescription extends Model
{
    
    protected $fillable  = ['id', 'description', 'video'];
    
    /*public function product_description(){
        return $this->belongsTo(Product::class);
    }*/
}
