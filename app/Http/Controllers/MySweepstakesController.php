<?php

namespace App\Http\Controllers;

use App\CompraAutomatica;
use App\CreateProductimage;
use App\Environment;
use App\GanhosAfiliado;
use App\Models\DescricaoProduto;
use App\Models\Order;
use App\Models\Participante;
use App\Models\Premio;
use App\Models\Product as ModelsProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Participant;
use App\User;
use App\Product;
use MongoDB\Driver\Session;
use function foo\func;
use App\Models\Raffle;
use App\Promocao;
use App\SolicitacaoAfiliado;
use App\Video;
use App\WhatsappMensagem;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;

class MySweepstakesController extends Controller
{
    public function index(Request $request)
    {
        $rifas = ModelsProduct::all();

        // Finalizando rifas vencidas ou que foram vendidas 100%
        foreach ($rifas->where('status', '=', 'Ativo') as $value) {
            if ($value->qtdNumerosDisponiveis() == 0) {
                $value->status = 'Finalizado';
                $value->update();
            }
        }

        $search = $request->get('search');
        // informações de user logado pelo sistema do laravel
        $user = Auth::user();
        $cleanNumbers = [];
        $rifas = DB::table('products')
            ->select('products.id', 'products.name', 'products.modo_de_jogo', 'products.price', 'products.type_raffles', 'products.winner', 'products.slug', 'products_images.name as image', 'raffles.number as total_number', 'product_description.description as description', 'products.status', 'products.draw_date', 'products.draw_prediction', 'products.visible', 'products.favoritar')
            ->join('products_images', 'products.id', 'products_images.product_id')
            ->join('product_description', 'products.id', 'product_description.product_id')
            ->join('raffles', 'products.id', 'raffles.product_id', 'raffles.id')
            ->where('products.user_id', '=', Auth::user()->id)
            ->groupBy('products.id')
            ->orderBy('products.id', 'DESC')
            ->get();


        foreach ($rifas as $keyRaffles => $valRaffles) :
            $_ProductID = $valRaffles->id;
            $cleanNumbers[] = MySweepstakesController::getRafflesNumbers($_ProductID);
        endforeach;
        $getArrayCleaner = MySweepstakesController::cleanEmptyArrays($cleanNumbers);

        $total_numeros = DB::table('raffles')
            ->select('raffles.number')
            ->where('raffles.product_id', '=', 3)
            ->get()
            ->count();


        $rifas = ModelsProduct::orderBy('id', 'desc')->get();
        return view('my-sweepstakes', [

            'rifas' => $rifas,
            'rifas_numeros' => $getArrayCleaner,
            'total_numeros' => $total_numeros,

        ]);
    }

    public function buildRifas($productId)
    {
    }

    public function getRafflesNumbers($productID)
    {
        $returnNumbers = [];
        $countRafflesByProduct = [];
        $countAvailableNumbers = 0;
        $countReservedNumbers = 0;
        $countPayedNumbers = 0;

        $countRafflesByProduct[$productID]['totalNumberAvailable'] = 0;
        $countRafflesByProduct[$productID]['totalNumberReserved'] = 0;
        $countRafflesByProduct[$productID]['totalNumberPayed'] = 0;
        $countRafflesByProduct[$productID]['participants'] = [];

        $rafflesNumbers = DB::table('raffles')
            ->select('id', 'number', 'status', 'product_id')
            ->where('raffles.product_id', $productID)
            ->orderBy('raffles.created_at', 'DESC')
            ->get();

        foreach ($rafflesNumbers as $cKeyRaffle => $cValRaffle) :
            switch ($cValRaffle->status) {
                case "Disponível":
                    $countRafflesByProduct[$productID]['totalNumberAvailable'] = $countAvailableNumbers++;
                    break;
                case "Reservado":
                    $countRafflesByProduct[$productID]['totalNumberReserved'] = $countReservedNumbers++;
                    break;
                case "Pago":
                    $countRafflesByProduct[$productID]['totalNumberPayed'] = $countPayedNumbers++;
                    break;
            }
        endforeach;

        $rafflesParticipants = DB::table('participant')
            ->select('id', 'name', 'telephone', 'cpf', 'raffles_id', 'product_id')
            ->where('participant.product_id', $productID)
            ->get();

        $_ObjectParticipant = json_decode(json_encode($rafflesParticipants));


        foreach ($_ObjectParticipant as $keyParticipant => $valParticipant) :
            if ($valParticipant->product_id == $productID) :
                $countRafflesByProduct[$productID]['participants'][$valParticipant->cpf]['name'] = $valParticipant->name;

                $countRafflesByProduct[$productID]['participants'][$valParticipant->cpf]['telephone'] = $valParticipant->telephone;

                $countRafflesByProduct[$productID]['participants'][$valParticipant->cpf]['cpf'] = $valParticipant->cpf;

                $countRafflesByProduct[$productID]['participants'][$valParticipant->cpf]['numbres'][$productID]['reservado'][] = MySweepstakesController::getRafflesByID($valParticipant->raffles_id, $productID)->reservado;

                $countRafflesByProduct[$productID]['participants'][$valParticipant->cpf]['numbres'][$productID]['pago'][] = MySweepstakesController::getRafflesByID($valParticipant->raffles_id, $productID)->pago;
            endif;
        endforeach;

        return $countRafflesByProduct;
    }


    public function getRafflesByID($raffleID, $productID)
    {

        $returnData = [];
        $returnData['reservado'] = [];
        $returnData['pago'] = [];

        $getNumbers = DB::table('raffles')
            ->select('id', 'number', 'status', 'product_id')
            ->where('raffles.id', $raffleID)
            ->get();

        foreach ($getNumbers as $key => $value) :
            if ($value->id == $raffleID && $productID == $value->product_id) :
                if ($value->status == "Reservado") :
                    $returnData['reservado'] = (object)['id' => $value->id, 'number' => $value->number];
                endif;
                if ($value->status == "Pago" && $value->id == $raffleID) :
                    $returnData['pago'] = (object)['id' => $value->id, 'number' => $value->number];
                endif;
            endif;
        endforeach;
        return (object) $returnData;
    }

    public function pagarReservas(Request $request)
    {
        $participante = Participante::find($request->participante);
        $rifa = $participante->rifa();

        $rifa->confirmPayment($participante->id);

        DB::table('payment_pix')->where('participant_id', '=', $request->participante)->update([
            'status' => 'Aprovado'
        ]);

        $message = "Pagamento registrado com sucesso";
        return back()->with('success', $message);
    }

