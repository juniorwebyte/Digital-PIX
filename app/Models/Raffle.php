<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Raffle extends Model
{
    protected $table = 'raffles';

    public function rifa()
    {
        return $this->hasOne(Product::class, 'id', 'product_id')->first();
    }

    public function participante()
    {
        return $this->hasOne(Participante::class, 'id', 'participant_id')->first();
    }

    public function statusFormated()
    {
        switch ($this->status) {
            case 'Disponível':
            case 'Disponivel':
                return 'disponivel';
                break;
            case 'Reservado':
                return 'reservado';
                break;
            case 'Pago':
                return 'pago';
                break;

            default:
                return '';
                break;
        }
    }

    public function onlyGroup()
    {
        $x = explode("-", $this->number);

        return $x[0];
    }

    public function groupSide()
    {
        $x = explode("-", $this->number);

        return $x[1];
    }

    public function numeroLD()
    {
        $ld = $this->onlyGroup() . '-ld';
        $numero = Raffle::where('product_id', '=', $this->product_id)->where('number', '=', $ld)->first();

        return $numero;
        
    }

    public function grupoFazendinha()
    {
        $x = explode("-", $this->number);

        switch ($x[0]) {
            case 'g1':
                $grupo = 'avestruz';
                break;
            case 'g2':
                $grupo = 'aguia';
                break;
            case 'g3':
                $grupo = 'burro';
                break;
            case 'g4':
                $grupo = 'borboleta';
                break;
            case 'g5':
                $grupo = 'cachorro';
                break;
            case 'g6':
                $grupo = 'cabra';
                break;
            case 'g7':
                $grupo = 'carneiro';
                break;
            case 'g8':
                $grupo = 'camelo';
                break;
            case 'g9':
                $grupo = 'cobra';
                break;
            case 'g10':
                $grupo = 'coelho';
                break;
            case 'g11':
                $grupo = 'cavalo';
                break;
            case 'g12':
                $grupo = 'elefante';
                break;
            case 'g13':
                $grupo = 'galo';
                break;
            case 'g14':
                $grupo = 'gato';
                break;
            case 'g15':
                $grupo = 'jacare';
                break;
            case 'g16':
                $grupo = 'leao';
                break;
            case 'g17':
                $grupo = 'macaco';
                break;
            case 'g18':
                $grupo = 'porco';
                break;
            case 'g19':
                $grupo = 'pavao';
                break;
            case 'g20':
                $grupo = 'peru';
                break;
            case 'g21':
                $grupo = 'toro';
                break;
            case 'g22':
                $grupo = 'tigre';
                break;
            case 'g23':
                $grupo = 'urso';
                break;
            case 'g24':
                $grupo = 'veado';
                break;
            case 'g25':
                $grupo = 'vaca';
                break;
            default:
                $grupo = '';
                break;
        }

        if(count($x) > 1){
            return $grupo . '-' . $x[1];
        }
        else{
            return $grupo;
        }
    }
}
