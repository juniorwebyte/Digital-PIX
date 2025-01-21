<?php

namespace App\Console\Commands;

use App\Models\Participante;
use App\Models\Raffle;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class LiberarReservasExpiradas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservas:expiradas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Liberando numeros de reservas expiradas';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $reservas = Raffle::select('product_id', 'participant_id')->where('status', '=', 'Reservado')->groupBy('product_id', 'participant_id')->get();
        
        foreach ($reservas as $reserva) {
            $rifa = $reserva->rifa();
            $participante = $reserva->participante();

            $criacao = date('Y-m-d H:i:s', strtotime($participante->created_at));
            $minutosExpiracao = $rifa->expiracao;

            $dataDeExpiracao = date('Y-m-d H:i:s', strtotime("+".$minutosExpiracao." minutes",strtotime($criacao)));

            if($minutosExpiracao > 0 && $dataDeExpiracao <= date('Y-m-d H:i:s')){
                if($rifa->modo_de_jogo == 'numeros'){
                    $numbersParticipante = $participante->numbers();
                    $rifaNumbers = $rifa->numbers();
        
                    foreach ($numbersParticipante as $number) {
                        $rifaNumbers[$number->key]['status'] = 'Disponivel';
                    }
        
                    $rifa->saveNumbers($rifaNumbers);
                }
                else{
                    Raffle::where('participant_id', '=', $participante->id)->update([
                        'status' => 'Disponível',
                        'participant_id' => null
                    ]);
                }
        
                Participante::find($participante->id)->delete();

                DB::table('payment_pix')->where('participant_id', '=', $participante->id)->delete();
            }
        }

        // Liberando reservas para o novo modelo
        $participantes = Participante::where('reservados', '>', 0)->get();
        foreach ($participantes as $participante) {
            $rifa = $participante->rifa();

            $criacao = date('Y-m-d H:i:s', strtotime($participante->created_at));
            $minutosExpiracao = $rifa->expiracao;
            $dataDeExpiracao = date('Y-m-d H:i:s', strtotime("+".$minutosExpiracao." minutes",strtotime($criacao)));

            if($minutosExpiracao > 0 && $dataDeExpiracao <= date('Y-m-d H:i:s')){
                if($rifa->modo_de_jogo == 'numeros'){
                    $numbersParticipante = $participante->numbers();
                    $rifaNumbers = $rifa->numbers();
        
                    foreach ($numbersParticipante as $number) {
                        array_push($rifaNumbers, $number);
                    }
        
                    $rifa->saveNumbers($rifaNumbers);
                }
                else{
                    Raffle::where('participant_id', '=', $participante->id)->update([
                        'status' => 'Disponível',
                        'participant_id' => null
                    ]);
                }
        
                Participante::find($participante->id)->delete();

                DB::table('payment_pix')->where('participant_id', '=', $participante->id)->delete();
            }
        }
    }
}
