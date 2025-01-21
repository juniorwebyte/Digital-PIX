<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class CreateProductimage extends Model
{
    protected $table = 'products_images';
    protected $fillable  = ['id', 'name', 'product_id '];

    public function produtos_imagen(){
        return $this->belongsTo(Product::class);
    }
}
