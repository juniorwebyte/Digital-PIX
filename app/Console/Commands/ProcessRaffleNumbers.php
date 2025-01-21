<?php

namespace App\Console\Commands;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ProcessRaffleNumbers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:numbers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processando e criando os numeros da rifa';

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
        $rifas = Product::where('processado', '=', 0)->get();

        foreach ($rifas as $rifa) {
            for ($i = 1; $i <= $rifa->qtd; $i++) {
                if ($rifa->qtd <= '100') {
                    DB::table('raffles')->insert(
                        [
                            'number' => str_pad($i - 1, 2, '0', STR_PAD_LEFT),
                            'status' => 'Disponível',
                            'product_id' => $rifa->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]
                    );
                } elseif ($rifa->qtd <= '999') {
                    DB::table('raffles')->insert(
                        [
                            'number' => str_pad($i, 3, '0', STR_PAD_LEFT),
                            'status' => 'Disponível',
                            'product_id' => $rifa->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]
                    );
                } else {
                    DB::table('raffles')->insert(
                        [
                            'number' => str_pad($i, 4, '0', STR_PAD_LEFT),
                            'status' => 'Disponível',
                            'product_id' => $rifa->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]
                    );
                }
            }

            $rifa->processado = true;
            $rifa->update();
        }
    }
}
