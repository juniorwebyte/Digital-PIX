<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Premio extends Model
{
    protected $fillable = [
        'product_id',
        'participant_id',
        'ordem',
        'telefone',
        'descricao',
        'ganhador',
        'cota',
        'foto'
    ];

    public function rifa()
    {
        return $this->hasOne(Product::class, 'id', 'product_id')->first();
    }

    public function participante()
    {
        if($this->participant_id != null){
            return $this->hasOne(Participante::class, 'id', 'participant_id')->first();
        }
        else{
            return new Participante();
        }
        
    }

    public function linkWpp()
    {
        $tel = "55" . str_replace(["(", ")", "-", " "], "", $this->telefone);
        $link = 'https://api.whatsapp.com/send?phone=' . $tel;

        return $link;
    }
}
