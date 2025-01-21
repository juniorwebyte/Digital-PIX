@extends('layouts.admin')

@section('content')
    <div class="container mt-3" style="max-width:100%;min-height:100%;">
        <div class="table-wrapper ">
            <div class="table-title">
                <div class="row mb-3">
                    <div class="col d-flex justify-content-center">
                        <h2>Whatsapp <b>Mensagens</b></h2>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session()->has('success'))
                    <div class="alert alert-success">
                        <ul>
                            <li>{{ session('success') }}</li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <div class="row d-flex justify-content-center">
            <div class="col-md-3 p-2 rounded" style="background-color: darkblue; color: #fff">
                <center><h4>Varíaveis</h4></center>
                <span>{id}: Código da compra</span> <br>
                <span>{nome}: Nome do cliente</span> <br>
                <span>{valor}: Valor por cota</span> <br>
                <span>{total}: Total da compra</span> <br>
                <span>{cotas}: Cotas da compra</span> <br>
                <span>{sorteio}: Título do sorteio</span> <br>
                <span>{link}: Link de pagamento</span> <br>
            </div>
        </div>

        <form action="{{ route('wpp.salvar') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-12">
                    <nav>
                        <ul class="nav nav-tabs" id="myTab" role="tablist" style="font-size: 12px;">
                            <li class="nav-item" >
                                <a class="nav-link active" id="botoes-tab" data-toggle="tab" href="#botoes" role="tab"
                                    aria-controls="botoes" aria-selected="true"><strong>Botões Menu Compras</strong></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="automatica-tab" data-toggle="tab" href="#automatica" role="tab"
                                    aria-controls="automatica" aria-selected="true"><strong>Msg Automáticas - Clientes</strong></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="token-tab" data-toggle="tab" href="#token" role="tab"
                                    aria-controls="token" aria-selected="true"><strong>Token API Criar Whats</strong></a>
                            </li>
                        </ul>
                    </nav>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="botoes" role="tabpanel" aria-labelledby="botoes-tab">
                            @foreach ($msgs as $msg)
                                <hr>
                                <input type="hidden" name="id[{{ $msg->id }}]" value="{{ $msg->id }}">
                                <div class="col-md-12 mt-2">
                                    <label>Título</label>
                                    <input type="text" name="titulo[{{ $msg->id }}]" class="form-control"
                                        value="{{ $msg->titulo }}">
                                </div>
                                <div class="col-md-12 mt-2 mb-2">
                                    <label>Mensagem</label>
                                    <textarea name="msg[{{ $msg->id }}]" rows="10" class="form-control" style="resize: none">{{ $msg->clearBreak() }}</textarea>
                                </div>
                            @endforeach
                        </div>

                        <div class="tab-pane fade" id="automatica" role="tabpanel" aria-labelledby="automatica-tab">
                            <div class="row">
                                @foreach ($autoMessages as $auto)
                                    <input type="hidden" name="idAuto[{{ $auto->id }}]" value="{{ $auto->id }}">
                                    <div class="col-md-6 mt-2">
                                        <label>Disparo:</label> {{ $auto->descricao }}<br>
                                        <label>Mensagem</label>
                                        <textarea name="msgAuto[{{ $auto->id }}]" rows="10" class="form-control" style="resize: none">{{ $auto->msg }}</textarea>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="tab-pane fade" id="token" role="tabpanel" aria-labelledby="token-tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Token Criar Whats</label>
                                    <input type="text" name="token_api_wpp" class="form-control" value="{{ $config->token_api_wpp }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <button type="submit" class="btn btn-sm btn-success mt-2 mb-4 float-right">Salvar</button>
        </form>
    @endsection
