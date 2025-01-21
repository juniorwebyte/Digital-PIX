<?php

namespace App\Http\Controllers;

use App\AutoMessage;
use App\Customer;
use App\Environment;
use App\Models\Participante;
use App\Models\Product;
use App\Models\Raffle;
use App\WhatsappMensagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeAdminController extends Controller
{
    public function index()
    {
        $participantes = Participante::select('valor', 'reservados', 'pagos')->get();
        $rifas = Product::where('status', '=', 'Ativo')->get();

        return view('home-admin', [
            'participantes' => $participantes,
            'rifas' => $rifas
        ]);
    }

    public function wpp()
    {
        if(WhatsappMensagem::all()->count() == 0){
            for ($i=0; $i < 6; $i++) { 
                WhatsappMensagem::create([]);
            }
        }

        $data = [
            'msgs' => WhatsappMensagem::all(),
            'autoMessages' => AutoMessage::where('id', '>', 0)->where('destinatario', '=', 'cliente')->orderBy('destinatario')->get(),
            'config' => Environment::find(1)
        ];


        return view('wpp-msgs.index', $data);
    }

    public function wppSalvar(Request $request)
    {
        foreach ($request->id as $key => $value) {
            WhatsappMensagem::find($value)->update([
                'titulo' => $request->titulo[$value],
                'msg' => nl2br($request->msg[$value]),
            ]);
        }

        foreach ($request->idAuto as $key => $value) {
            AutoMessage::find($value)->update([
                'msg' => $request->msgAuto[$value]
            ]);
        }

        Environment::find(1)->update([
            'token_api_wpp' => $request->token_api_wpp
        ]);

        return redirect()->back()->with('success', 'Mensagens atualizadas com sucesso!');
    }

    public function clientes(Request $request)
    {
        if($request->search){
            $clientes = Customer::where('nome', 'like', '%'.$request->search.'%')->get();
        }
        else{
            $clientes = Customer::all();
        }

        $data = [
            'clientes' => $clientes,
            'search' => $request->search
        ];

        return view('clientes.index', $data);
    }

    public function editarCliente($id)
    {
        $cliente = Customer::find($id);

        $data = [
            'cliente' => $cliente
        ];

        return view('clientes.editar', $data);

    }

    public function updateCliente($id, Request $request)
    {
        $cliente = Customer::find($id);

        if($cliente->telephone != $request->telephone){
            if(Customer::where('telephone', '=', $request->telephone)->get()->count() > 0){
                return back()->withErrors('Telefone já cadastrado.');
            }
        }

        $cliente->update([
            'nome' => $request->nome,
            'telephone' => $request->telephone
        ]);

        Participante::where('customer_id', '=', $cliente->id)->update([
            'name' => $request->nome,
            'telephone' => $request->telephone
        ]);

        return redirect()->route('clientes')->with('success', 'Cliente atualizado com sucesso!');
    }
}

