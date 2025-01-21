<?php



namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Product;
use App\ProductsDescription;
use App\CreateProductimage;
use App\Promocao;
use Illuminate\Support\Facades\Redirect;

class ProductAdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
            
    }
    /*public function update(Request $request, $id){
        $products = Product::find(6)
            ->select('products.id', 'products.name', 'products.price', 'products.type_raffles', 'products.winner', 'products.slug', 'products_images.name as image', 'raffles.number as total_number', 'product_description.description as description', 'products.status', 'products.draw_date', 'products.draw_prediction', 'products.visible', 'products.favoritar')
            ->join('products_images', 'products.id', 'products_images.product_id')
            ->join('product_description', 'products.id', 'product_description.product_id')
            ->join('raffles', 'products.id', 'raffles.product_id')           
            ->groupBy('products.id')
            ->orderBy('products.id', 'DESC')
            ->get();
        return view('my-sweepstakes', [           
            'products' => $products
        ]);
        
    }*/
    public function destroy(Request $request){
        
        $id = $request->input('deleteId');
        $produto_descricao = DB::table('product_description')
            ->select('description')
            ->join('products', 'products.id', '=', 'product_description.product_id')
            ->where('products.id', '=', $id)
            ->first();
        //dd($produto_descricao[0]);
        //$produto_descricao->delete();
        
        $product_delete = Product::find($id);

        $path = 'numbers/' . $product_delete->id . '.json';
        if(file_exists($path)){
            unlink($path);
        }

        $name_rifa = $product_delete->name;
        $product_delete->delete();  
        return redirect('/meus-sorteios')->with('success', 'Rifa ('.$name_rifa.') excluida com Sucesso');
    }

    //FUNÇÃO PARA SLUG
    public static function createSlug($string)
    {

        $table = array(
            'Š' => 'S', 'š' => 's', 'Đ' => 'Dj', 'đ' => 'dj', 'Ž' => 'Z', 'ž' => 'z', 'Č' => 'C', 'č' => 'c', 'Ć' => 'C', 'ć' => 'c',
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
            'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
            'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
            'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
            'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b',
            'ÿ' => 'y', 'Ŕ' => 'R', 'ŕ' => 'r', '/' => '-', ' ' => '-'
        );

        // -- Remove duplicated spaces
        $stripped = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $string);


        // -- Returns the slug
        return strtolower(strtr($string, $table));
    }

    public function addProduct(Request $request)
    {

        //dd($request->all());

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|max:6',
            'images' => 'required|max:3',
            'numbers' => 'required|min:1|max:7',
            'description' => env('REQUIRED_DESCRIPTION') ? 'required|max:50000' : '',
            'minimo' => 'required',
            'maximo' => 'required',
            'expiracao' => 'required|min:0',
            'gateway' => 'required'
        ]);

        // Verificando token do gateway de pagamento
        $codeKeyPIX = DB::table('consulting_environments')
            ->select('key_pix', 'token_asaas', 'paggue_client_key', 'paggue_client_secret')
            ->where('user_id', '=', 1)
            ->first();

        if($request->gateway == 'mp' && !$codeKeyPIX->key_pix){
            return Redirect::back()->withErrors('Para utilizar o gaeway de pagamento Mercado Pago é necessário informar o token na sessão "Meu Perfil"');
        }

        if($request->gateway == 'asaas' && !$codeKeyPIX->token_asaas){
            return Redirect::back()->withErrors('Para utilizar o gaeway de pagamento ASAAS é necessário informar o token na sessão "Meu Perfil"');
        }

        if($request->gateway == 'paggue' && (!$codeKeyPIX->paggue_client_key || !$codeKeyPIX->paggue_client_secret)){
            return Redirect::back()->withErrors('Para utilizar o gaeway de pagamento Paggue é necessário informar o CLIENT KEY e CLIENT SECRET na sessão "Meu Perfil"');
        }

        
        $product = DB::table('products')->insertGetId(
            [
                'name' => $request->name,
                'subname' => $request->subname,
                'price' => $request->price,
                'qtd' => $request->numbers,
                'expiracao' => $request->expiracao,
                'processado' => true,
                'status' => 'Ativo',
                'type_raffles' => 'automatico',
                'slug' => $this->createSlug($request->name),
                'user_id' => Auth::user()->id,
                'visible' => 0,
                'minimo' => $request->minimo,
                'maximo' => $request->maximo,
                'modo_de_jogo' => $request->modo_de_jogo,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'gateway' => $request->gateway
            ]
        );

        // criando as promocoes
        for($i = 1; $i <= 4; $i++){
            Promocao::create([
                'product_id' => $product,
                'ordem' => $i
            ]);
        }

        $files = $request->file('images');

        if ($request->hasFile('images')) {
            foreach ($files as $key => $images) {
                $upload_imagename = $key . time() . '.' . $images->getClientOriginalExtension();
                $upload_url = public_path('/products') . '/' . $upload_imagename;

                $filename = $this->compress_image($_FILES["images"]["tmp_name"][$key], $upload_url, 80);

                DB::table('products_images')->insert(
                    [
                        'name' => $upload_imagename,
                        'product_id' => $product,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]
                );
            }
        }

        if(str_starts_with($request->modo_de_jogo, 'fazendinha')){
            if($request->modo_de_jogo == 'fazendinha-completa'){
                for ($i = 1; $i <= 25; $i++) {
                    DB::table('raffles')->insert(
                        [
                            'number' => 'g'.$i,
                            'status' => 'Disponível',
                            'product_id' => $product,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]
                    );
                }
            }
            else if($request->modo_de_jogo == 'fazendinha-meio'){
                for ($i = 1; $i <= 25; $i++) {
                    DB::table('raffles')->insert(
                        [
                            'number' => 'g'. $i . '-le',
                            'status' => 'Disponível',
                            'product_id' => $product,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]
                    );

                    DB::table('raffles')->insert(
                        [
                            'number' => 'g'. $i . '-ld',
                            'status' => 'Disponível',
                            'product_id' => $product,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]
                    );
                }
            }
            
        }
        else{
            $qtdNumbers = $request->numbers;

            $arr = [];

            for ($x = 0; $x < $qtdNumbers; $x++) {
                $nbr = str_pad($x, strlen((string)$qtdNumbers),  '0', STR_PAD_LEFT);
                array_push($arr, $nbr);

                // $arr[$nbr] = [
                //     'key' => $nbr,
                //     'number' => str_pad($x, strlen((string)$qtdNumbers),  '0', STR_PAD_LEFT),
                //     'status' => 'Disponivel',
                //     'participant_id' => 0,
                // ];
            }

            $numbers = json_encode($arr);

            $arquivo = 'numbers/' . $product . '.json';
            $req = fopen($arquivo, 'w') or die('Cant open the file');
            fwrite($req, $numbers);
            fclose($req);

            // for ($i = 1; $i <= $qtdNumbers; $i++) {
            //     if ($qtdNumbers <= '100') {
            //         DB::table('raffles')->insert(
            //             [
            //                 'number' => str_pad($i - 1, 2, '0', STR_PAD_LEFT),
            //                 'status' => 'Disponível',
            //                 'product_id' => $product,
            //                 'created_at' => Carbon::now(),
            //                 'updated_at' => Carbon::now()
            //             ]
            //         );
            //     } elseif ($qtdNumbers <= '999') {
            //         DB::table('raffles')->insert(
            //             [
            //                 'number' => str_pad($i, 3, '0', STR_PAD_LEFT),
            //                 'status' => 'Disponível',
            //                 'product_id' => $product,
            //                 'created_at' => Carbon::now(),
            //                 'updated_at' => Carbon::now()
            //             ]
            //         );
            //     } else {
            //         DB::table('raffles')->insert(
            //             [
            //                 'number' => str_pad($i, 4, '0', STR_PAD_LEFT),
            //                 'status' => 'Disponível',
            //                 'product_id' => $product,
            //                 'created_at' => Carbon::now(),
            //                 'updated_at' => Carbon::now()
            //             ]
            //         );
            //     }
            // }
        }


        

        DB::table('product_description')->insert(
            [
                'description' => $request->description,
                'product_id' => $product,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        return redirect()->back()->with('success', 'Cadastro da Rifa efetuado com sucesso!');
    }

    public function alterProduct(Request $request)
    {

        $validatedData = $request->validate([
            //'name' => 'required|max:255',
            //'price' => 'required|max:6',
            'images' => 'required',
            //'numbers' => 'required|min:1|max:5',
            //'description' => 'required|max:5000',
        ]);

        $files = $request->file('images');

        if ($request->hasFile('images')) {

            DB::table('products_images')->where('product_id', '=', $request->product_id)->delete();

            foreach ($files as $key => $images) {
                $upload_imagename = $key . time() . '.' . $images->getClientOriginalExtension();
                $upload_url = public_path('/products') . '/' . $upload_imagename;

                $filename = $this->compress_image($_FILES["images"]["tmp_name"][$key], $upload_url, 80);

                DB::table('products_images')->insert(
                    [
                        'name' => $upload_imagename,
                        'product_id' => $request->product_id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]
                );
            }
        }

        return redirect()->back()->with('success', 'Cadastro efetuado com sucesso!');
    }

    public function alterarLogo(Request $request)
    {
        if ($request->hasFile('logo')) {
            $logo = $request->logo;

            $upload_imagename = time() . '.' . $logo->getClientOriginalExtension();
            $upload_url = public_path('/products') . '/' . $upload_imagename;
            
            if(move_uploaded_file($_FILES['logo']['tmp_name'], $upload_url)){
                
            }
            else{
                return redirect()->back()->withErrors('Erro ao atualizar a logo');
            }

            DB::table('consulting_environments')->where('id', '=', 1)->update([
                'logo' => $upload_imagename
            ]);

            return redirect()->back()->with('success', 'Logo alterada com sucesso!');
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

    public function drawDate(Request $request)
    {
        $validatedData = $request->validate([
            'drawdate' => 'required',
        ]);

        //dd($request->drawdate);
        $originalDate = $request->drawdate;
        $newDate = date('Y-m-d H:i', strtotime(str_replace("/", "-", $originalDate)));

        //dd($newDate);

        DB::table('products')
            ->where('id', $request->product_id)
            ->where('user_id', Auth::user()->id)
            ->update(
                [
                    'status' => 'Agendado',
                    'draw_date' => $newDate
                ]
            );

        return redirect()->back()->with('success', 'Cadastro efetuado com sucesso!');
    }

    public function drawPrediction(Request $request)
    {
        $validatedData = $request->validate([
            'drawPrediction' => 'required',
        ]);

        //dd($request->drawdate);
        $originalDate = $request->drawPrediction;
        $newDate = date('Y-m-d H:i', strtotime(str_replace("/", "-", $originalDate)));

        //dd($newDate);

        DB::table('products')
            ->where('id', $request->product_id)
            ->where('user_id', Auth::user()->id)
            ->update(
                [
                    'draw_prediction' => $newDate
                ]
            );

        return redirect()->back()->with('success', 'Cadastro efetuado com sucesso!');
    }

    public function alterStatusProduct(Request $request)
    {
        if (isset($request['switch'])) {
            //dd($request->all());

            DB::table('products')
                ->where('id', $request->product_id)
                ->where('user_id', Auth::user()->id)
                ->update(
                    [
                        'visible' => 1,
                    ]
                );
        } else {
            //dd("N EXISTE A VARIAVEL");

            DB::table('products')
                ->where('id', $request->product_id)
                ->where('user_id', Auth::user()->id)
                ->update(
                    [
                        'visible' => 0,
                    ]
                );
        }

        return redirect()->back();
    }

    public function favoritarRifa(Request $request)
    {
        if (isset($request['switch-favoritar'])) {
            //dd($request->all());

            DB::table('products')
                ->where('id', $request->product_id)
                ->where('user_id', Auth::user()->id)
                ->update(
                    [
                        'favoritar' => 1,
                    ]
                );
        } else {
            //dd("N EXISTE A VARIAVEL");

            DB::table('products')
                ->where('id', $request->product_id)
                ->where('user_id', Auth::user()->id)
                ->update(
                    [
                        'favoritar' => 0,
                    ]
                );
        }

        return redirect()->back();
    }

    public function alterWinnerProduct(Request $request)
    {

        //dd(nl2br($request->winner));

        if ($request->winner == "") {
            DB::table('products')
                ->where('id', $request->product_id)
                ->where('user_id', Auth::user()->id)
                ->update(
                    [
                        'status' => 'Agendado',
                        'winner' => null,
                    ]
                );
        } else {
            DB::table('products')
                ->where('id', $request->product_id)
                ->where('user_id', Auth::user()->id)
                ->update(
                    [
                        'status' => 'Finalizado',
                        'winner' => nl2br($request->winner),
                    ]
                );
        }

        return redirect()->back();
    }

    public function alterTypeRafflesProduct(Request $request)
    {

        //dd($request->all());

        DB::table('products')
            ->where('id', $request->product_id)
            ->where('user_id', Auth::user()->id)
            ->update(
                [
                    'type_raffles' => $request->type,
                ]
            );

        return redirect()->back();
    }

    public function addFoto(Request $request)
    {
        // $request->validate([
        //     'fotos' => 'required|mimes:png,jpeg,jpg'
        // ]);


        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $key => $images) {
                
                $upload_imagename = $key . time() . '.' . $images->getClientOriginalExtension();
                $upload_url = public_path('/products') . '/' . $upload_imagename;

                $filename = $this->compress_image($_FILES["fotos"]["tmp_name"][$key], $upload_url, 80);

                DB::table('products_images')->insert(
                    [
                        'name' => $upload_imagename,
                        'product_id' => $request->idRifa,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]
                );
            }
        }

        return redirect()->back()->with('success', 'Foto(s) adicionadas com sucesso!');
    }
}
