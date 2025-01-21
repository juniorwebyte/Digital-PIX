<?php

namespace App\Http\Controllers;

use App\Environment;
use App\Models\Participante;
use App\Models\Product;
use App\Models\Raffle;
use App\Payment_pix;
use App\Product as AppProduct;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Http;

//use Barryvdh\DomPDF\Facade\Pdf;

class TestController extends Controller
{
    public function index()
    {
        $lines = file(storage_path('pipocas.txt'));

        $list = array_unique($lines);

        //dd($list);
        foreach ($list as $line) {

            $result = str_replace(array("(", "'", ";", ")", "-"), '', $line);

            $resultNumbers = substr($result, 0, -1);


            $countNumberLine = strlen(str_replace(' ', '', $resultNumbers));
            //strlen($result)

            //dd($resultNumbers);

            if ($countNumberLine == 11) {
                if (str_replace(' ', '', $resultNumbers) == "41999999999" || str_replace(' ', '', $resultNumbers) == "99999999999" || str_replace(' ', '', $resultNumbers) == "13997531259") {
                } else {
                    echo str_replace(' ', '', $resultNumbers) . "<br>";
                }
            } else {
            }
        }
    }

    const ID_PAYLOAD_FORMAT_INDICATOR = '00';
    const ID_MERCHANT_ACCOUNT_INFORMATION = '26';
    const ID_MERCHANT_ACCOUNT_INFORMATION_GUI = '00';
    const ID_MERCHANT_ACCOUNT_INFORMATION_KEY = '01';
    const ID_MERCHANT_ACCOUNT_INFORMATION_DESCRIPTION = '02';
    const ID_MERCHANT_CATEGORY_CODE = '52';
    const ID_TRANSACTION_CURRENCY = '53';
    const ID_TRANSACTION_AMOUNT = '54';
    const ID_COUNTRY_CODE = '58';
    const ID_MERCHANT_NAME = '59';
    const ID_MERCHANT_CITY = '60';
    const ID_ADDITIONAL_DATA_FIELD_TEMPLATE = '62';
    const ID_ADDITIONAL_DATA_FIELD_TEMPLATE_TXID = '05';
    const ID_CRC16 = '63';

    public function wdm()
    {
       $participantes = Participante::where('product_id', '=', 62)->get();

       $data = [
        'participantes' => $participantes
       ];

       return view('dev.teste', $data);
    }

    public function validaParticipantes($id)
    {
        $participantes = Participante::where('product_id', '=', $id)->get();

        $data = [
         'participantes' => $participantes
        ];
 
        return view('dev.teste', $data);
    }

    public function getValue($id, $value)
    {
        $size = str_pad(strlen($value), 2, '0', STR_PAD_LEFT);

        return $id . $size . $value;
    }

    public function getMerchantAccountInfo($pixKey, $description)
    {
        $gui = $this->getValue(self::ID_MERCHANT_ACCOUNT_INFORMATION_GUI, 'br.gov.bcb.pix');
        $key = $this->getValue(self::ID_MERCHANT_ACCOUNT_INFORMATION_KEY, $pixKey);
        $desc = $this->getValue(self::ID_MERCHANT_ACCOUNT_INFORMATION_DESCRIPTION, $description);

        return $this->getValue(self::ID_MERCHANT_ACCOUNT_INFORMATION, $gui . $key . $desc);
    }

    public function getAditionalDataField()
    {
        $txid = $this->getValue(self::ID_ADDITIONAL_DATA_FIELD_TEMPLATE_TXID, '1112');

        return $this->getValue(self::ID_ADDITIONAL_DATA_FIELD_TEMPLATE, $txid);
    }

    private function getCRC16($payload)
    {
        //ADICIONA DADOS GERAIS NO PAYLOAD
        $payload .= self::ID_CRC16 . '04';

        //DADOS DEFINIDOS PELO BACEN
        $polinomio = 0x1021;
        $resultado = 0xFFFF;

        //CHECKSUM
        if (($length = strlen($payload)) > 0) {
            for ($offset = 0; $offset < $length; $offset++) {
                $resultado ^= (ord($payload[$offset]) << 8);
                for ($bitwise = 0; $bitwise < 8; $bitwise++) {
                    if (($resultado <<= 1) & 0x10000) $resultado ^= $polinomio;
                    $resultado &= 0xFFFF;
                }
            }
        }

        //RETORNA CÓDIGO CRC16 DE 4 CARACTERES
        return self::ID_CRC16 . '04' . strtoupper(dechex($resultado));
    }

    public function refreshRaffle($id)
    {
        $rifa = Product::find($id);
        if (!$rifa) {
            dd('rifa nao encontrada');
        }

        if ($rifa->modo_de_jogo != 'numeros') {
            dd('nao e rifa de numeros');
        }


        // Recriando os numeros da rifa
        $numbersRifa = [];
        for ($x = 0; $x < $rifa->qtd; $x++) {
            $nbr = str_pad($x, strlen((string)$rifa->qtd),  '0', STR_PAD_LEFT);
            array_push($numbersRifa, $nbr);
        }

        foreach ($rifa->participantes() as $participante) {
            $oldNumbersParticipante = json_decode($participante->numbers);
            $newNumbersParticipante = [];

            foreach ($oldNumbersParticipante as $oldNbr) {
                if (!is_string($oldNbr)) {
                    $nbr = $oldNbr->number;
                } else {
                    $nbr = $oldNbr;
                }
                array_push($newNumbersParticipante, $nbr);

                $keyRifa = array_search($nbr, $numbersRifa);
                unset($numbersRifa[$keyRifa]);
            }

            $participante->update([
                'numbers' => json_encode($newNumbersParticipante, true)
            ]);
        }

        $finishNumbers = [];
        foreach ($numbersRifa as $value) {
            array_push($finishNumbers, $value);
        }

        $rifa->saveNumbers($finishNumbers);

        dd('refresh finalizado');
    }

