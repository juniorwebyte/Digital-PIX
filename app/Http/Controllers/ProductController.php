<?php

namespace App\Http\Controllers;

use App\AutoMessage;
use App\Participant;
use App\Product;
use App\CreateProductimage;
use App\Customer;
use App\Environment;
use App\GanhosAfiliado;
use App\Models\Order;
use App\Models\Participante;
use App\Models\Premio;
use App\Models\Product as ModelsProduct;
use App\Models\Raffle;
use App\RifaAfiliado;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use QRcode;

class ProductController extends Controller
{
    public function index()
    {
        $ganhadores = Premio::where('descricao', '!=', null)->where('ganhador', '!=', '')->get();

        $products = ModelsProduct::select($this->fieldsRifa)->where('visible', '=', 1)->orderBy('id', 'desc')->get();

        $winners = ModelsProduct::select('winner')->where('status', '=', 'Finalizado')->where('visible', '=', 1)->where('winner', '!=', null)->get();
        
        $config = DB::table('consulting_environments')->where('id', '=', 1)->first();

        return view('welcome', [
            'products' => $products,
            'winners' => $winners,
            'ganhadores' => $ganhadores,
            'user' => User::find(1),
            'productModel' => ModelsProduct::find(4),
            'config' => $config
        ]);
    }

    public function sorteios()
    {
        $ganhadores = Premio::where('descricao', '!=', null)->where('ganhador', '!=', '')->get();

        $products = ModelsProduct::where('visible', '=', 1)->orderBy('id', 'desc')->get();

        $winners = ModelsProduct::where('status', '=', 'Finalizado')->where('visible', '=', 1)->where('winner', '!=', null)->get();
        
        $config = DB::table('consulting_environments')->where('id', '=', 1)->first();

        return view('sorteios', [
            'products' => $products,
            'winners' => $winners,
            'ganhadores' => $ganhadores,
            'user' => User::find(1),
            'productModel' => ModelsProduct::find(4),
            'config' => $config
        ]);
    }

    public function product($slug, $tokenAfiliado = null)
    {
        $productSlug = DB::table('products')
            ->select('id')
            ->where('products.slug', '=', $slug)
            ->first();
        
        $productID = $productSlug->id;

        // Verificando se sorteio ja expirou para finalizar automatico.
        $this->verificaSorteio($productID);
        
        $user = DB::table('users')
            ->select('users.name', 'users.telephone', 'products.type_raffles')
            ->leftJoin('products', 'products.user_id', 'users.id')
            ->leftJoin('consulting_environments', 'consulting_environments.user_id', 'users.id')
            ->where('products.id', '=', $productID)
            ->first();

        $imagens = DB::table('products_images')
            ->select('products_images.name')
            ->join('products', 'products.id', '=', 'products_images.product_id')
            ->where('products.id', '=', $productID)
            ->get();

        $productDetail = DB::table('products')
            ->select('products.id', 'products.name', 'products.subname', 'products.product', 'products.price', 'products_images.name as image', 'products.status', 'products.draw_date', 'products.draw_prediction', 'products.winner')
            ->leftJoin('products_images', 'products.id', 'products_images.product_id')
            ->where('products.id', '=', $productID)
            ->orderBy('products_images.name', 'ASC')
            ->get();

        $bookProduct = DB::table('products')
            ->select('products.name', 'products.price', 'raffles.number', 'raffles.status', 'products.status as statusProduct', 'participant.name as participant', 'participant.created_at')
            ->join('raffles', 'products.id', '=', 'raffles.product_id')
            ->leftJoin('participant', 'raffles.id', 'participant.raffles_id')
            ->where('products.id', '=', $productID)
            ->get();

        $productDescription = DB::table('product_description')
            ->select('product_description.description', 'product_description.video')
            ->join('products', 'products.id', '=', 'product_description.product_id')
            ->where('products.id', '=', $productID)
            ->first();

        //TOTAIS DE NÚMEROS
        // $totalNumbers = DB::table('products')
        //     ->select('raffles.status')
        //     ->join('raffles', 'products.id', '=', 'raffles.product_id')
        //     ->where('products.id', '=', $productID)
        //     ->count();

        // $totalDispo = DB::table('products')
        //     ->select('raffles.status')
        //     ->join('raffles', 'products.id', '=', 'raffles.product_id')
        //     ->where('products.id', '=', $productID)
        //     ->where('raffles.status', '=', 'Disponível')
        //     ->count();

        // $totalReser = DB::table('products')
        //     ->select('raffles.status')
        //     ->join('raffles', 'products.id', '=', 'raffles.product_id')
        //     ->where('products.id', '=', $productID)
        //     ->where('raffles.status', '=', 'Reservado')
        //     ->count();

    
        // $totalPago = DB::table('products')
        //     ->select('raffles.status')
        //     ->join('raffles', 'products.id', '=', 'raffles.product_id')
        //     ->where('products.id', '=', $productID)
        //     ->where('raffles.status', '=', 'Pago')
        //     ->count();

        // $valueProduct = DB::table('products')
        //     ->select('price')
        //     ->where('products.id', '=', $productID)
        //     ->first();

        // $value50 = str_replace(',', '.', $valueProduct->price) * 50;
        // $value100 = str_replace(',', '.', $valueProduct->price) * 100;
        // $value150 = str_replace(',', '.', $valueProduct->price) * 150;
        // $value200 = str_replace(',', '.', $valueProduct->price) * 200;

        // $result50 = $value50 - ($value50 * 10 / 100);
        // $result100 = $value100 - ($value100 * 10 / 100);
        // $result150 = $value150 - ($value150 * 10 / 100);
        // $result200 = $value200 - ($value200 * 10 / 100);

        $productModel = ModelsProduct::select($this->fieldsRifa)->find($productID);

        $config = DB::table('consulting_environments')->where('id', '=', 1)->first();

        $arrayProducts = [
            'tokenAfiliado' => $tokenAfiliado,
            'imagens' => $imagens,
            'product' => $productDetail,
            'bookProduct' => $bookProduct,
            'productDescription' => $productDescription ? $productDescription->description : '',
            'productDescriptionVideo' => $productDescription ? $productDescription->video : '',
            'totalNumbers' => $productModel->qtd,
            'totalDispo' => $productModel->qtdNumerosDisponiveis(),
            'totalReser' => $productModel->qtdNumerosReservados(),
            'totalPago' => $productModel->qtdNumerosPagos(),
            'user' => $user->name,
            'telephone' => $user->telephone,
            'type_raffles' => $user->type_raffles,
            // 'result50' => number_format($result50, 2, ",", "."),
            // 'result100' => number_format($result100, 2, ",", "."),
            // 'result150' => number_format($result150, 2, ",", "."),
            // 'result200' => number_format($result200, 2, ",", "."),
            'productModel' => $productModel,
            'ranking' => $productModel->ranking(),
            'config' => $config,
            'user' => User::find(1),
        ];


        return view('product-detail', $arrayProducts);
    }

