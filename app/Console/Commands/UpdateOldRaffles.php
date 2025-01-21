<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Raffle;
use Illuminate\Console\Command;

class UpdateOldRaffles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:raffles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualizando rifas de numeros com o novo metodo (arquivo json)';

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
        $rifas = Product::where('modo_de_jogo', '=', 'numeros')->get();

        foreach ($rifas as $rifa) {
            $path = 'numbers/' . $rifa->id . '.json';
            $oldNumbers = Raffle::where('product_id', '=', $rifa->id)->get();

            if (!file_exists($path) && $oldNumbers->count() > 0) {
                $arr = [];
                for ($x = 0; $x < $rifa->qtd; $x++) {
                    $arr[$x] = [
                        'key' => $x,
                        'number' => str_pad($x, strlen((string)$rifa->qtd),  '0', STR_PAD_LEFT),
                        'status' => $oldNumbers[$x]->status == 'Disponível' ? 'Disponivel' : $oldNumbers[$x]->status,
                        'participant_id' => $oldNumbers[$x]->participant_id,
                    ];
                }

                $numbers = json_encode($arr);

                $req = fopen(public_path() . '/' . $path, 'w') or die('Cant open the file');
                fwrite($req, $numbers);
                fclose($req);
                
            }

            foreach ($rifa->participantes() as $participante) {
                $arr = [];

                $participanteNumbers = Raffle::where('participant_id', '=', $participante->id)->get();

                $arr = [];
                foreach ($participanteNumbers as $key => $raffle) {
                    $arr[$key] = [
                        'key' => intval($raffle->number),
                        'number' => $raffle->number,
                        'status' => $raffle->status == 'Disponível' ? 'Disponivel' : $raffle->status,
                        'participant_id' => $raffle->participant_id,
                    ];
                }

                $pagos = array_filter($arr, function($num){
                    return $num['status'] == 'Pago';
                });

                $reservados = array_filter($arr, function($num){
                    return $num['status'] == 'Reservado';
                });

                $participante->update([
                    'numbers' => json_encode($arr),
                    'pagos' => count($pagos),
                    'reservados' => count($reservados)
                ]);
                
            }
        }

        dd('finalizado');
    }
}
