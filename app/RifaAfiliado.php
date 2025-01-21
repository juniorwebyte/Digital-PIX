<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RifaAfiliado extends Model
{
    protected $fillable = [
        'product_id',
        'afiliado_id',
        'token'
    ];
}