    public function verificaSorteio($productId)
    {
        
        // Verificando se sorteio ja expirou ou se ja foi vendido todas as cotas para finalizar automatico.
        $product = ModelsProduct::select($this->fieldsRifa)->find($productId);
        if($product->qtdNumerosDisponiveis() == 0){
            $product->status = 'Finalizado';
            $product->update();
        }
    }

    public function randomParticipant()
    {
        $userRandom = Participant::inRandomOrder()->select('name')->first();
        $resultUserRandom = explode(' ', $userRandom->name);

        return json_encode($resultUserRandom);
    }

    public function getRaffles(Request $request)
    {
        $bookProduct = DB::table('products')
            ->select('products.name', 'products.price', 'raffles.number', 'raffles.status', 'products.status as statusProduct', 'participant.name as participant', 'participant.created_at', 'products.qtd_zeros')
            ->join('raffles', 'products.id', '=', 'raffles.product_id')
            ->leftJoin('participant', 'raffles.id', 'participant.raffles_id')
            ->where('products.id', '=', $request->idProductURL)
            ->get();
        
        $rifa = ModelsProduct::find($request->idProductURL);
        $numbers = $rifa->numbers();

        foreach ($rifa->participantes() as $participante) {
            $statusParticipante = $participante->pagos > 0 ? 'pago' : 'reservado';
            foreach ($participante->numbers() as $value) {
                array_push($numbers, $value . '-' . $statusParticipante . '-' . $participante->name);
            }
        }

        sort($numbers);

        foreach ($numbers as $number) {
            $bg = env('APP_URL') == 'rifasonline.link' ? '#A0A1A3' : '#585858';
            $ex = explode("-", $number);
            $number = $ex[0];
            
            $status = 'disponivel';
            if(isset($ex[1])){
                $status = $ex[1];
                $nome = $ex[2];
            }

            if($status == 'disponivel'){
                $resultRaffles[] = "<a href='javascript:void(0);' class='number filter ".$status."' onclick=\"selectRaffles('" . $number . "', '" . $number . "')\" style='background-color: ".$bg.";color: #000;' id=" . $number . ">" . $number . "</a>";
            }
            else if($status == 'reservado'){
                $nome = 'Reservado por ' . $nome;
                $resultRaffles[] = "<a href='javascript:void(0);' class='number filter ".$status."' onclick=\"infoParticipante('" . $nome . "')\" style='background-color: rgb(13,202,240);color: #000;' id=" . $number . ">" . $number . "</a>";
            }
            else if($status == 'pago'){
                $nome = 'Pago por ' . $nome;
                $resultRaffles[] = "<a href='javascript:void(0);' class='number filter ".$status."' onclick=\"infoParticipante('" . $nome . "')\" style='background-color: #28a745;color: #000;' id=" . $number . ">" . $number . "</a>";
            }

            

            // if ($rifa->status === 'Ativo') {
            //     if ($number['status'] === 'Disponivel') {
            //         $resultRaffles[] = "<a href='javascript:void(0);' class='number filter disponivel' onclick=\"selectRaffles('" . $number['number'] . "', '" . $number['key'] . "')\" style='background-color: #585858;color: #000;' id=" . $number['number'] . ">" . $number['number'] . "</a>";
            //     } else if ($number['status']  == "Reservado") {
            //         $resultRaffles[] = "<a href='javascript:void(0);' class='number filter reservado' onclick=\"timeNumbers(this)\" style='background-color: #d7d5d5;color: #000;display:none;' id=" . $number['number'] . " data-toggle='tooltip' data-placement='top' data-html='true' title='Reservado por: " . $rifa->getParticipanteById($number['participant_id']) . "'><input type='hidden' id='createdAt" . $number['number'] . "' value=''>" . $number['number'] . "</a>";
            //     } else if ($number['status'] == "Pago") {
            //         $resultRaffles[] = "<a href='javascript:void(0);' class='number filter pago' style='background-color: #28a745;color: #fff;display:none;' id='" . $number['number'] . "' data-toggle='tooltip' data-placement='top' title='Pago por: " . $rifa->getParticipanteById($number['participant_id']) . "'>" . $number['number'] . "</a>";
            //     }
            // } else if ($rifa->status === 'Agendado') {
            //     if ($number['status'] === 'Disponivel') {
            //         $resultRaffles[] = "<a href='javascript:void(0);' class='number filter disponivel' onclick=\"alert('Sorteio agendado não é mais possível reservar!')\" style='background-color: #f1f1f1;color: #000;' id=" . $number['number'] . ">" . $number['number'] . "</a>";
            //     } else if ($number['status']  == "Reservado") {
            //         $resultRaffles[] = "<a href='javascript:void(0);' class='number filter reservado' style='background-color: #0F9EE2;color: #fff;' id=" . $number['number'] . " data-toggle='tooltip' data-placement='top' data-html='true' title='Reservado por: " . $rifa->getParticipanteById($number['participant_id']) . "'><input type='hidden' id='createdAt" . $number['number'] . "' value=''>" . $number['number'] . "</a>";
            //     } else if ($number['status'] == "Pago") {
            //         $resultRaffles[] = "<a href='javascript:void(0);' class='number filter pago' style='background-color: #28a745;color: #fff;' id='" . $number['number'] . "' data-toggle='tooltip' data-placement='top' title='Pago por: " . $rifa->getParticipanteById($number['participant_id']) . "'>" . $number['number'] . "</a>";
            //     }
            // } else if ($rifa->status === 'Finalizado') {
            //     if ($number['status'] === 'Disponivel') {
            //         $resultRaffles[] = "<a href='javascript:void(0);' class='number filter disponivel' onclick=\"alert('Sorteio finalizado não é mais possível reservar!')\" style='background-color: #f1f1f1;color: #fff;' id=" . $number['number'] . ">" . $number['number'] . "</a>";
            //     } else if ($number['status']  == "Reservado") {
            //         $resultRaffles[] = "<a href='javascript:void(0);' class='number filter reservado' style='background-color: #0F9EE2;color: #fff;' id=" . $number['number'] . " data-toggle='tooltip' data-placement='top' data-html='true' title='Reservado por: " . $rifa->getParticipanteById($number['participant_id']) . "'><input type='hidden' id='createdAt" . $number['number'] . "' value=''>" . $number['number'] . "</a>";
            //     } else if ($number['status'] == "Pago") {
            //         $resultRaffles[] = "<a href='javascript:void(0);' class='number filter pago' style='background-color: #28a745;color: #fff;' id='" . $number['number'] . "' data-toggle='tooltip' data-placement='top' title='Pago por: " . $rifa->getParticipanteById($number['participant_id']) . "'>" . $number['number'] . "</a>";
            //     }
            // } else {
            //     $resultRaffles[] = null;
            // }
        }


        // foreach ($bookProduct as $raffles) {

        //     // Mostrando a qtd de zeros qe esta configurado no painel
        //     if ($raffles->qtd_zeros != null || $raffles->qtd_zeros == 0) {
        //         $number = intval($raffles->number); // retira os 0 convertendo para inteiro
        //         $number = strval($number);          // converte novamente para string
        //         for ($i = 0; $i < $raffles->qtd_zeros; $i++) {
        //             $number = '0' . $number;
        //         }

        //         $number = $raffles->number;
        //     } else {
        //         $number = $raffles->number;
        //     }

        //     if ($raffles->statusProduct === 'Ativo') {
        //         if ($raffles->status === 'Disponível') {
        //             $resultRaffles[] = "<a href='javascript:void(0);' class='number filter disponivel' onclick=\"selectRaffles('" . $number . "')\" style='background-color: #585858;color: #000;' id=" . $number . ">" . $number . "</a>";
        //         } else if ($raffles->status  == "Reservado") {
        //             $resultRaffles[] = "<a href='javascript:void(0);' class='number filter reservado' onclick=\"timeNumbers(this)\" style='background-color: #d7d5d5;color: #000;display:none;' id=" . $number . " data-toggle='tooltip' data-placement='top' data-html='true' title='Reservado por: " . $raffles->participant . "'><input type='hidden' id='createdAt" . $number . "' value=''>" . $number . "</a>";
        //         } else if ($raffles->status == "Pago") {
        //             $resultRaffles[] = "<a href='javascript:void(0);' class='number filter pago' style='background-color: #28a745;color: #fff;display:none;' id='" . $number . "' data-toggle='tooltip' data-placement='top' title='Pago por: " . $raffles->participant . "'>" . $number . "</a>";
        //         }
        //     } else if ($raffles->statusProduct === 'Agendado') {
        //         if ($raffles->status === 'Disponível') {
        //             $resultRaffles[] = "<a href='javascript:void(0);' class='number filter disponivel' onclick=\"alert('Sorteio agendado não é mais possível reservar!')\" style='background-color: #f1f1f1;color: #000;' id=" . $number . ">" . $number . "</a>";
        //         } else if ($raffles->status  == "Reservado") {
        //             $resultRaffles[] = "<a href='javascript:void(0);' class='number filter reservado' style='background-color: #0F9EE2;color: #fff;' id=" . $number . " data-toggle='tooltip' data-placement='top' data-html='true' title='Reservado por: " . $raffles->participant . "'><input type='hidden' id='createdAt" . $number . "' value=''>" . $number . "</a>";
        //         } else if ($raffles->status == "Pago") {
        //             $resultRaffles[] = "<a href='javascript:void(0);' class='number filter pago' style='background-color: #28a745;color: #fff;' id='" . $number . "' data-toggle='tooltip' data-placement='top' title='Pago por: " . $raffles->participant . "'>" . $number . "</a>";
        //         }
        //     } else if ($raffles->statusProduct === 'Finalizado') {
        //         if ($raffles->status === 'Disponível') {
        //             $resultRaffles[] = "<a href='javascript:void(0);' class='number filter disponivel' onclick=\"alert('Sorteio finalizado não é mais possível reservar!')\" style='background-color: #f1f1f1;color: #fff;' id=" . $number . ">" . $number . "</a>";
        //         } else if ($raffles->status  == "Reservado") {
        //             $resultRaffles[] = "<a href='javascript:void(0);' class='number filter reservado' style='background-color: #0F9EE2;color: #fff;' id=" . $number . " data-toggle='tooltip' data-placement='top' data-html='true' title='Reservado por: " . $raffles->participant . "'><input type='hidden' id='createdAt" . $number . "' value=''>" . $number . "</a>";
        //         } else if ($raffles->status == "Pago") {
        //             $resultRaffles[] = "<a href='javascript:void(0);' class='number filter pago' style='background-color: #28a745;color: #fff;' id='" . $number . "' data-toggle='tooltip' data-placement='top' title='Pago por: " . $raffles->participant . "'>" . $number . "</a>";
        //         }
        //     } else {
        //         $resultRaffles[] = null;
        //     }
        // }

        return json_encode($resultRaffles);
    }

