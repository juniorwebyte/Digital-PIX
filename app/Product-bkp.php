<?php

namespace App;

use App\Models\DescricaoProduto;
use App\Models\Participante;
use App\Models\Raffle;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable  = ['id', 'name', 'slug', 'price', 'status', 'type_raffles', 'winner', 'draw_prediction', 'draw_date', 'visible', 'favoritar', 'minimo', 'maximo', 'expiracao', 'qtd_ranking', 'parcial', 'gateway', 'subname', 'qtd_zeros', 'modo_de_jogo'];
    public function produt_image()
    {
        return $this->hasMany('App\CreateProductimage', 'product_id', 'id');
    }

    public function imagem()
    {
        return $this->hasOne(CreateProductimage::class, 'product_id', 'id')->first();
    }

    public function descricao()
    {
        $desc = $this->hasOne(DescricaoProduto::class, 'product_id', 'id')->first();
        if($desc){
            return $desc->description;
        }
        else{
            return '';
        }
    }
    
    public function saveNumbers($numbersArray)
    {
        $arquivo = public_path() . '/numbers/' . $this->id . '.json';
        $req = fopen($arquivo, 'w') or die('Cant open the file');
        fwrite($req, json_encode($numbersArray));
        fclose($req);

        $arquivoDebug = public_path() . '/numbers/' . $this->id . '-debug1.json';
        $req = fopen($arquivoDebug, 'w') or die('Cant open the file');
        fwrite($req, json_encode($numbersArray));
        fclose($req);
    }

    public function numbers()
    {
        if ($this->modo_de_jogo == 'numeros') {
            $path = public_path() . '/numbers/' . $this->id . '.json';
            $jsonString = file_get_contents($path);
            $numbersRifa = json_decode($jsonString, true);

            return $numbersRifa;
        } else {
            return $this->hasMany(Raffle::class, 'product_id', 'id')->get();
        }
    }
   
    public function confirmPayment($participanteId)
    {
        if ($this->modo_de_jogo == 'numeros') {
            $participante = Participante::find($participanteId);

            $numbersParticipante = $participante->numbers();
            // $rifaNumbers = $participante->rifa()->numbers();

            // foreach ($numbersParticipante as $number) {
            //     $number->status = 'Pago';
            //     $rifaNumbers[$number->key]['status'] = 'Pago';
            // }

            $participante->update([
                // 'numbers' => json_encode($numbersParticipante),
                'reservados' => 0,
                'pagos' => count($numbersParticipante)
            ]);

        } else {
            $participante = Participante::find($participanteId);
            $numbersParticipante = $participante->numbers();

            $participante->update([
                'reservados' => 0,
                'pagos' => count($numbersParticipante)
            ]);


            Raffle::where('participant_id', '=', $participanteId)->update(['status' => 'Pago']);
        }
    }
}   
