<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Environment extends Model
{
    protected $table = 'consulting_environments';

    protected $fillable = [
        'token_api_wpp'
    ];
}
