<?php

namespace App\Console\Commands;

use App\Participant;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExampleCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'example:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

        $participants = DB::table('participant')
            ->select('participant.id', 'participant.raffles_id', 'participant.name', 'participant.telephone', 'participant.product_id', 'payment_pix.key_pix', 'payment_pix.status')
            ->join('raffles', 'participant.raffles_id', '=', 'raffles.id')
            ->join('payment_pix', 'participant.id', '=', 'payment_pix.participant_id')
            ->where('participant.created_at', '<=', Carbon::now()->subDay(1))
            ->where('raffles.status', '=', 'Reservado')
            ->get();

        Log::info($participants);

        foreach ($participants as $participant) {
            //DEIXA DISPONIVEL OS NUMEROS NOVAMENTE
            DB::table('raffles')
                ->where('id', $participant->raffles_id)
                ->where('product_id', $participant->product_id)
                ->update(['status' => 'Disponível']);

            //CADASTRA NA TABELA DE PARTICIPANTES QUE N PAGARAM PARA CONTROLE
            DB::table('drop_participants')->insert(
                [
                    'name' => $participant->name,
                    'participant_id' => $participant->id,
                    'telephone' => $participant->telephone,
                    'raffles_id' => $participant->raffles_id,
                    'product_id' => $participant->product_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            );

            //CADASTRA NA TABELA DE PAGAMENTOS QUE N PAGARAM PARA CONTROLE
            DB::table('drop_payment_pix')->insert(
                [
                    'key_pix' => $participant->key_pix,
                    'status' => $participant->status,
                    'participant_id' => $participant->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            );

            //DELETA DADOS DO PIX
            DB::table('payment_pix')
                ->where('participant_id', '=', $participant->id)
                ->where('status', '=', 'Pendente')
                ->delete();

            //DELETA PARTICIPANTE DEPOIS DE 24 HORAS SEM PAGAR
            DB::table('participant')
                ->where('id', '=', $participant->id)
                ->delete();
        }
    }
}