    public function reservarNumeros(Request $request)
    {
        $participante = Participante::find($request->participante);
        $rifa = $participante->rifa();

        if ($rifa->modo_de_jogo == 'numeros') {
            $numbersParticipante = $participante->numbers();
            // $rifaNumbers = $rifa->numbers();

            // foreach ($numbersParticipante as $number) {
            //     $number->status = 'Reservado';
            //     $rifaNumbers[$number->key]['status'] = 'Reservado';
            // }

            $participante->update([
                // 'numbers' => json_encode($numbersParticipante),
                'reservados' => count($numbersParticipante),
                'pagos' => 0
            ]);

            // $participante->rifa()->saveNumbers($rifaNumbers);
        } else {
            Raffle::where('participant_id', '=', $request->participante)->update([
                'status' => 'Reservado',
            ]);
        }



        DB::table('payment_pix')->where('participant_id', '=', $request->participante)->update([
            'status' => 'Pendente'
        ]);

        $message = "Números reservados com sucesso";
        return back()->with('success', $message);
    }

    public function releaseReservedRafflesNumbers(Request $request)
    {
        $participante = Participante::find($request->release_reservervations);
        $rifa = $participante->rifa();

        if ($rifa->modo_de_jogo == 'numeros') {
            $numbersParticipante = $participante->numbers();
            $rifaNumbers = $rifa->numbers();

            foreach ($numbersParticipante as $number) {
                array_push($rifaNumbers, $number);
                // $rifaNumbers[$number->key] = [
                //     'key' => $number->key,
                //     'number' => $number->number,
                //     'status' => $number->status,
                //     'participant_id' => $number->participant_id
                // ];
            }

            sort($rifaNumbers);
            $rifa->saveNumbers($rifaNumbers);
        } else {
            Raffle::where('participant_id', '=', $request->release_reservervations)->update([
                'status' => 'Disponível',
                'participant_id' => null
            ]);
        }

        Participante::find($request->release_reservervations)->delete();

        $message = "Voce removeu todas as reserva(s), todos os números estão disponíveis novamente";
        return back()->with('success', $message);


        // $count = 0;
        // $cleanNumbers = ($request->release_reservervations !== NULL) ? json_decode(base64_decode(urldecode($request->release_reservervations))) : [];
        // foreach($cleanNumbers as $kNumbers => $valNumbers):
        //     if(MySweepstakesController::updateReservationsToAvailable($valNumbers->id)){
        //         $count++;
        //     }
        // endforeach;

        // if($count > 0){
        //     $message = "Voce removeu ".$count." reserva(s), todos os números estão disponíveis novamente";
        //     return back()->with('success', $message);
        // }

    }

    public function updateReservationsToAvailable($id = NULL)
    {
        if ($id !== NULL) :
            try {
                DB::table('raffles')->where('id', $id)
                    ->update([
                        'status' => 'Disponível'
                    ]);
                return TRUE;
            } catch (\Throwable $th) {
            }

        endif;
    }

    public function cleanEmptyArrays($array)
    {
        if (!empty($array)) :
            foreach ($array as $key => $value) : foreach ($array[$key] as $k1 => $v2) : foreach ($array[$key][$k1]["participants"] as $k3 => $v4) : foreach ($array[$key][$k1]["participants"][$k3]["numbres"][$k1]["reservado"] as $kNumberRes => $vNumberRes) :
                            if (empty($array[$key][$k1]["participants"][$k3]["numbres"][$k1]["reservado"][$kNumberRes])) :
                                unset($array[$key][$k1]["participants"][$k3]["numbres"][$k1]["reservado"][$kNumberRes]);
                            endif;
                        endforeach;
                        foreach ($array[$key][$k1]["participants"][$k3]["numbres"][$k1]["pago"] as $kNumberPay => $vNumberPay) :
                            if (empty($array[$key][$k1]["participants"][$k3]["numbres"][$k1]["pago"][$kNumberPay])) :
                                unset($array[$key][$k1]["participants"][$k3]["numbres"][$k1]["pago"][$kNumberPay]);
                            endif;
                        endforeach;
                    endforeach;
                endforeach;
            endforeach;
            return $array;
        endif;
    }

    public static function createSlug($string)
    {

        $table = array(
            'Š' => 'S',
            'š' => 's',
            'Đ' => 'Dj',
            'đ' => 'dj',
            'Ž' => 'Z',
            'ž' => 'z',
            'Č' => 'C',
            'č' => 'c',
            'Ć' => 'C',
            'ć' => 'c',
            'À' => 'A',
            'Á' => 'A',
            'Â' => 'A',
            'Ã' => 'A',
            'Ä' => 'A',
            'Å' => 'A',
            'Æ' => 'A',
            'Ç' => 'C',
            'È' => 'E',
            'É' => 'E',
            'Ê' => 'E',
            'Ë' => 'E',
            'Ì' => 'I',
            'Í' => 'I',
            'Î' => 'I',
            'Ï' => 'I',
            'Ñ' => 'N',
            'Ò' => 'O',
            'Ó' => 'O',
            'Ô' => 'O',
            'Õ' => 'O',
            'Ö' => 'O',
            'Ø' => 'O',
            'Ù' => 'U',
            'Ú' => 'U',
            'Û' => 'U',
            'Ü' => 'U',
            'Ý' => 'Y',
            'Þ' => 'B',
            'ß' => 'Ss',
            'à' => 'a',
            'á' => 'a',
            'â' => 'a',
            'ã' => 'a',
            'ä' => 'a',
            'å' => 'a',
            'æ' => 'a',
            'ç' => 'c',
            'è' => 'e',
            'é' => 'e',
            'ê' => 'e',
            'ë' => 'e',
            'ì' => 'i',
            'í' => 'i',
            'î' => 'i',
            'ï' => 'i',
            'ð' => 'o',
            'ñ' => 'n',
            'ò' => 'o',
            'ó' => 'o',
            'ô' => 'o',
            'õ' => 'o',
            'ö' => 'o',
            'ø' => 'o',
            'ù' => 'u',
            'ú' => 'u',
            'û' => 'u',
            'ý' => 'y',
            'þ' => 'b',
            'ÿ' => 'y',
            'Ŕ' => 'R',
            'ŕ' => 'r',
            '/' => '-',
            ' ' => '-'
        );

        // -- Remove duplicated spaces
        $stripped = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $string);


