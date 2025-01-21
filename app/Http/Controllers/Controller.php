<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Process\Process;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $fieldsRifa = [
        'id',
        'maximo',
        'minimo',
        'modo_de_jogo',
        'favoritar',
        'type_raffles',
        'qtd',
        'status',
        'ganho_afiliado',
        'price',
        'slug',
        'qtd_ranking',
        'expiracao',
        'parcial',
        'name',
        'subname',
        'gateway'
    ];

    public function pull()
    {
        $command = new Process("git pull");
        $command->setWorkingDirectory(base_path());
        $command->run();

        $response = [];

        if ($command->isSuccessful()) {
            $response['pull'] = 'ok';
        } else {
            $response['pull'] = 'Erro';
        }

        $migrate = new Process("/usr/local/bin/ea-php74 artisan migrate");
        $migrate->setWorkingDirectory(base_path());
        $migrate->run();

        if ($migrate->isSuccessful()) {
            $response['migrate'] = 'ok';
        } else {
            $response['migrate'] = 'Erro';
        }

        dd($response);
    }

    public function updateOldRaffles()
    {
        $command = new Process("php artisan update:raffles");
        $command->setWorkingDirectory(base_path());
        $command->run();

        $response = [];

        if ($command->isSuccessful()) {
            $response['update-raffles'] = 'ok';
        } else {
            $response['update-raffles'] = 'Erro';
        }

        dd($response);
    }

    public function formatMoney($value)
    {
        $value = str_replace(".", "", $value);
        $value = str_replace(",", ".", $value);

        return $value;
    }

    public function migrate()
    {
        $command = new Process("php artisan migrate");
        $command->setWorkingDirectory(base_path());
        $command->run();

        if ($command->isSuccessful()) {
            dd('ok');
        } else {
            dd('erro');
        }
    }

    public function updateFooter()
    {
        DB::table('consulting_environments')
            ->where('consulting_environments.id', 1)
            ->update(
                [
                    'footer' => 'Marquinhos do paredão resultado pela loteria federal 🍀',
                ]
            );

        dd('ok');
    }

}
