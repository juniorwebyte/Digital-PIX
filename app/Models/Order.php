<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';

    protected $fillable = [
        'key_pix',
        'participant_id',
        'dados',
        'valor'
    ];
}
