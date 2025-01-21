@extends('layouts.app')

@section('title', 'Page Title')

@section('sidebar')

@stop

@section('content')
<div class="container">
    <div class="title">
        <h3><i class="bi bi-bookmark-check"></i> REGULAMENTO</h3>
    </div>
    <div class="sub-title">Vários participantes já tiveram seu sonho realizado, você pode ser o próximo!</div>

    <div class="row" style="justify-content: center;">
        <div class="card" style="width: 13rem;margin: 2px;border: 0px!important;">
            <span style="text-align: center;text-align: center;
    font-size: 30px;
    border-radius: 80px;margin: 10px;">1</span>
            <div class="card-body" style="text-align: center;">
                <h5 class="card-title">ESCOLHA O SORTEIO</h5>
                <p class="card-text">Acesse o link do sorteio que deseja participar . Verifique na discrição do sorteio o regulamento e qualquer dúvida entre em contato com o administrador .</p>
            </div>
        </div>
        <div class="card" style="width: 13rem;margin: 2px;border: 0px!important;">
            <span style="text-align: center;text-align: center;
    font-size: 30px;
    border-radius: 80px;margin: 10px;">2</span>
            <div class="card-body" style="text-align: center;">
                <h5 class="card-title">SELECIONE SEUS NÚMEROS</h5>
                <p class="card-text">Escolha quantos números da sorte quer para participar. Finalize a sua compra, após confirmamos o seu pagamento, seu número será gerado no site.</p>
            </div>
        </div>
        <div class="card" style="width: 13rem;margin: 2px;border: 0px!important;">
            <span style="text-align: center;text-align: center;
    font-size: 30px;
    border-radius: 80px;margin: 10px;">3</span>
            <div class="card-body" style="text-align: center;">
                <h5 class="card-title">COMO PAGAR</h5>
                <p class="card-text">O pagamento pode ser realizado pelo Pix - Você receberá o QR code e também poderá copiar o código do PIX para pagar no seu aplicativo do banco .</p>
            </div>
        </div>
        <div class="card" style="width: 13rem;margin: 2px;border: 0px!important;">
            <span style="text-align: center;text-align: center;
    font-size: 30px;
    border-radius: 80px;margin: 10px;">4</span>
            <div class="card-body" style="text-align: center;">
                <h5 class="card-title">AGUARDE O SORTEIO</h5>
                <p class="card-text">Aguarde o sorteio.
                    Cruze os dedos
                    Você pode ser o próximo sorteado</p>
            </div>
        </div>
    </div>
</div>
@stop