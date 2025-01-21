<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolicitacaoAfiliado extends Model
{
    protected $fillable = [
        'afiliado_id',
        'pago'
    ];

    public function afiliado()
    {
        return $this->hasOne(User::class, 'id', 'afiliado_id')->first();
    }

    public function valor()
    {
        $total = GanhosAfiliado::where('solicitacao_id', '=', $this->id)->sum('valor');

        return $total;

    }

    public function status()
    {
        if($this->pago){
            return '<span class="badge bg-success">PAGO</span>';
        }
        else{
            return '<span class="badge bg-warning">PENDENTE</span>';
        }
    }
}