    public function refreshOnlyRaffle($id)
    {
        try {
            $rifa = Product::find($id);
            if (!$rifa) {
                dd('rifa nao encontrada');
            }

            if ($rifa->modo_de_jogo != 'numeros') {
                dd('nao e rifa de numeros');
            }


            // Recriando os numeros da rifa
            $numbersRifa = [];
            for ($x = 0; $x < $rifa->qtd; $x++) {
                $nbr = str_pad($x, strlen((string)$rifa->qtd),  '0', STR_PAD_LEFT);
                array_push($numbersRifa, $nbr);
            }

            $rifa->saveNumbers($numbersRifa);

            // Participante::where('product_id', '=', $rifa->id)->update([
            //     'conferido' => false
            // ]);

            return back()->with(['message' => 'Zerado com sucesso!']);

            $response['success'] = true;

            return json_encode($response);
        } catch (\Throwable $th) {
            $response['success'] = false;

            return $response;
        }
    }

    public function atualizarRifa($id)
    {
        try {
            $rifa = Product::find($id);

            $path = public_path() . '/numbers/' . $rifa->id . '.json';
            $jsonString = file_get_contents($path);
            $numbersRifa = json_decode($jsonString, true);

            $rifa->saveNumbers($numbersRifa);

            $response['success'] = true;

            return json_encode($response);
        } catch (\Throwable $th) {
            $response['success'] = false;
            $response['debug'] = $th->getMessage();

            return $response;
        }
    }

    public function refreshParticipante($id)
    {
        try {
            $participante = Participante::find($id);

            $numeros = Raffle::where('participant_id', '=', $participante->id)->get();

            if ($numeros->count() > 0) {
                $partNumbes = [];
                foreach ($numeros as $numero) {
                    array_push($partNumbes, $numero->number);
                }

                $participante->update([
                    'numbers' => json_encode($partNumbes),
                    'pagos' => count($partNumbes)
                ]);
            }

            $response['success'] = true;

            return $response;
        } catch (\Throwable $th) {
            $response['success'] = false;
            $response['debug'] = $th->getMessage();

            return $response;
        }
    }

    public function refreshRafflesNewVersion()
    {
        $rifas = Product::where('modo_de_jogo', '=', 'numeros')->get();

        foreach ($rifas as $rifa) {
            $oldNumbers = Raffle::where('product_id', '=', $rifa->id)->get();
            if ($oldNumbers->count() == 0) {
                // Recriando os numeros da rifa
                $numbersRifa = [];
                for ($x = 0; $x < $rifa->qtd; $x++) {
                    $nbr = str_pad($x, strlen((string)$rifa->qtd),  '0', STR_PAD_LEFT);
                    array_push($numbersRifa, $nbr);
                }

                foreach ($rifa->participantes() as $participante) {
                    $oldNumbersParticipante = json_decode($participante->numbers);
                    $newNumbersParticipante = [];

                    foreach ($oldNumbersParticipante as $oldNbr) {
                        $nbr = $oldNbr->number;
                        array_push($newNumbersParticipante, $nbr);

                        $keyRifa = array_search($nbr, $numbersRifa);
                        unset($numbersRifa[$keyRifa]);
                    }

                    $participante->update([
                        'numbers' => json_encode($newNumbersParticipante)
                    ]);
                }

                $finishNumbers = [];
                foreach ($numbersRifa as $value) {
                    array_push($finishNumbers, $value);
                }

                $rifa->saveNumbers($finishNumbers);
            }
        }

        dd('finalizado');
    }

    public function updateRaffleWDM()
    {
        $rifas = Product::where('modo_de_jogo', '=', 'numeros')->where('status', '=', 'Ativo')->get();

        $data = [
            'rifas' => $rifas
        ];

        return view('updateRifa', $data);
    }

    public function atualizarParticipanteRifa($id)
    {
        $rifa = Product::find($id);

        $data = [
            'rifa' => $rifa,
            'participantes' => $rifa->participantes()->where('conferido', '=', 0),
            'situacao' => '',
            'request' => null
        ];

        return view('dev.atualizarParticipante', $data);
    }

    public function checkPayments()
    {
        $codeKeyPIX = DB::table('consulting_environments')
            ->select('key_pix')
            ->where('user_id', '=', 1)
            ->first();

        $secretKey = $codeKeyPIX->key_pix;
        $lsRifas = 'APP_USR-5642469567286576-101618-58b7d3d300da8033b802f05d77d4e6e1-542505668';
        $alamRifas = 'APP_USR-1037867207997473-062613-96a193f534f3a35b23aac1b98ada493e-1074737870';
        $appOsincriveis = 'APP_USR-5261151288450206-070203-6d3620d89d07ea1a4b47999ea3b80252-781237219';
        $secretKey = $lsRifas;

        \MercadoPago\SDK::setAccessToken($secretKey);

        $pendentes = Payment_pix::where('status', '=', 'Pendente')->get();

        $codes = [
            '61322685214', 
            '61322750016',
            '61209244429',
            '61322999080',
            '61323063402'
        ];

        $result = [];
        foreach ($codes as $code) {
            $payment = \MercadoPago\Payment::find_by_id($code);

            array_push($result, $code . ' - ' . $payment->status . ' => URL: ' . $payment->notification_url);
        }

        dd($result);

        $data = [
            'pagamentos' => $pendentes
        ];


        return view('dev.checkPayments', $data);
    }

    public function defaultToken()
    {
        $config = Environment::find(1)->update([
            'key_pix' => null,
            'key_pix_public' => null
        ]);

        dd('token zerado');
    }
}
