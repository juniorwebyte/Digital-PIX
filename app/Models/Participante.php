<?php

namespace App\Models;

use App\Payment_pix;
use App\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Participante extends Model
{
    protected $table = 'participant';

    protected $fillable = [
        'numbers',
        'reservados',
        'pagos',
        'conferido',
        'msg_pago_enviada'
    ];

    public function reservados()
    {
        if($this->rifa()->modo_de_jogo == 'numeros'){
            $reservados = [];
            if($this->reservados > 0){
                $reservados = $this->numbers();
            }

            return $reservados;
        }
        else{
            return $this->hasMany(Raffle::class, 'participant_id', 'id')->where('status', '=', 'Reservado')->get();
        }
    }

    public function qtdReservados()
    {
        if($this->rifa()->modo_de_jogo == 'numeros'){
            return $this->reservados;
        }
        else{
            return $this->reservados()->count();
        }
    }

    public function numbers()
    {
        $numbers = json_decode($this->numbers);
        sort($numbers);
        return $numbers;
    }

    public function numbersResumo()
    {
        $numbers = $this->numbers();

        $numbersRelatorio = '';
        foreach ($numbers as $key => $number) {
            if($key > 0){
                $numbersRelatorio .= ', ';
            }
            $numbersRelatorio .= $number;
        }

        return $numbersRelatorio;
    }

    public function status()
    {
        if($this->reservados > 0){
            return 'Números Reservados';
        }
        else if($this->pagos > 0){
            return 'Compra Aprovada';
        }
    }

    public function statusBadge()
    {
        if($this->reservados > 0){
            return '<span class="badge bg-warning">Pendente</span>';
        }
        else if($this->pagos > 0){
            return '<span class="badge bg-success">Pago</span>';
        }
    }

    public function situacao()
    {
        if($this->qtdReservados() > 0){
            return 'reservado';
        }
        else if($this->qtdPagos() > 0){
            return 'pago';
        }
    }

    public function qtdPagos()
    {
        if($this->rifa()->modo_de_jogo == 'numeros'){
            $oldNumbers = $this->hasMany(Raffle::class, 'participant_id', 'id')->where('status', '=', 'Pago')->get();
            if($oldNumbers->count() > 0){
                return $oldNumbers->count();
            }
            else{
                return $this->pagos;
            }
            
        }
        else{
            return $this->pagos()->count();
        }
    }

    public function pagos()
    {
        if($this->rifa()->modo_de_jogo == 'numeros'){
            $oldNumbers = $this->hasMany(Raffle::class, 'participant_id', 'id')->where('status', '=', 'Pago')->get();

            if($oldNumbers->count() > 0 && count($this->numbers()) == 0){ // Estrutura antiga (antes do 1 milhao)
                $pagos = $this->hasMany(Raffle::class, 'participant_id', 'id')->where('status', '=', 'Pago')->get();
            }
            else{
                $pagos = [];
                if($this->pagos > 0){
                    $pagos = $this->numbers();
                }
            }

            return $pagos;
        }
        else{
            return $this->hasMany(Raffle::class, 'participant_id', 'id')->where('status', '=', 'Pago')->get();
        }
    }

    public function cotas()
    {
        return $this->hasMany(Raffle::class, 'participant_id', 'id')->get();
    }

    public function rifa()
    {
        return $this->hasOne(Product::class, 'id', 'product_id')->first();
    }

    public function order()
    {
        return $this->hasOne(Order::class, 'participant_id', 'id')->first();
    }

    public function totalReservas()
    {
        return $this->hasMany(Raffle::class, 'participant_id', 'id')->get();
    }

    public function sampleName()
    {
        $explode = explode(" ", $this->name);

        $name = $explode[0];

        if(array_key_exists(1, $explode)){
            $name .= ' ' . $explode[1];
        }

        return $name;
    }

    public function linkWpp()
    {
        $tel = "55" . str_replace(["(", ")", "-", " "], "", $this->telephone);
        $link = 'https://api.whatsapp.com/send?phone=' . $tel;

        return $link;
    }

    public function ganhadorCotaPremiada($cota)
    {
        $link = $this->linkWpp();
        $social = DB::table('consulting_environments')->where('id', '=', 1)->first();

        $msg = '------- '.$social->name.' -------';
        $msg .= '%0A%0A';
        $msg .= 'Olá *'.$this->name.'*';
        $msg .= '%0A%0A';
        $msg .= 'Parabéns você foi o ganhador da cota Premiada ' . $cota . ' na ação ' . $this->rifa()->name;

        $response = $link . '&text=' . $msg;

        return $response;
    }

    public function reciboWpp()
    {
        $link = $this->linkWpp();

        $social = DB::table('consulting_environments')->where('id', '=', 1)->first();

        $msg = '------- '.$social->name.' -------';
        $msg .= '%0A%0A';
        $msg .= 'Olá *'.$this->name.'*';
        $msg .= '%0A%0A';
        $msg .= 'Sua *compra '.$this->id.'* no valor de *R$ '.number_format($this->valor, 2, ",", ".").'* do sorteio *'.$this->rifa()->name.'* foi confirmada!';
        $msg .= '%0A%0A';
        $msg .= 'Você está concorrendo com os números:';
        foreach ($this->pagos() as $x) {
            $msg .= '%0A';
            $msg .= '*'.$x->number.'*';
        }

        $msg .= '%0A%0A';
        $msg .= 'Obrigado 🙏🏻 e boa sorte 🍀!';

        $response = $link . '&text=' . $msg;

        return $response;
    }

    public function linkPagamentoWpp()
    {
        $link = $this->linkWpp();

        $social = DB::table('consulting_environments')->where('id', '=', 1)->first();

        $msg = '------- '.$social->name.' -------';
        $msg .= '%0A%0A';
        $msg .= 'Olá *'.$this->name.'*';
        $msg .= '%0A%0A';
        $msg .= 'Sua *compra '.$this->id.'* no valor de *R$ '.number_format($this->valor, 2, ",", ".").'* do sorteio *'.$this->rifa()->name.'* esta com o pagamento pendente!';
        $msg .= '%0A%0A';
        $msg .= 'Segue link para efetuar o pagamento: ';
        $msg .= '%0A';
        $msg .= route('pagarReserva', $this->id);
        $msg .= '%0A%0A';
        $msg .= 'Obrigado 🙏🏻 e boa sorte 🍀!';

        $response = $link . '&text=' . $msg;

        return $response;
    }

    public function expiracao()
    {
        $rifa = $this->rifa();
        $expiracao = $rifa->expiracao;
        $criacao = $this->created_at;

        $expiraEm = date('Y-m-d H:i', strtotime("+".$expiracao." minutes", strtotime($criacao)));

        return $expiraEm;
    }

    public function payment()
    {
        return $this->hasOne(Payment_pix::class, 'participant_id', 'id')->first();
    }
}