        // -- Returns the slug
        return strtolower(strtr($string, $table));
    }
    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'slug' => 'required',
        ], [
            'required' => 'O campo :attribute é obrigatório'
        ], [
            'slug' => 'URL Amigavel'
        ]);

        // retirando outras rifas de favoritos
        if ($request->favoritar_rifa) {
            Product::where('favoritar', '=', 1)->update([
                'favoritar' => 0
            ]);
        }

        // Verificando se alterou a qtd de 0 para atualizar
        $rifa = ModelsProduct::find($id);
        // if ($rifa->qtd_zeros != $request->qtd_zeros) {
        //     $numbersRifa = $rifa->numbers();
        //     foreach ($numbersRifa as $value) {
        //         $number = intval($value['number']); // retira os 0 convertendo para inteiro
        //         $number = strval($number);          // converte novamente para string
        //         for ($i = 0; $i < $request->qtd_zeros; $i++) {
        //             $number = str_pad($number, $request->qtd_zeros + 1, '0', STR_PAD_LEFT);
        //             // $number = '0' . $number;
        //         }

        //         $key = $value['key'];
        //         $numbersRifa[$key]['number'] = $number;
        //     }
        //     $rifa->saveNumbers($numbersRifa);
        // }




        try {
            $rifa_edit = Product::find($id)->update(
                [
                    'name' => $request->name,
                    'subname' => $request->subname,
                    'price' => $request->price,
                    'status' => $request->status,
                    'expiracao' => $request->expiracao,
                    'parcial' => $request->parcial,
                    'slug' => $request->slug,
                    //'draw_date' => $request->data,
                    //'type_raffles' => 'automatico',
                    //'slug' => $this->createSlug($request->name),
                    'user_id' => Auth::user()->id,
                    'visible' => $request->visible,
                    'favoritar' => $request->favoritar_rifa,
                    'winner' => $request->cadastrar_ganhador,
                    'type_raffles' => $request->tipo_reserva,
                    'draw_date' => $request->data_sorteio,
                    'maximo' => $request->maximo,
                    'minimo' => $request->minimo,
                    'draw_prediction' => $request->previsao_sorteio,
                    'qtd_ranking' => $request->qtd_ranking,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'ganho_afiliado' => intval($request->ganho_afiliado),
                    // 'qtd_zeros' => $request->qtd_zeros,
                    // 'modo_de_jogo' => $request->rifa_numero,
                    'gateway' => $request->gateway
                ]
            );
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }

        $rifa->ganho_afiliado = $request->ganho_afiliado;
        $rifa->update();

        // Atualizando a descricao
        $desc = DescricaoProduto::where('product_id', '=', $id)->first();
        $desc->description = $request->description;
        $desc->update();

        //criando promo para rifa qe ainda nao tem
        $prod = ModelsProduct::find($id);
        if ($prod->promocoes()->count() === 0) {
            for ($i = 1; $i <= 4; $i++) {
                Promocao::create([
                    'product_id' => $prod->id,
                    'ordem' => $i
                ]);
            }
        } else {
            // atualizando promocao
            for ($i = 1; $i <= 4; $i++) {
                $qtdNumeros = $request->numPromocao[$i];
                $desconto = floatval($request->valPromocao[$i]);
                $total = $qtdNumeros * str_replace(",", ".", $prod->price);
                $valorComDesconto = $total - ($total * $desconto / 100);


                Promocao::where('product_id', '=', $id)->where('ordem', '=', $i)->update([
                    'qtdNumeros' => $request->numPromocao[$i],
                    'desconto' => $desconto,
                    'valor' => $valorComDesconto
                ]);
            }
        }

        // Atualizando premios
        foreach ($prod->premios() as $premio) {
            $premio->update([
                'descricao' => $request->descPremio[$premio->ordem],
            ]);
        }


        // Atualizando compras auto
        foreach ($request->compra as $key => $qtd) {
            CompraAutomatica::find($key)->update([
                'qtd' => $qtd,
                'popular' => false
            ]);
        }

        // Atualizando mais popular
        CompraAutomatica::find($request->popularCheck)->update([
            'popular' => true
        ]);

        DB::commit();

        return redirect()->back()->with('success', 'Edição da Rifa efetuado com sucesso!');
    }

    public function formatMoney($value)
    {
        $value = str_replace(".", "", $value);
        $value = str_replace(",", ".", $value);

        return $value;
    }

    public function getRaffles(Request $request)
    {

        if (json_encode($request->search['value']) != 'null') {
            $raffles = DB::table('raffles')
                ->select('raffles.*', 'participant.name as participant', 'participant.telephone', 'participant.created_at')
                ->leftJoin('participant', 'raffles.id', 'participant.raffles_id')
                ->where('raffles.product_id', '=', $request->product_id)
                ->where('raffles.number', 'like', '%' . $request->search['value'] . '%')
                ->offset($request->start)
                ->limit($request->length)
                ->get();

            $rafflesCountAll = DB::table('raffles')
                ->select('raffles.*', 'participant.name as participant', 'participant.telephone', 'participant.created_at')
                ->leftJoin('participant', 'raffles.id', 'participant.raffles_id')
                ->where('raffles.product_id', '=', $request->product_id)
                ->where('raffles.number', 'like', '%' . $request->search['value'] . '%')
                ->get();

            $participantSearchCount = count($rafflesCountAll);
        } else if ($request->columns[0]['search']['value'] != null) {
            $raffles = DB::table('raffles')
                ->select('raffles.*', 'participant.name as participant', 'participant.telephone', 'participant.created_at')
                ->leftJoin('participant', 'raffles.id', 'participant.raffles_id')
                ->where('raffles.product_id', '=', $request->product_id)
                ->where('raffles.number', 'like', '%' . $request->columns[0]['search']['value'] . '%')
                ->offset($request->start)
                ->limit($request->length)
                ->get();

            $rafflesCountAll = DB::table('raffles')
                ->select('raffles.*', 'participant.name as participant', 'participant.telephone', 'participant.created_at')
                ->leftJoin('participant', 'raffles.id', 'participant.raffles_id')
                ->where('raffles.product_id', '=', $request->product_id)
                ->where('raffles.number', 'like', '%' . $request->columns[0]['search']['value'] . '%')
                ->get();

            $participantSearchCount = count($rafflesCountAll);
        } else if ($request->columns[1]['search']['value'] != null) {
            $raffles = DB::table('raffles')
                ->select('raffles.*', 'participant.name as participant', 'participant.telephone', 'participant.created_at')
                ->leftJoin('participant', 'raffles.id', 'participant.raffles_id')
                ->where('raffles.product_id', '=', $request->product_id)
                ->where('raffles.status', 'like', '%' . $request->columns[1]['search']['value'] . '%')
                ->offset($request->start)
                ->limit($request->length)
                ->get();

            $rafflesCountAll = DB::table('raffles')
                ->select('raffles.*', 'participant.name as participant', 'participant.telephone', 'participant.created_at')
                ->leftJoin('participant', 'raffles.id', 'participant.raffles_id')
                ->where('raffles.product_id', '=', $request->product_id)
                ->where('raffles.status', 'like', '%' . $request->columns[1]['search']['value'] . '%')
                ->get();

            $participantSearchCount = count($rafflesCountAll);
        } else if ($request->columns[2]['search']['value'] != null) {
            $raffles = DB::table('raffles')
                ->select('raffles.*', 'participant.name as participant', 'participant.telephone', 'participant.created_at')
                ->leftJoin('participant', 'raffles.id', 'participant.raffles_id')
                ->where('raffles.product_id', '=', $request->product_id)
                ->where('participant.name', 'like', '%' . $request->columns[2]['search']['value'] . '%')
                ->offset($request->start)
                ->limit($request->length)
                ->get();

            $rafflesCountAll = DB::table('raffles')
                ->select('raffles.*', 'participant.name as participant', 'participant.telephone', 'participant.created_at')
                ->leftJoin('participant', 'raffles.id', 'participant.raffles_id')
                ->where('raffles.product_id', '=', $request->product_id)
                ->where('participant.name', 'like', '%' . $request->columns[2]['search']['value'] . '%')
                ->get();

            $participantSearchCount = count($rafflesCountAll);
        } else if ($request->columns[3]['search']['value'] != null) {
            $raffles = DB::table('raffles')
                ->select('raffles.*', 'participant.name as participant', 'participant.telephone', 'participant.created_at')
                ->leftJoin('participant', 'raffles.id', 'participant.raffles_id')
                ->where('raffles.product_id', '=', $request->product_id)
                ->where('participant.telephone', 'like', '%' . $request->columns[3]['search']['value'] . '%')
                ->offset($request->start)
                ->limit($request->length)
                ->get();

            $rafflesCountAll = DB::table('raffles')
                ->select('raffles.*', 'participant.name as participant', 'participant.telephone', 'participant.created_at')
                ->leftJoin('participant', 'raffles.id', 'participant.raffles_id')
                ->where('raffles.product_id', '=', $request->product_id)
                ->where('participant.telephone', 'like', '%' . $request->columns[3]['search']['value'] . '%')
                ->get();

            $participantSearchCount = count($rafflesCountAll);
        } else if ($request->columns[4]['search']['value'] != null) {

            //TRATA DATA BR
            $dataColumn = explode("/", $request->columns[4]['search']['value']);
            $resultColumn = $dataColumn[2] . '-' . $dataColumn[1] . '-' . $dataColumn[0];

            $raffles = DB::table('raffles')
                ->select('raffles.*', 'participant.name as participant', 'participant.telephone', 'participant.created_at')
                ->leftJoin('participant', 'raffles.id', 'participant.raffles_id')
                ->where('raffles.product_id', '=', $request->product_id)
                //->where('participant.created_at', 'like', $resultColumn . '%')
                ->whereBetween('participant.created_at', [$resultColumn . ' 00:00:00', $resultColumn . ' 23:59:59'])
                ->where('raffles.status', '=', 'Reservado')
                ->offset($request->start)
                ->limit($request->length)
                ->orderBy('participant.created_at', 'DESC')
                ->get();

            $rafflesCountAll = DB::table('raffles')
                ->select('raffles.*', 'participant.name as participant', 'participant.telephone', 'participant.created_at')
                ->leftJoin('participant', 'raffles.id', 'participant.raffles_id')
                ->where('raffles.product_id', '=', $request->product_id)
                //->where('participant.created_at', 'like', $resultColumn . '%')
                ->whereBetween('participant.created_at', [$resultColumn . ' 00:00:00', $resultColumn . ' 23:59:59'])
                ->where('raffles.status', '=', 'Reservado')
                ->orderBy('participant.created_at', 'DESC')
                ->get();

            $participantSearchCount = count($rafflesCountAll);
        } else if ($request->columns[5]['search']['value'] != null) {

            //TRATA DATA BR
            $dataColumn = explode("/", $request->columns[5]['search']['value']);
            $resultColumn = $dataColumn[2] . '-' . $dataColumn[1] . '-' . $dataColumn[0];

            $raffles = DB::table('raffles')
                ->select('raffles.*', 'participant.name as participant', 'participant.telephone', 'participant.created_at')
                ->leftJoin('participant', 'raffles.id', 'participant.raffles_id')
                ->where('raffles.product_id', '=', $request->product_id)
                //->where('raffles.updated_at', 'like', $resultColumn . '%')
                ->whereBetween('raffles.updated_at', [$resultColumn . ' 00:00:00', $resultColumn . ' 23:59:59'])
                ->where('raffles.status', '=', 'Pago')
                ->offset($request->start)
                ->limit($request->length)
                ->orderBy('participant.created_at', 'DESC')
                ->get();

            $rafflesCountAll = DB::table('raffles')
                ->select('raffles.*', 'participant.name as participant', 'participant.telephone', 'participant.created_at')
                ->leftJoin('participant', 'raffles.id', 'participant.raffles_id')
                ->where('raffles.product_id', '=', $request->product_id)
                //->where('raffles.updated_at', 'like', $resultColumn . '%')
                ->whereBetween('raffles.updated_at', [$resultColumn . ' 00:00:00', $resultColumn . ' 23:59:59'])
                ->where('raffles.status', '=', 'Pago')
                ->orderBy('participant.created_at', 'DESC')
                ->get();

            $participantSearchCount = count($rafflesCountAll);
        } else {
            $raffles = DB::table('raffles')
                ->select('raffles.*', 'participant.name as participant', 'participant.telephone', 'participant.created_at')
                ->leftJoin('participant', 'raffles.id', 'participant.raffles_id')
                ->where('raffles.product_id', '=', $request->product_id)
                ->offset($request->start)
                ->limit($request->length)
                ->get();

            $rafflesCountAll = DB::table('raffles')
                ->select('raffles.*', 'participant.name as participant', 'participant.telephone', 'participant.created_at')
                ->leftJoin('participant', 'raffles.id', 'participant.raffles_id')
                ->where('raffles.product_id', '=', $request->product_id)
                ->get();

            $participantSearchCount = count($rafflesCountAll);
        }

        $result = [];

        foreach ($raffles as $raffle) {
            $result[] = [
                "number" => $raffle->number,
                "status" => $raffle->status,
                "name" => $raffle->participant,
                "telephone" => $raffle->telephone,
                "updated_at" => Carbon::parse($raffle->updated_at)->format('d/m/Y H:i:s'),
                "created_at" => Carbon::parse($raffle->created_at)->format('d/m/Y H:i:s')
            ];
        }

        $jsonData = [
            "draw" => $request->draw,
            "recordsTotal" => $participantSearchCount,
            "recordsFiltered" => $participantSearchCount,
            "data" => $result
        ];

        return json_encode([
            "draw" => $request->draw,
            "recordsTotal" => $participantSearchCount,
            "recordsFiltered" => $participantSearchCount,
            "data" => $result
        ]);
    }

    public function editRaffles(Request $request)
    {
        //METODO PARA AJAX
        if ($request->rowData['status'] == 'Disponível') {
            $result[] = [
                "number" => $request->rowData['number'],
                "status" => $request->rowData['status'],
                "name" => $request->rowData['name'],
                "telephone" => $request->rowData['telephone'],
                "updated_at" => $request->rowData['updated_at'],
                "created_at" => $request->rowData['created_at']
            ];
        } else {
            if ($request->rowData['status'] == 'Reservado') {
                $raffles = DB::table('raffles')
                    ->select('raffles.*', 'participant.name as participant', 'participant.telephone', 'participant.created_at')
                    ->leftJoin('participant', 'raffles.id', 'participant.raffles_id')
                    ->leftJoin('payment_pix', 'participant.id', 'payment_pix.participant_id')
                    ->where('raffles.number', $request->rowData['number'])
                    ->where('raffles.product_id', $request->product_id)
                    ->update([
                        'raffles.status' => 'Pago',
                        'raffles.updated_at' => Carbon::now(),
                        'payment_pix.status' => 'Concluída',
                    ]);

                //dd($raffles);

                $result[] = [
                    "number" => $request->rowData['number'],
                    "status" => 'Pago',
                    "name" => $request->rowData['name'],
                    "telephone" => $request->rowData['telephone'],
                    "updated_at" => $request->rowData['updated_at'],
                    "created_at" => $request->rowData['created_at']
                ];
            } elseif ($request->rowData['status'] == 'Pago') {
                $raffles = DB::table('raffles')
                    ->select('raffles.*', 'participant.name as participant', 'participant.telephone', 'participant.created_at')
                    ->leftJoin('participant', 'raffles.id', 'participant.raffles_id')
                    ->leftJoin('payment_pix', 'participant.id', 'payment_pix.participant_id')
                    ->where('raffles.number', $request->rowData['number'])
                    ->where('raffles.product_id', $request->product_id)
                    ->update([
                        'raffles.status' => 'Reservado',
                        'raffles.updated_at' => Carbon::now(),
                        'payment_pix.status' => 'Pendente',
                    ]);

                //dd($raffles);

                $result[] = [
                    "number" => $request->rowData['number'],
                    "status" => 'Reservado',
                    "name" => $request->rowData['name'],
                    "telephone" => $request->rowData['telephone'],
                    "updated_at" => $request->rowData['updated_at'],
                    "created_at" => $request->rowData['created_at']
                ];
            }
        }


        return $result;
    }


    public function profile()
    {
        $users = DB::table('users')
            ->select('users.name', 'users.email', 'users.telephone', 'consulting_environments.logo', 'consulting_environments.key_pix', 'consulting_environments.key_pix_public', 'consulting_environments.pixel', 'consulting_environments.verify_domain_fb', 'consulting_environments.facebook', 'consulting_environments.instagram', 'consulting_environments.name as platform', 'consulting_environments.group_whats', 'consulting_environments.token_asaas', 'consulting_environments.paggue_client_key', 'consulting_environments.paggue_client_secret', 'consulting_environments.tema')
            ->join('consulting_environments', 'consulting_environments.user_id', '=', 'users.id')
            ->where('users.id', '=', Auth::user()->id)
            ->first();

        //dd($users);

        return view('profile', [
            'users' => $users
        ]);
    }

    public function updateProfile(Request $request)
    {

        //dd($request->all());

        if($request->key){
            try {
                \MercadoPago\SDK::setAccessToken($request->key);
            } catch (\Throwable $th) {
                return Redirect::back()->withErrors('ACCESS TOKEN MERCADO PAGO INVÁLIDO.');
            }
        }

        if ($request->senha == null) {
            $users = DB::table('users')
                ->where('users.id', Auth::user()->id)
                ->update(
                    [
                        'name' => $request->name,
                        'telephone' => $request->telephone,
                        'email' => $request->email
                    ]
                );
        } else {
            $users = DB::table('users')
                ->where('users.id', Auth::user()->id)
                ->update(
                    [
                        'name' => $request->name,
                        'telephone' => $request->telephone,
                        'email' => $request->email,
                        'password' => bcrypt($request->senha)
                    ]
                );
        }

        $consulting = DB::table('consulting_environments')
            ->where('consulting_environments.user_id', Auth::user()->id)
            ->update(
                [
                    'key_pix' => $request->key,
                    'key_pix_public' => $request->key_public,
                    'token_asaas' => $request->token_asaas,
                    'paggue_client_key' => $request->paggue_client_key,
                    'paggue_client_secret' => $request->paggue_client_secret,
                    'facebook' => $request->facebook,
                    'instagram' => $request->instagram,
                    'name' => $request->platform,
                    'group_whats' => $request->group_whats,
                    'tema' => $request->tema
                ]
            );

        return back()->with('success', 'Perfil atualizado com sucesso!');
    }

    public function removeReserved(Request $request)
    {
        $participants = DB::table('participant')
            ->select('participant.id', 'participant.raffles_id', 'participant.name', 'participant.telephone', 'participant.product_id', 'payment_pix.key_pix', 'payment_pix.status')
            ->join('raffles', 'participant.raffles_id', '=', 'raffles.id')
            ->leftJoin('payment_pix', 'participant.id', '=', 'payment_pix.participant_id')
            ->where('participant.product_id', '=', $request->product_id)
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

            if ($participant->key_pix == null) {
            } else {
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
            }

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

        return redirect()->back();
    }

    public function pixel(Request $request)
    {
        DB::table('consulting_environments')
            ->where('user_id', Auth::user()->id)
            ->update(
                [
                    'pixel' => $request->pixel,
                    'verify_domain_fb' => $request->verify
                ]
            );

        return redirect()->back();
    }

    public function resumoPDF($id)
    {
        $participante = Participante::find($id);
        $config = DB::table('consulting_environments')->where('id', '=', 1)->first();

        $data = [
            'participante' => $participante,
            'config' => $config
        ];

        //return view('pdf.resumoRifa', $data);

        $view = view('pdf.resumoRifa', $data)->render();

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);


        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($view);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrati');

        // Render the HTML as PDF
        $dompdf->render();

        $dompdf->stream('Resumo ' . $participante->name . '.pdf');
    }

    public function excluirFoto(Request $request)
    {
        try {
            CreateProductimage::find($request->id)->delete();

            $response['message'] = 'Imagem excluida com sucesso!';
            $response['success'] = true;


            return $response;
        } catch (\Throwable $th) {
            $response['error'] = $th->getMessage();

            return $response;
        }
    }

    public function compras($idRifa, Request $request)
    {
        $rifa = ModelsProduct::find($idRifa);

        $data = [
            'rifa' => $rifa,
            'participantes' => $rifa->participantes(),
            'situacao' => '',
            'request' => $request->all()
        ];

        return view('compras.compras', $data);
    }

    public function comprasBusca($idRifa, Request $request)
    {
        $rifa = ModelsProduct::find($idRifa);
        $participantes = $rifa->participantes();

        if ($request->cota) {
            $participantes = Participante::where('id', '<', 0)->get();

            foreach ($rifa->participantes() as $participante) {
                $numbersParticipante = $participante->numbers();
                $find = array_search($request->cota, $numbersParticipante);
                if (is_int($find)) {
                    $participantes = Participante::where('id', '=', $participante->id)->get();
                    break;
                }
            }
        } else {
            if ($request->search) {
                $participantes = Participante::where('product_id', '=', $idRifa)
                    ->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')->get();
            }

            if ($request->telephone) {
                $participantes = $participantes->where('telephone', '=', $request->telephone);
            }

            if ($request->idCompra) {
                $participantes = $participantes->where('id', '=', $request->idCompra);
            }
        }

        $data = [
            'rifa' => $rifa,
            'participantes' => $participantes,
            'situacao' => $request->situacao,
            'request' => $request->all()
        ];

        return view('compras.compras', $data);
    }

    public function liberarTodasReservas(Request $request)
    {
        DB::beginTransaction();
        try {
            $rifa = ModelsProduct::find($request->id);

            if ($rifa->modo_de_jogo == 'numeros') {
                foreach ($rifa->participantes()->where('reservados', '>', 0) as $participante) {
                    $rifaNumbers = $rifa->numbers();
                    $numbersParticipante = $participante->numbers();


                    foreach ($numbersParticipante as $number) {
                        array_push($rifaNumbers, $number);
                        // $rifaNumbers[$number->key]['status'] = 'Disponivel';
                    }

                    sort($rifaNumbers);
                    $rifa->saveNumbers($rifaNumbers);
                    Participante::find($participante->id)->delete();
                }
            } else {
                foreach ($rifa->participantesReservados() as $numero) {
                    Participante::find($numero->participant_id)->delete();
                    Raffle::where('status', '=', 'Reservado')->where('participant_id', '=', $numero->participante_id)->update([
                        'status' => 'Disponível',
                        'participant_id' => null
                    ]);
                }
            }

            DB::commit();

            $response['message'] = 'Reservas liberadas com sucesso!';
            return $response;
        } catch (\Throwable $th) {
            DB::rollBack();

            $response['error'] = 'Erro interno!';
            $response['debug'] = $th->getMessage();

            return $response;
        }
    }

    public function randomNumbers(Request $request)
    {
        $rifa = ModelsProduct::find($request->id);
        if ($request->qtd > $rifa->qtdNumerosDisponiveis()) {
            $response['error'] = 'A rifa só tem ' . $rifa->qtdNumerosDisponiveis() . ' números disponíveis';
            return $response;
        } else {
            $response['numbers'] = $rifa->randomNumbers($request->qtd);

            return $response;
        }
    }

    public function criarCompra(Request $request)
    {
        $rifa = ModelsProduct::find($request->idRifa);

        DB::beginTransaction();
        try {
            if ($rifa->modo_de_jogo == 'numeros') {

                $resultNumbers = explode(",", $request->numeros);

                $valorNumero = $this->formatMoney($rifa->price);
                $totalCompra = $request->qtdNumeros * $valorNumero;

                $disponiveis = $rifa->numbers();
                shuffle($disponiveis);

                $selecionados = array_slice($disponiveis, 0, $request->qtdNumeros);

                if (count($disponiveis) < $request->qtdNumeros) {
                    return Redirect::back()->withErrors('Quantidade indisponível para a rifa selecionada. A quantidade disponível é: ' . count($disponiveis));
                }

                foreach ($selecionados as $key => $resultNumber) {
                    $resutlNumbers[] = $resultNumber;
                    unset($disponiveis[$key]);
                }

                if ($rifa->qtdNumerosDisponiveis() < count($resultNumbers)) {
                    return Redirect::back()->withErrors('Qtd indisponível!');
                }

                sort($disponiveis);
                $rifa->saveNumbers($disponiveis);

                if ($request->status == 'Pago') {

                    $participante = DB::table('participant')->insertGetId([
                        'name' => $request->nome,
                        'telephone' => $request->telefone,
                        'email' => '',
                        'cpf' => '',
                        'valor' => $totalCompra,
                        'product_id' => $rifa->id,
                        'numbers' => json_encode($selecionados),
                        'pagos' => count($selecionados),
                        'reservados' => 0,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);


                    DB::commit();

                    return back()->with('success', 'Compra criada com sucesso!');
                } else if ($request->status == 'Pendente') {
                    $codeKeyPIX = DB::table('consulting_environments')
                        ->select('key_pix')
                        ->where('user_id', '=', 1)
                        ->first();

                    $resultPricePIX = number_format($totalCompra, 2, ".", ",");

                    \MercadoPago\SDK::setAccessToken($codeKeyPIX->key_pix);

                    $resultPricePIX = str_replace(",", "", $resultPricePIX);

                    $payment = new \MercadoPago\Payment();
                    $payment->transaction_amount = $resultPricePIX;
                    $payment->description = "Participação da ação " . $rifa->id . ' - ' . $rifa->name;
                    $payment->payment_method_id = "pix";

                    $payment->payer = array(
                        "email" => "teste.nienow@email.com",
                        "first_name" => $request->nome,
                        "identification" => array(
                            "type" => "hash",
                            "number" => date('YmdHis')
                        )
                    );

                    $participante = DB::table('participant')->insertGetId([
                        'name' => $request->nome,
                        'telephone' => $request->telefone,
                        'email' => '',
                        'cpf' => '',
                        'valor' => $totalCompra,
                        'numbers' => json_encode($selecionados),
                        'reservados' => count($selecionados),
                        'pagos' => 0,
                        'product_id' => $rifa->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);



                    //Gravando o id do participante para utilizar na notificacao
                    $payment->notification_url   = env('APP_ENV') == 'local' ? '' : route('api.notificaoMP');
                    $payment->external_reference = $participante;
                    $payment->save();

                    $object = (object) $payment;

                    if (isset($object->error->message) == 'Invalid user identification number') {
                        return Redirect::back()->withErrors('CPF invalido digite corretamente!');
                    }

                    $codePIXID = $object->id;
                    $codePIX = $object->point_of_interaction->transaction_data->qr_code;
                    $qrCode = $object->point_of_interaction->transaction_data->qr_code_base64;

                    $paymentPIX = DB::table('payment_pix')->insert([
                        'key_pix' => $codePIXID,
                        'full_pix' => $codePIX,
                        'status' => 'Pendente',
                        'participant_id' => $participante,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                    // Raffle::where('product_id', '=', $rifa->id)
                    //     ->whereIn('number', $resultNumbers)
                    //     ->update([
                    //         'status' => 'Reservado',
                    //         'participant_id' => $participante,
                    //         'updated_at' => Carbon::now()
                    //     ]);

                    $order = Order::create([
                        'key_pix' => $codePIXID,
                        'participant_id' => $participante,
                        'valor' => $totalCompra,
                    ]);

                    // if (isset($selecionados)) {
                    //     foreach ($selecionados as $selecionado) {
                    //         if ($numbersRifa[$selecionado['key']]['status'] != 'Disponivel') {
                    //             return Redirect::back()->withErrors('Acabaram de reservar um ou mais numeros escolhidos, por favor escolha outros números :)');
                    //         }

                    //         $numbersRifa[$selecionado['key']]['status'] = 'Reservado';
                    //         $numbersRifa[$selecionado['key']]['participant_id'] = $participante;

                    //         $selecionado['status'] = 'Pago';
                    //         $selecionado['participant_id'] = $participante;
                    //     }

                    //     $arquivo = 'numbers/' . $rifa->id . '.json';
                    //     $req = fopen($arquivo, 'w') or die('Cant open the file');
                    //     fwrite($req, json_encode($numbersRifa));
                    //     fclose($req);

                    //     $arquivoDebug = 'numbers/' . $rifa->id . '-debug3.json';
                    //     $req = fopen($arquivoDebug, 'w') or die('Cant open the file');
                    //     fwrite($req, json_encode($numbersRifa));
                    //     fclose($req);

                    //     Participante::where('id', '=', $participante)->update([
                    //         'numbers' => json_encode($selecionados)
                    //     ]);
                    // }

                    $dadosSave = [
                        'participant_id' => $participante,
                        'participant' => $request->nome,
                        'cpf' => '',
                        'email' => '',
                        'telephone' => $request->telefone,
                        'price' => $totalCompra,
                        'product' => $rifa->name,
                        'productID' => $rifa->id,
                        'drawdate' => $rifa->draw_date,
                        'image' => $rifa->imagem()->name,
                        'PIX' => $resultPricePIX,
                        'countRaffles' => count($resultNumbers),
                        'priceUnic' => number_format(0, 2, ".", ","),
                        'codePIX' => $codePIX,
                        'qrCode' => $qrCode,
                        'codePIXID' => $codePIXID
                    ];

                    $order->dados = json_encode($dadosSave);
                    $order->update();

                    DB::commit();

                    return back()->with('success', 'Compra criada com sucesso!');
                }
            } else {
                return Redirect::back()->withErrors('Funcão não implementada para o tipo Fazendinha');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors($th->getMessage());
        }
    }

    public function detalhesCompra(Request $request)
    {
        $participante = Participante::find($request->id);
        $msgs = WhatsappMensagem::where('titulo', '!=', '')->where('msg', '!=', '')->get();
        $config = Environment::find(1);

        $data = [
            'participante' => $participante,
            'msgs' => $msgs,
            'config' => $config
        ];

        $response['html'] = view('compras.layouts.modal-detalhes-content', $data)->render();

        return $response;
    }

    public function ganhadores()
    {
        $ganhadores = Premio::where('descricao', '!=', '')->where('ganhador', '!=', '')->get();

        $data = [
            'ganhadores' => $ganhadores
        ];

        return view('painel.ganhadores', $data);
    }

    public function addFotoGanhador(Request $request)
    {
        try {
            $ganhador = Premio::find($request->idGanhador);
            $path = 'ganhadores';

            $upload_imagename = time() . '.' . $request->foto->getClientOriginalExtension();
            $upload_url = public_path('/products') . '/' . $upload_imagename;

            $filename = $this->compress_image($_FILES["foto"]["tmp_name"], $upload_url, 80);

            $ganhador->update([
                'foto' =>  'products/' . $upload_imagename,
            ]);

            return back()->with('success', 'Foto alterada com sucesso!');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public  function compress_image($source_url, $destination_url, $quality)
    {
        $info = getimagesize($source_url);

        if ($info['mime'] == 'image/jpeg') {
            $image = imagecreatefromjpeg($source_url);
            $image = imagescale($image, 1080, 1080);
            //dd($imgResized);
        } elseif ($info['mime'] == 'image/gif') {
            $image = imagecreatefromgif($source_url);
            $image = imagescale($image, 1080, 1080);
        } elseif ($info['mime'] == 'image/png') {
            $image = imagecreatefrompng($source_url);
            $image = imagescale($image, 1080, 1080);
        }

        imagejpeg($image, $destination_url, $quality);

        return $destination_url;
    }

    public function tutoriais()
    {
        $data = [
            'videos' => Video::all()
        ];

        return view('tutorial', $data);
    }

    public function cadastroVideos()
    {
        $data = [
            'videos' => Video::all()
        ];

        return view('dev.cadastroVideos', $data);
    }

    public function salvarVideo(Request $request)
    {
        Video::create($request->all());

        return back();
    }

    public function excluirVideo($id)
    {
        Video::find($id)->delete();

        return back();
    }

    public function resumoRifa($id)
    {
        $rifa = ModelsProduct::find($id);
        $config = DB::table('consulting_environments')->where('id', '=', 1)->first();

        $data = [
            'rifa' => $rifa,
            'config' => $config
        ];

        return view('resumoRifa', $data);
    }

    public function imprimirResumoCompra($id)
    {
        $participante = Participante::find($id);
        $data = [
            'participante' => $participante
        ];

        return view('imprimirDetalheCompra', $data);
    }

    public function resumoLucro()
    {
        $participantes = Participante::where('pagos', '>', 0)->paginate(10);

        $data = [
            'participantes' => $participantes
        ];

        return view('resumo-home.lucro', $data);
    }

    public function resumoPedidos()
    {
        $participantes = Participante::paginate(10);

        $data = [
            'participantes' => $participantes
        ];

        return view('resumo-home.pedidos', $data);
    }

    public function resumoPendentes()
    {
        $participantes = Participante::where('reservados', '>', 0)->paginate(10);

        $data = [
            'participantes' => $participantes,
            'paginate' => true
        ];

        return view('resumo-home.pendente', $data);
    }

    public function resumoPendentesSearc(Request $request)
    {
        $participantes = Participante::where('reservados', '>', 0)->get();
        $search = new Collection();

        foreach ($participantes as $participante) {
            $numbersParticipante = $participante->numbers();
            $find = array_search($request->cota, $numbersParticipante);
            if (is_int($find)) {
                $search->push($participante);
            }
        }

        $data = [
            'participantes' => $search,
            'paginate' => false
        ];

        return view('resumo-home.pendente', $data);
    }

    public function resumoRifasAtivas()
    {
        $data = [
            'rifas' => ModelsProduct::where('status', '=', 'Ativo')->get()
        ];

        return view('resumo-home.rifas-ativas', $data);
    }

    public function resumoRanking()
    {
        $rifas = ModelsProduct::all();

        $data = [
            'rifas' => $rifas,
            'rifaSelected' => $rifas->count() > 0 ? $rifas[0] : $rifas
        ];

        return view('resumo-home.ranking', $data);
    }

    public function resumoRankingSelect(Request $request)
    {
        $rifas = ModelsProduct::all();

        $data = [
            'rifas' => $rifas,
            'rifaSelected' => ModelsProduct::find($request->rifa)
        ];

        return view('resumo-home.ranking', $data);
    }

    public function listaAfiliados()
    {
        $afiliados = User::where('afiliado', '=', true)->get();

        $data = [
            'afiliados' => $afiliados
        ];

        return view('listaAfiliados', $data);
    }

    public function solicitacaoPgto()
    {
        $solicitacoes = SolicitacaoAfiliado::all();

        $data = [
            'solicitacoes' => $solicitacoes
        ];

        return view('solicitacaoAfiliados', $data);
    }

    public function confirmarPgtoAfiliado($solicitacaoId)
    {
        DB::beginTransaction();
        try {
            $solicitacao = SolicitacaoAfiliado::find($solicitacaoId);
            $solicitacao->update([
                'pago' => true
            ]);

            GanhosAfiliado::where('solicitacao_id', '=', $solicitacao->id)->update([
                'pago' => true
            ]);

            DB::commit();

            return back()->with(['message' => 'Pagamento confirmado com sucesso!']);
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->withErrors('Erro interno do sistema!');
        }
    }

    public function excluirAfiliado($id)
    {
        try {
            User::where('id', '=', $id)->delete();

            return back()->with(['message' => 'Afiliado excluído com sucesso!']);
        } catch (\Throwable $th) {
            return back()->withErrors('Erro ao excluir afiliado');
        }
    }

    public function sendMessageAPIWhats(Request $request)
    {
        $msg = WhatsappMensagem::find($request->msg_id);
        $participante = Participante::find($request->participante_id);
        $apiURL = env('URL_API_CRIAR_WHATS');
        $config = Environment::find(1);

        $mensagem = $msg->getMessage($participante);
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

            return $response;
        } catch (\Throwable $th) {
            $response['success'] = false;
            $response['debug'] = $th->getMessage();

            return $response;
        }
    }

    public function rifaPremiada()
    {
        $rifas = ModelsProduct::select('id', 'name')->where('id', '>', 0)->orderBy('id', 'desc')->get();

        $data = [
            'rifas' => $rifas
        ];

        return view('rifaPremiada.index', $data);
    }

    public function getRifa(Request $request)
    {
        $data = [
            'rifa' => ModelsProduct::select('id')->where('id', '=', $request->id)->first()
        ];

        $response['html'] = view('rifaPremiada.rifaSelecionada', $data)->render();

        return $response;
    }

    public function buscarCotaPremiada(Request $request)
    {
        $participantes = Participante::where('id', '<', 0)->get();

        $rifa = ModelsProduct::select('id')->where('id', '=', $request->id)->first();

        foreach ($rifa->participantes() as $participante) {
            $numbersParticipante = $participante->numbers();
            $find = array_search($request->cota, $numbersParticipante);
            if (is_int($find)) {
                $participantes = Participante::where('id', '=', $participante->id)->get();
                break;
            }
        }

        if($participantes->count() > 0){
            $ganhador = $participantes->first();

            $data = [
                'ganhador' => $ganhador,
                'cota' => $request->cota
            ];

            $response['html'] = view('rifaPremiada.ganhador', $data)->render();
        }
        else{
            $response['html'] = 'Cota não encontrada!';
        }

        return $response;
    }
}
