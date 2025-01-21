<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompraAutomatica extends Model
{
    protected $table = 'compras_automaticas';

    protected $fillable = [
        'product_id',
        'qtd',
        'popular'
    ];
}