    public function formatMoney($value)
    {
        $value = str_replace('.', "", $value);
        $value = str_replace(',', ".", $value);

        return $value;
    }

    //REVERSA OS NÚMEROS DO SORTEIO X SEM INTEGRAÇÃO COM O PIX
    public function bookProductManualy(Request $request)
    {

        DB::beginTransaction();
        try {
            //Cadastrando customer
            if($request->customer == 0){
                $customer = Customer::create([
                    'nome' => $request->name,
                    'telephone' => $request->telephone
                ]);
            }
            else{
                $customer = Customer::find($request->customer);
            }


            $prod = ModelsProduct::select($this->fieldsRifa)->find($request->productID);

            // Validando link de afiliado,
            $afiliado = RifaAfiliado::where('token', '=', $request->tokenAfiliado)->first();

            $path = 'numbers/' . $prod->id . '.json';
            //$jsonString = file_get_contents($path);

            if($request->qtdNumbers > 10000){
                return Redirect::back()->withErrors('Você só pode comprar no máximo 10.000 números por vez');
            }   

            if(!$request->name){
                return Redirect::back()->withErrors('Campo nome é obrigatório!');
            }
            if(!$request->telephone){
                return Redirect::back()->withErrors('Campo telefone é obrigatório!');
            }

            // Para o gateway ASAAS é obrigatorio o CPF
            if ($prod->gateway == 'asaas') {
                $request->validate([
                    'cpf' => 'required',
                ]);
            }

            $codeKeyPIX = DB::table('consulting_environments')
                ->select('key_pix', 'token_asaas')
                ->where('user_id', '=', 1)
                ->first();

            $integracaoGateway = true;
            if ($prod->gateway == 'mp' && $codeKeyPIX->key_pix == null) {
                $integracaoGateway = false;
            }
            if ($prod->gateway == 'asaas' && $codeKeyPIX->token_asaas == null) {
                $integracaoGateway = false;
            }

            if (!$integracaoGateway) {
                return Redirect::back()->withErrors('Administrador precisa adicionar a integração com o banco!');
            } else {

                $statusProduct = DB::table('products')
                    ->select('status')
                    ->where('products.id', '=', $request->productID)
                    ->first();

                //dd($request->productID);

                if ($statusProduct->status == "Ativo") {

                    $user = DB::table('users')
                        ->select('users.name', 'users.telephone', 'products.type_raffles')
                        ->leftJoin('products', 'products.user_id', 'users.id')
                        ->leftJoin('consulting_environments', 'consulting_environments.user_id', 'users.id')
                        ->where('products.id', '=', $request->productID)
                        ->first();

                    if ($user->type_raffles == 'manual') {
                        $validatedData = $request->validate([
                            'name' => 'required|max:255',
                            'telephone' => 'required|max:15',
                        ]);
                    } else if ($user->type_raffles == 'mesclado') {
                        if ($request->qtdNumbers == null) {
                            $validatedData = $request->validate([
                                'name' => 'required|max:255',
                                'telephone' => 'required|max:15',
                            ]);
                        } else {
                            $validatedData = $request->validate([
                                'name' => 'required|max:255',
                                'telephone' => 'required|max:15',
                                'qtdNumbers' => 'numeric|min:1|max:500'
                            ]);
                        }
                    } else if ($user->type_raffles == 'mesclado2') {
                        if ($request->qtdNumbers == null) {
                            $validatedData = $request->validate([
                                'name' => 'required|max:255',
                                'telephone' => 'required|max:15',
                            ]);
                        } else {
                            $validatedData = $request->validate([
                                'name' => 'required|max:255',
                                'telephone' => 'required|max:15',
                                'qtdNumbers' => 'numeric|min:1|max:500'
                            ]);
                        }
                    } else {
                        // $validatedData = $request->validate([
                        //     'name' => 'required|max:255',
                        //     'telephone' => 'required|max:15',
                        //     'qtdNumbers' => 'numeric|min:1|max:5000'
                        // ]);
                    }



                    if (str_starts_with($prod->modo_de_jogo, 'fazendinha')) {
                        $numbers = $request->numberSelected;
                        $resutlNumbers = explode(",", $numbers);
                    } else {
                        if ($prod->type_raffles == 'manual' || $prod->type_raffles == 'mesclado') {
                            $numbers = $request->numberSelected;
                            $resutlNumbers = explode(",", $numbers);


                            // Validando numeros escolhidos rifa manual
                            // ========================================================================================== //

                            $numerosValidos = true;

                            foreach ($resutlNumbers as $key => $value) {
                                $expl = explode("-", $value);
                                $number = end($expl);
                                

                                $participantesPorNumero = Participante::where('product_id', '=', $request->productID)->where('numbers', 'like', '%'.$number.'%')->get();
                                
                                foreach ($participantesPorNumero as $key => $part) {
                                    if(array_search($number, $part->numbers()) || array_search($number, $part->numbers()) == 0){
                                        $numerosValidos = false;
                                        break;
                                    }
                                    
                                }
                            }

                            if(!$numerosValidos){
                                return Redirect::back()->withErrors('Um ou mais números escolhidos já foram comprados por outra pessoa! Tente novamente');
                            }

                            // ========================================================================================== //

                            $numbersRifa = $prod->numbers();

                            $selecionados = [];
                            foreach ($resutlNumbers as $key => $value) {
                                $expl = explode("-", $value);
                                $keyNumber = end($expl);

                                $keyRifa = array_search($keyNumber, $numbersRifa);
                                array_push($selecionados, $keyNumber);
                                unset($numbersRifa[$keyRifa]);
                            }

                            $prod->saveNumbers($numbersRifa);

                        } else {
                            $disponiveis = $prod->numbers();
                            // shuffle($numbersRifa);
                            // dd($numbersRifa);
                            
                            // $disponiveis = array_filter($numbersRifa, function ($number) {
                            //     return $number['status'] == 'Disponivel';
                            // });

                            shuffle($disponiveis);

                            $selecionados = array_slice($disponiveis, 0, $request->qtdNumbers);

                            if (count($disponiveis) < $request->qtdNumbers) {
                                return Redirect::back()->withErrors('Quantidade indisponível para a rifa selecionada. A quantidade disponível é: ' . count($disponiveis));
                            }

                            foreach ($selecionados as $key => $resultNumber) {
                                $resutlNumbers[] = $resultNumber;
                                unset($disponiveis[$key]);
                            }

                            sort($disponiveis);

                            $prod->saveNumbers($disponiveis);

                            $numbers = implode(",", $resutlNumbers);
                        }
                    }

                    $product = DB::table('products')
                        ->select('products.*', 'products_images.name as image')
                        ->join('products_images', 'products.id', 'products_images.product_id')
                        ->where('products.id', '=', $request->productID)
                        ->first();

                    // Validando minimo e maximo de compra da rifa
                    if (isset($randomNumbers)) {
                        if ($randomNumbers->count() < $product->minimo) {
                            return Redirect::back()->withErrors('Você precisa comprar no mínimo ' . $product->minimo . ' números');
                        }
                        if ($randomNumbers->count() > $product->maximo) {
                            return Redirect::back()->withErrors('Você só pode comprar no máximo ' . $product->maximo . ' números');
                        }
                    } else {
                        if (count($resutlNumbers) < $product->minimo) {
                            return Redirect::back()->withErrors('Você precisa comprar no mínimo ' . $product->minimo . ' números');
                        }
                        if (count($resutlNumbers) > $product->maximo) {
                            return Redirect::back()->withErrors('Você só pode comprar no máximo ' . $product->maximo . ' números');
                        }
                    }

                    $new = str_replace(",", ".", $product->price);

                    $price = count($resutlNumbers) * $new;
                    $resultPrice = number_format($price, 2, ",", ".");

                    $resultPricePIX = number_format($price, 2, ".", ",");


                
                    if ($request->promo != null && $request->promo > 0) {
                        $resultPrice = $request->promo;
                        $resultPricePIX = $this->formatMoney($request->promo);
                    }

                    // Validando valor abaixo de 5.00 para gateway ASAAS
                    if ($prod->gateway == 'asaas' && $price < 5) {
                        return Redirect::back()->withErrors('Sua aposta deve ser de no mínimo R$ 5,00');
                    }

                    // Verifica se algum numero escolhido ja possui reserva (WDM New)
                    $verifyReserved = DB::table('raffles')
                        ->select('*')
                        ->where('raffles.product_id', '=', $request->productID)
                        ->whereIn('raffles.number', $resutlNumbers)
                        ->where('raffles.status', '<>', 'Disponível')
                        ->get();

                    if ($verifyReserved->count() > 0) {
                        return Redirect::back()->withErrors('Acabaram de reservar um ou mais numeros escolhidos, por favor escolha outros números :)');
                    } else {
                        
                        $participante = DB::table('participant')->insertGetId([
                            'customer_id' => $customer->id,
                            'name' => $request->name,
                            'telephone' => $request->telephone,
                            'email' => '',
                            'cpf' => '',
                            'valor' => $resultPricePIX,
                            'reservados' => count($resutlNumbers),
                            'product_id' => $request->productID,
                            'numbers' => isset($selecionados) ? json_encode($selecionados) : json_encode($resutlNumbers),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);

                        $gateway = $this->gerarPIX($prod, $resultPricePIX, $request->email, $request->name, $participante, $request->cpf, $request->telephone);

                        if (isset($gateway['error'])) {
                            return back()->withErrors($gateway['error']);
                        }

                        $codePIXID = $gateway['codePIXID'];
                        $codePIX = $gateway['codePIX'];
                        $qrCode = $gateway['qrCode'];

                        // $codePIXID = $object->id;
                        // $codePIX = $object->point_of_interaction->transaction_data->qr_code;
                        // $qrCode = $object->point_of_interaction->transaction_data->qr_code_base64;

                        DB::table('payment_pix')->insert([
                            'key_pix' => $codePIXID,
                            'full_pix' => $codePIX,
                            'status' => 'Pendente',
                            'qrcode' => $qrCode,
                            'participant_id' => $participante,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);


                        // Atualiza os numeros escolhidos para reservados
                        DB::table('raffles')
                            ->where('product_id', '=', $request->productID)
                            ->whereIn('raffles.number', $resutlNumbers)
                            ->update(
                                [
                                    'status' => 'Reservado',
                                    'participant_id' => $participante,
                                    'updated_at' => Carbon::now()
                                ]
                            );
                    }

                    $order = Order::create([
                        'key_pix' => $codePIXID,
                        'participant_id' => $participante,
                        'valor' => $price,
                    ]);


                    $countRaffles = count($resutlNumbers);
                    $priceUnicFormat = str_replace(',', '.', $product->price);

                    $percentage = 5;

                    $percentagePriceUnic = ($percentage / 100) * $priceUnicFormat;
                    $resultPriceUnic = $priceUnicFormat + $percentagePriceUnic + 0.50;

                    if($afiliado != null){
                        $part = Participante::find($participante);
                        GanhosAfiliado::create([
                            'product_id' => $prod->id,
                            'participante_id' => $participante,
                            'afiliado_id' => $afiliado->afiliado_id,
                            'valor' => $part->valor * $prod->ganho_afiliado / 100,
                            'pago' => false
                        ]);
                    }


                    //dd(number_format($resultPriceUnic, 2, ".", ","));

                    $dadosSave = [
                        'participant_id' => $participante,
                        'price' => $resultPrice,
                        'productID' => $product->id,
                        'PIX' => $resultPricePIX,
                        'countRaffles' => $countRaffles,
                        'priceUnic' => number_format($resultPriceUnic, 2, ".", ","),
                        'codePIXID' => $codePIXID
                    ];

                    $order->dados = json_encode($dadosSave);
                    $order->update();

                    $this->mensagemWPPCompra($participante);

                    DB::commit();
                    return redirect()->route('checkoutManualy', $dadosSave)->withInput();
                } elseif ($statusProduct->status == "Agendado") {
                    return Redirect::back()->withErrors('Sorteio agendado não é mais possível reservar!');
                } else {
                    return Redirect::back()->withErrors('Sorteio finalizado não é mais possível reservar!');
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
    }

    public function validarNumerosEscolhidos($numbers)
    {
        return false;
    }

    public function mensagemWPPCompra($participanteID)
    {
        $admin = User::find(1);
        $config = Environment::find(1);
        $participante = Participante::find($participanteID);
        $msgAdmin = AutoMessage::where('identificador', '=', 'compra-admin')->first();
        $msgCliente = AutoMessage::where('identificador', '=', 'compra-cliente')->first();
        $apiURL = env('URL_API_CRIAR_WHATS');

        if($config->token_api_wpp != null){

            // ============== Mensagem para o admin
            // ============================================== //
            // if($msgAdmin->msg != null && $msgAdmin->msg != ''){
            //     $mensagem = $msgAdmin->getMessage($participante);
            //     $owerPhone = '55' . str_replace(["(", ")", "-", " "], "", $admin->telephone);
        
            //     try {
            //         $data = [
            //             'receiver'  => $owerPhone,
            //             'msgtext'   => $mensagem,
            //             'token'     => $config->token_api_wpp,
            //         ];
                    
            //         $ch = curl_init();
            //         curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
            //         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //         curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            //         curl_setopt($ch, CURLOPT_URL, $apiURL);
            //         curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            //         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            //         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            //         $response = curl_exec($ch);
            //         curl_close($ch);
            //     } catch (\Throwable $th) {
                    
            //     }
            // }

            // ============== Mensagem para o cliente
            // ============================================== //
            if($msgCliente->msg != null && $msgCliente->msg != ''){
                $mensagem = $msgCliente->getMessage($participante);
                $customerPhone = '55' . str_replace(["(", ")", "-", " "], "", $participante->telephone);
        
                try {
$url = "https://api.whatapi.com.br";
$token 	= base64_decode($config->token_api_wpp );
$numero = $customerPhone;

// testar o envio com essa formatacao abaixo. se nao for comente a linha 13 e descomente a 14 para testar novamente.
$mensagem = str_replace("\r\n","\\n",$mensagem);
//$mensagem = preg_replace('/\\\n|\n|#&@/i', '\n', $mensagem);

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $url.'/message/text?key='.$token.'',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
        "id": "'.$numero.'",
        "message": "'.$mensagem.'",
        "msdelay": "3000"
    }',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: Bearer @@N855cd65@@'
      ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

					
					
					
					
					
                } catch (\Throwable $th) {
                    
                }
            }
        }
    }

    public function gerarPIX(ModelsProduct $product, $resultPricePIX, $email, $name, $participante, $cpf, $telefone)
    {
        if($resultPricePIX == 0){
            $response['codePIXID'] = uniqid();
            $response['codePIX'] = 'gratis';
            $response['qrCode'] = '';

            return $response;
        }

        $codeKeyPIX = DB::table('consulting_environments')
            ->select('key_pix', 'token_asaas', 'paggue_client_key', 'paggue_client_secret')
            ->where('user_id', '=', 1)
            ->first();

        if ($product->gateway == 'mp') {
            \MercadoPago\SDK::setAccessToken($codeKeyPIX->key_pix);

            $resultPricePIX = str_replace(",", "", $resultPricePIX);

            $payment = new \MercadoPago\Payment();
            $payment->transaction_amount = $resultPricePIX;
            $payment->description = "Participação da ação " . $product->id . ' - ' . $product->name;
            $payment->payment_method_id = "pix";


            $payment->payer = array(
                "email" => $email ? $email : "teste@teste.com",
                "first_name" => $name,
                "identification" => array(
                    "type" => "hash",
                    "number" => date('YmdHis')
                )
            );

            $payment->notification_url = env('APP_NAME') == 'local' ? '' : route('api.notificaoMP');
            $payment->external_reference = $participante;
            $payment->save();

            $object = (object) $payment;

            if (isset($object->error->message) == 'payer.email must be a valid email') {
                $response['error'] = 'Erro ao gerar o QR Code!';
                return $response;
            }

            if (isset($object->error->message) == 'Invalid user identification number') {
                $response['error'] = 'CPF inválido!';
                return $response;
            }

            $codePIXID = $object->id;
            $codePIX = $object->point_of_interaction->transaction_data->qr_code;
            $qrCode = $object->point_of_interaction->transaction_data->qr_code_base64;

            $response['codePIXID'] = $codePIXID;
            $response['codePIX'] = $codePIX;
            $response['qrCode'] = $qrCode;

            return $response;
        } else if ($product->gateway == 'asaas') {
            $idCliente = $this->getOrCreateClienteAsaas($name, $email, $cpf, $telefone);

            $minutosExpiracao = $product->expiracao;
            $dataDeExpiracao = date('Y-m-d H:i:s', strtotime("+" . $minutosExpiracao . " minutes"));

            $client = new \GuzzleHttp\Client([
                'headers' => [
                    'Content-Type' => 'application/json',
                    'access_token' => $codeKeyPIX->token_asaas
                ]
            ]);

            $pixURL = 'https://www.asaas.com/api/v3/payments';
            $requestPIX = $client->post($pixURL, [
                'form_params' => [
                    "externalReference" => $participante,
                    "description" => "Participação da ação " . $product->id . ' - ' . $product->name,
                    "customer" =>  $idCliente,
                    "billingType" =>  "PIX",
                    'dueDate' => date('Y-m-d', strtotime($dataDeExpiracao)),
                    "value" =>  $resultPricePIX,
                ]
            ]);

            $responsePIX = json_decode($requestPIX->getBody()->getContents());

            // Capturando QR Code gerado
            $QRURL = $pixURL . '/' . $responsePIX->id . '/pixQrCode';
            $reqQR = $client->get($QRURL);
            $respQR = json_decode($reqQR->getBody()->getContents());

            $response['codePIXID'] = $responsePIX->id;
            $response['codePIX'] = $respQR->payload;
            $response['qrCode'] = $respQR->encodedImage;

            return $response;
        } else if ($product->gateway == 'paggue') {
            include(app_path() . '/ThirdParty/phpqrcode/qrlib.php');

            $payload = array(
                "client_key"    => $codeKeyPIX->paggue_client_key,
                "client_secret" => $codeKeyPIX->paggue_client_secret
            );

            $paggue_curl = curl_init();

            curl_setopt_array($paggue_curl, array(
                CURLOPT_URL => 'https://ms.paggue.io/payments/api/auth/login',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => http_build_query($payload),
            ));

            $auth_response = json_decode(curl_exec($paggue_curl));

            curl_close($paggue_curl);

            $paggue_token = $auth_response->access_token;
            $paggue_company_id = $auth_response->user->companies[0]->id;

            // Faz a requisição do pagamento
            $payload = array(
                "payer_name" => $name,
                "amount" => $resultPricePIX * 100,
                "external_id" => $participante,
                "description" => "Participação da ação " . $product->id . ' - ' . $product->name,
            );


            $headers = array();
            $headers[] = 'Accept: application/json';
            $headers[] = 'Authorization: Bearer ' . $paggue_token;
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'X-Company-ID: ' . $paggue_company_id;

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://ms.paggue.io/payments/api/billing_order',
                CURLOPT_RETURNTRANSFER => true,
                curl_setopt($curl, CURLOPT_POST, 1),
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_HTTPHEADER => $headers
            ));

            $payment_response = json_decode(curl_exec($curl));

            curl_close($curl);

            ob_start();
            \QRCode::png($payment_response->payment, null);
            $imageString = base64_encode(ob_get_contents());
            ob_end_clean();

            $response['codePIXID'] = $payment_response->hash;
            $response['codePIX'] = $payment_response->payment;
            $response['qrCode'] = $imageString;

            $req = fopen('create_paggue.json', 'w') or die('Cant open the file');
            fwrite($req, json_encode($response));
            fclose($req);

            return $response;
        } else {
            $response['codePIXID'] = '';
            $response['codePIX'] = '';
            $response['qrCode'] = '';

            return $response;
        }
    }

    public function getOrCreateClienteAsaas($nome, $email, $cpf, $telefone)
    {
        $codeKeyPIX = DB::table('consulting_environments')
            ->select('key_pix', 'token_asaas')
            ->where('user_id', '=', 1)
            ->first();

        $clientURL = 'https://www.asaas.com/api/v3/customers';
        $client = new \GuzzleHttp\Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'access_token' => $codeKeyPIX->token_asaas
            ]
        ]);

