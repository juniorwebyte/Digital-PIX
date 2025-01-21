<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promocao extends Model
{
    protected $table = 'promocoes';
    protected $fillable = [
        'qtdNumeros',
        'ordem',
        'desconto',
        'valor',
        'product_id'
    ];

    public function valorFormatted()
    {
        return number_format($this->valor, 2, ",", ".");
    }
}
