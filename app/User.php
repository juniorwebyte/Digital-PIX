<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'telephone', 'status', 'password','cpf', 'pix', 'afiliado'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function totalGanhos()
    {
        if($this->afiliado == false){
            return 0;
        }
        else{
            $total = GanhosAfiliado::where('afiliado_id', '=', $this->id)->sum('valor');

            return $total;
        }
    }
}