        $params = [
            'query' => [
                'cpfCnpj' => $cpf,
            ]
        ];

        $request = $client->get($clientURL, $params);

        $response = json_decode($request->getBody()->getContents());

        if (count($response->data) > 0) {
            $idCliente = $response->data[0]->id;
        } else {
            $requestClient = $client->post($clientURL, [
                'form_params' => [
                    "name" => $nome,
                    "email" => $email,
                    "cpfCnpj" =>  $cpf,
                    "mobilePhone" => $telefone
                ]
            ]);

            $responseCliente = json_decode($requestClient->getBody()->getContents());
            $idCliente = $responseCliente->id;
        }

        return $idCliente;
    }

    public function participants(Request $request)
    {
        //dd($request->product);

        $participants = Participant::select('name')
            ->join('raffles', 'participant.raffles_id', 'raffles.id')
            ->where('raffles.status', '=', 'Pago')
            ->where('raffles.product_id', '=', $request->product)
            ->inRandomOrder()
            ->count();

        //dd($teste->name);

        return $participants;
    }

    public function searchNumbers(Request $request)
    {
        $substr = substr($request->telephone, 0, 2);
        $ddd = '(' . $substr . ')';
        $substr1 = ' ' . substr($request->telephone, 2, 5) . '-';
        $substr2 = substr($request->telephone, 7);
        $resultTelephone = $ddd . $substr1 . $substr2;

        $numbersPaid = DB::table('participant')
            ->select('raffles.number', 'raffles.status', 'products.name')
            ->join('raffles', 'participant.raffles_id', 'raffles.id')
            ->join('products', 'products.id', 'raffles.product_id')
            ->where('participant.telephone', '=', $resultTelephone)
            ->where('products.id', '=', $request->productID)
            ->where('raffles.status', '=', 'Pago')
            ->get();

        return $numbersPaid;
    }

    public function searchPIX(Request $request)
    {
        $substr = substr($request->telephone, 0, 2);
        $ddd = '(' . $substr . ')';
        $substr1 = ' ' . substr($request->telephone, 2, 5) . '-';
        $substr2 = substr($request->telephone, 7);
        $resultTelephone = $ddd . $substr1 . $substr2;

        $pix = DB::table('participant')
            ->select('raffles.number', 'key_pix')
            ->leftJoin('payment_pix', 'participant.id', 'payment_pix.participant_id')
            ->join('raffles', 'participant.raffles_id', 'raffles.id')
            ->where('participant.telephone', '=', $resultTelephone)
            ->where('participant.product_id', '=', $request->product)
            ->get();

        return $pix;
    }

    public function callbackPaymentMercadoPago(Request $request)
    {

        //$resultCallBacks = $request->all();

        /*$teste = array(
            'action' => 'payment.updated',
            'api_version' => 'v1',
            'data' =>
            array(
                'id' => '53385711687',
            ),
            'date_created' => '2023-01-07T13:07:19Z',
            'id' => 104558878009,
            'live_mode' => true,
            'type' => 'payment',
            'user_id' => '197295574',
            'data_id' => '53385711687',
        );

        Log::info($teste['data']['id']);*/

        //QUANDO FOR TESTAR PELO POSTMAN COLOCAR O VALOR DO ARRAY 0 no request\/
        //dd($request[0]['action']);

        if ($request['action'] == 'payment.updated') {

            DB::table('payment_pix')
                ->where('key_pix', $request['data']['id'])
                ->update(['status' => 'Concluída']);

            $updatingRaffles = DB::table('payment_pix')
                ->join('participant', 'participant.id', '=', 'payment_pix.participant_id')
                ->join('raffles', 'raffles.id', '=', 'participant.raffles_id')
                ->where('payment_pix.key_pix', $request['data']['id'])
                ->update(
                    [
                        'raffles.status' => 'Pago',
                        'raffles.updated_at' => Carbon::now()
                    ]
                );

            $participantEmail = DB::table('payment_pix')
                ->select('participant.name', 'participant.email', 'participant.telephone', 'raffles.*', 'products.name as product', 'products.id as productID', 'products.ebook')
                ->join('participant', 'participant.id', '=', 'payment_pix.participant_id')
                ->join('raffles', 'raffles.id', '=', 'participant.raffles_id')
                ->join('products', 'products.id', '=', 'participant.product_id')
                ->where('payment_pix.key_pix', $request['data']['id'])
                ->get();

            $rafflesNumber = [];

            foreach ($participantEmail as $raffle) {
                array_push($rafflesNumber, $raffle->number);
            }

            $raffleImplode = implode(',', $rafflesNumber);

            $consultingEnvironment = DB::table('consulting_environments')
                ->first();

            $dddTelephone = substr($participantEmail[0]->telephone, 1, 2);
            $n1Telephone = substr($participantEmail[0]->telephone, 5, 5);
            $n2Telephone = substr($participantEmail[0]->telephone, 11, 4);

            $dados = array(
                'name' => $participantEmail[0]->name,
                'email' => $participantEmail[0]->email,
                'product' => $participantEmail[0]->product,
                'productID' => $participantEmail[0]->productID,
                'url' => url('/products/' . $participantEmail[0]->ebook),
                'raffles' => $raffleImplode,
                'environment' => $consultingEnvironment->name,
                'instagram' => $consultingEnvironment->instagram,
                'facebook' => $consultingEnvironment->instagram,
                'searchMyRaffles' => url('reserva/' . $participantEmail[0]->productID . '/' . $dddTelephone . $n1Telephone . $n2Telephone)
            );

            $emailUser = $participantEmail[0]->email;
            $environment = $consultingEnvironment->name;

            Mail::send('mails.payment', ['dados' => $dados], function ($message) use ($emailUser, $environment) {
                $message->from('contato@gosolution.com.br', $environment);
                $message->to($emailUser);
                $message->subject('Ação entre amigos');
            });

            return response()->json(['success' => 'success'], 200);
        } else {

            return response()->json(['error' => 'error'], 404);
        }

        //Log::info($request->all());
    }

    public function ganhadores()
    {

        // $winners = DB::table('products')
        //     ->select('*')
        //     ->where('products.status', '=', 'Finalizado')
        //     ->where('products.visible', '=', 1)
        //     ->orderBy('products.id', 'desc')
        //     ->get();

        $winners = ModelsProduct::where('status', '=', 'Finalizado')->get();

        return view('ganhadores', [
            'winners' => $winners
        ]);
    }

    public function teste()
    {
        $keyPix = 56565819514;
        $codeKeyPIX = DB::table('consulting_environments')
            ->select('key_pix')
            ->where('user_id', '=', 1)
            ->first();

        if (env('APP_ENV') == 'local') {
            $secretKey = 'TEST-330207199077363-081623-283cea3525fa71a8e4d1afa279bf8e8c-197295574';
        } else {
            $secretKey = $codeKeyPIX->key_pix;
        }

        \MercadoPago\SDK::setAccessToken($secretKey);

        $payment = new \MercadoPago\Payment();

        $payment = \MercadoPago\Payment::find_by_id($keyPix);
        $payment->capture = true;
        $payment->update();
        dd($payment);
    }

    public function notificacoesMP(Request $request)
    {
        try {
            $codeKeyPIX = DB::table('consulting_environments')
                ->select('key_pix')
                ->where('user_id', '=', 1)
                ->first();
           
            $accessToken = $codeKeyPIX->key_pix;

            \MercadoPago\SDK::setAccessToken($accessToken);

            $payment = \MercadoPago\Payment::find_by_id($request->id);

            if ($payment) {
                if ($payment->status == 'cancelled') {
                    DB::table('payment_pix')->where('id', '=', $request->id)->delete();
                } else if ($payment->status == 'approved') {

                    $participante = Participante::find($payment->external_reference);
                    if ($participante) {
                        $rifa = $participante->rifa();
                        $rifa->confirmPayment($participante->id);

                        DB::table('payment_pix')->where('id', '=', $request->id)->update([
                            'status' => 'Aprovado'
                        ]);
                    } else {
                        DB::table('payment_pix')->where('id', '=', $request->id)->delete();
                    }
                }
            }

            return response('OK', 200)->header('Content-Type', 'text/plain');
        } catch (\Throwable $th) {
            //throw $th;
            return response('Erro', 404)->header('Content-Type', 'text/plain');
        }
    }

    public function rankingAdmin(Request $request)
    {
        $rifa = ModelsProduct::find($request->id);

        $data = [
            'rifa' => $rifa,
            'ranking' => $rifa->rankingAdmin()
        ];

        $response['html'] = view('ranking-admin', $data)->render();

        return $response;
    }

    public function definirGanhador(Request $request)
    {
        $rifa = ModelsProduct::find($request->id);

        $data = [
            'rifa' => $rifa,
        ];

        $response['html'] = view('layouts.definir-ganhador', $data)->render();

        return $response;
    }

    public function verGanhadores(Request $request)
    {
        $rifa = ModelsProduct::find($request->id);

        $data = [
            'rifa' => $rifa,
        ];

        $response['html'] = view('layouts.ver-ganhadores', $data)->render();

        return $response;
    }

    public function informarGanhadores(Request $request)
    {
        try {
            $rifa = ModelsProduct::find($request->idRifa);
            $premios = $rifa->premios();
            $ganhadores = [];
            

            if($rifa->modo_de_jogo == 'numeros'){
                foreach ($request->cotas as $key => $cota) {
                    foreach ($rifa->participantes() as $participante) {
                        $numbersParticipante = $participante->numbers();
                        $find = array_search($cota, $numbersParticipante);
                        if(is_int($find)){
                            array_push($ganhadores, $participante->name);
                            $premios->where('ordem', '=', $key)->first()->update([
                                'ganhador' => $participante->name,
                                'telefone' => $participante->telephone,
                                'cota' => $cota,
                                'participant_id' => $participante->id
                            ]);
                            break;
                        }
                    }
                }
            }
            else{
                foreach ($request->cotas as $key => $cota) {
                    $numero = $rifa->numbers()->where('number', '=', $cota)->first();
                    $participante = $numero->participante();
                    $premios->where('ordem', '=', $key)->first()->update([
                        'ganhador' => $participante->name,
                        'telefone' => $participante->telephone,
                        'cota' => $cota
                    ]);
                }
            }
            

            return redirect()->back()->with(['success' => 'Ganhadores ('.implode(',', $ganhadores).') informados com sucesso!', 'sorteio' => $request->idRifa]);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('Erro ao informar ganhadores');
        }
    }

    public function notificacoesPaggue(Request $request)
    {
        $req = fopen('webhook_paggue.json', 'w') or die('Cant open the file');
        fwrite($req, $request);
        fclose($req);

        $participante = Participante::find($request->external_id);
        if ($participante && $request->status == '1') {

            Raffle::where('participant_id', '=', $participante->id)->update(['status' => 'Pago']);

            $numbersParticipante = $participante->numbers();

            $participante->update([
                'reservados' => 0,
                'pagos' => count($numbersParticipante)
            ]);

            DB::table('payment_pix')->where('participant_id', '=', $participante->id)->update([
                'status' => 'Aprovado'
            ]);

            return response('OK', 200)->header('Content-Type', 'text/plain');
        }
    }
}
