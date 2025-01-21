@extends('layouts.app')

<link rel="manifest" href="/manifest.json">
<script type="text/javascript" src="sw.js"></script>
<style>
    body {
        background: #000 !important;
    }
</style>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"
    integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script>
    $(function(e) {
        // if (isIOS()) {
        //     $('#app-main').attr('style', 'margin-top: 100px !important');
        // }
    })

    function isIOS() {
        var ua = navigator.userAgent.toLowerCase();

        //Lista de dispositivos que acessar
        var iosArray = ['iphone', 'ipod'];

        var isApple = false;

        if (ua.includes('iphone') || ua.includes('ipod')) {
            isApple = true
        }

        return isApple;
    }

    function duvidas() {
        window.open('https://api.whatsapp.com/send?phone={{ $user->telephone }}', '_blank');
    }

    function verRifa(route) {
        window.location.href = route
    }
</script>


<style>
    

    @media only screen and (-webkit-min-device-pixel-ratio: 1) {

        ::i-block-chrome,
        .app-main {
            margin-top: 100px !important;
        }
    }

    .app-main {
        border-top-right-radius: 20px;
        border-top-left-radius: 20px;
        max-width: 600px;
        margin-top: 40px;
        margin-bottom: 50px;
        border-bottom-right-radius: 20px;
        border-bottom-left-radius: 20px;
    }

    .app-main a {
        text-decoration: none;
    }

    .app-main a:hover {
        text-decoration: none;
    }

    .app-title {
        display: flex;
        align-items: self-end;
        padding-bottom: 10px;
    }

    .app-title h1 {
        color: rgba(0, 0, 0, .9);
        padding-right: 5px;
        font-weight: 600;
        font-size: 1.3em;
        margin: 0;
        padding-top: 10px;
    }

    .app-title .app-title-desc {
        color: rgba(0, 0, 0, .5);
        padding-top: 6px;
        font-size: .9em;
    }


    /* *************************************************************** */
    /* Card Rifa em Destaque */
    /* *************************************************************** */
    .rifas {
        background: #e4e4e4;
        border-top-right-radius: 20px;
        border-top-left-radius: 20px;
        position: absolute;
        border-bottom-right-radius: 20px;
        border-bottom-left-radius: 20px;
        min-height: 100vh;
    }

    .rifa-dark {
        background-color: #383838;
    }

    .card-rifa-destaque .img-rifa-destaque img {
        width: 100%;
        height: 290px;
        border-top-right-radius: 20px;
        border-top-left-radius: 20px;
    }

    .card-rifa-destaque {
        border-top-right-radius: 20px;
        border-top-left-radius: 20px;
        padding-bottom: 10px;
        background: #fff;
        margin-bottom: 10px;
        border-bottom-right-radius: 20px;
        border-bottom-left-radius: 20px;
    }

    .title-rifa-destaque {
        padding-top: 5px;
        padding-left: 10px;
    }

    .title-rifa-destaque h1 {
        color: #202020;
        -webkit-line-clamp: 2 !important;
        margin-bottom: 1px;
        font-weight: 500;
        font-size: 1em;
    }

    .title-rifa-destaque p {
        color: rgba(0, 0, 0, .7);
        font-size: .75em;
        max-width: 96%;
        margin: 0;
    }

    /* *************************************************************** */


    /* *************************************************************** */
    /* Card Rifa Normal */
    /* *************************************************************** */
    .card-rifa img {
        width: 100px;
        height: 100px;
        border-radius: 10px;
    }

    .card-rifa {
        background: #fff;
        padding: 5px;
        margin-bottom: 10px;
        border-radius: 10px;
        display: flex
    }

    .title-rifa {
        margin-left: 15px;
        width: 100%;
    }

    .blink {
        margin-top: 5px;
        animation: animate 1.5s linear infinite;
    }



    @keyframes animate {
        0% {
            opacity: 0;
        }

        50% {
            opacity: 0.7;
        }

        100% {
            opacity: 0;
        }
    }
</style>


@section('content')
    <style>
        .duvida {
            background-color: #ffffff5e;
            border-radius: 10px;
            height: 60px;
            align-items: center;
            justify-content: center;
            margin-top: 7px;
            cursor: pointer;
        }

        .icone-duvidas {
            width: 50px;
            justify-content: center;
            align-items: center;
            background-color: #b9b9b9;
            height: 35px;
            border-radius: 10px;
            text-align: center;
            font-size: 20px;
        }

        .text-duvidas {
            display: flex !important;
            flex-direction: column;
            justify-content: center
        }

        .f-15 {
            font-size: 15px;
        }

        .f-12 {
            font-size: 12px;
        }

        .data-sorteio {
            /* float: right; */
            padding-right: 10px;
            font-weight: thin;
            text-align: center;
            /* margin-top: 10px; */
            color: #000;
        }

        .rifas.dark {
            background: #383838;
        }

        .app-title.dark h1 {
            color: #fff;
        }

        .app-title-desc.dark {
            color: #fff;
        }

        .card-rifa-destaque.dark {
            background: #222222;
        }

        .title-rifa-destaque.dark h1 {
            color: #fff;
        }

        .title-rifa-destaque.dark p {
            color: #fff;
        }

        .card-rifa.dark {
            background: #222222;
        }

        .text-duvidas.dark h6 {
            color: #fff;
        }

        .text-duvidas.dark p {
            color: #fff !important;
        }

        .data-sorteio.dark {
            color: #fff !important;
        }

        .app-title.dark {
            color: #fff;
        }
    </style>

    <div class="container app-main" id="app-main">

        <div class="row justify-content-center">
            <div class="col-md-6 col-12 rifas {{ $config->tema }}">
                <div class="app-title {{ $config->tema }}">
                    <h1>⚡ Prêmios</h1>
                    <div class="app-title-desc {{ $config->tema }}">Escolha sua sorte</div>
                </div>

                {{-- Rifa em destaque --}}
                @foreach ($products->where('favoritar', '=', 1) as $product)
                    <a href="{{ route('product', ['slug' => $product->slug]) }}">
                        <div class="card-rifa-destaque {{ $config->tema }}">
                            <div class="img-rifa-destaque">
                                <img src="/products/{{ $product->imagem()->name }}" alt="" srcset="">
                            </div>
                            <div class="title-rifa-destaque {{ $config->tema }}">
                                <h1>{{ $product->name }}</h1>
                                <p>{{ $product->subname }}</p>
                                <div style="width: 100%;">
                                    {!! $product->status() !!}
                                    @if ($product->draw_date)
                                        <br>
                                        <span class="data-sorteio {{ $config->tema }}" style="font-size: 12px;">
                                            Data do sorteio {{ date('d/m/Y', strtotime($product->draw_date)) }}
                                            {{-- {!! $product->dataSorteio() !!} --}}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach

                {{-- Outras Rifas --}}
                @foreach ($products->where('favoritar', '=', 0) as $product)
                    <a href="{{ route('product', ['slug' => $product->slug]) }}">
                        <div class="card-rifa {{ $config->tema }}">
                            <div class="img-rifa">
                                <img src="/products/{{ $product->imagem()->name }}" alt="" srcset="">
                            </div>
                            <div class="title-rifa title-rifa-destaque {{ $config->tema }}">


                                <h1>{{ $product->name }}</h1>
                                <p>{{ $product->subname }}</p>

                                <div style="width: 100%;">
                                    {!! $product->status() !!}
                                    @if ($product->draw_date)
                                        <br>
                                        <span class="data-sorteio {{ $config->tema }}" style="font-size: 12px;">
                                            Data do sorteio {{ date('d/m/Y', strtotime($product->draw_date)) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach

                {{-- Fale Conosco --}}
                <div onclick="duvidas()" class="container d-flex duvida" style="">
                    <div class="row">
                        <div class="d-flex icone-duvidas">🤷</div>
                        <div class="col text-duvidas {{ $config->tema }}">
                            <h6 class="mb-0 font-md f-15">Dúvidas?</h6>
                            <p class="mb-0  font-sm f-12 text-muted">Fale conosco</p>
                        </div>
                    </div>
                </div>

                {{-- Ganhadores --}}
                @if ($ganhadores->count() > 0)
                    <div class="app-title {{ $config->tema }}">
                        <h1>🎉 Ganhadores</h1>
                        <div class="app-title-desc {{ $config->tema }}">sortudos</div>
                    </div>

                    <style>
                        .ganhador {
                            display: flex !important;
                            margin-bottom: 10px;
                            background: #fff;
                            padding: 5px;
                            border-radius: 10px;
                            cursor: pointer;
                        }

                        .ganhador-foto img {
                            width: 52px;
                            height: 52px;
                            border: 2px solid #63ac49;
                            margin-top: 10px;
                        }

                        .ganhador-desc {
                            margin-left: 5px;
                            width: 80%;
                        }

                        .ganhador-desc h3 {
                            font-size: 1.1em;
                        }

                        .ganhador p {
                            font-size: .85em;
                            margin-bottom: 0;
                            opacity: .85;
                        }

                        .ganhador-rifa {
                            float: right;
                        }

                        .ganhador-rifa img {
                            height: 40px;
                            width: 40px;
                            border-radius: 50rem;
                            margin-top: 5px;
                        }

                        .ganhadores a {
                            text-decoration: none !important;
                        }

                        .ganhador.dark {
                            background: #222222;
                        }

                        .ganhador-desc.dark {
                            color: #fff !important;
                        }
                    </style>

                    <div class="ganhadores">

                        {{-- Ganhador manual (editar rifa) --}}
                        @foreach ($winners as $winner)
                            <div class="ganhador {{ $config->tema }}"
                                onclick="verRifa('{{ route('product', ['slug' => $winner->slug]) }}')">
                                <div class="ganhador-foto">
                                    <img src="images/sem-foto.jpg" class="" alt="{{ $winner->name }}"
                                        style="min-height: 50px;max-height: 20px;border-radius:10px;">
                                </div>
                                <div class="ganhador-desc {{ $config->tema }}">
                                    <h3>{{ $winner->winner }}</h3>
                                    <p>
                                        <strong>Sorteio: </strong>
                                        {{ date('d/m/Y', strtotime($winner->draw_date)) }}
                                    </p>
                                </div>
                                <div class="ganhador-rifa">
                                    <img src="/products/{{ $winner->imagem()->name }}">
                                </div>
                            </div>
                        @endforeach

                        @foreach ($ganhadores as $ganhador)
                            <div class="ganhador {{ $config->tema }}"
                                onclick="verRifa('{{ route('product', ['slug' => $ganhador->rifa()->slug]) }}')">
                                <div class="ganhador-foto">
                                    @if ($ganhador->foto)
                                        <img src="{{ asset($ganhador->foto) }}" class="" alt=""
                                            style="min-height: 50px;max-height: 20px;border-radius:10px;">
                                    @else
                                        <img src="images/sem-foto.jpg" class="" alt=""
                                            style="min-height: 50px;max-height: 20px;border-radius:10px;">
                                    @endif

                                </div>
                                <div class="ganhador-desc {{ $config->tema }}">
                                    <h3>{{ $ganhador->ganhador }}</h3>
                                    <p>
                                        Ganhou <strong>{{ $ganhador->descricao }}</strong> cota <span
                                            class="badge bg-success p-1"
                                            style="border-radius: 5px;">{{ $ganhador->cota }}</span> <br>
                                        <strong>Sorteio: </strong>
                                        {{ date('d/m/Y', strtotime($ganhador->rifa()->draw_date)) }}
                                    </p>
                                </div>
                                <div class="ganhador-rifa">
                                    <img src="/products/{{ $ganhador->rifa()->imagem()->name }}">
                                </div>
                            </div>
                        @endforeach

                    </div>
                @endif

                {{-- Perguntas ferquentes --}}
                @if (!env('HIDE_FAQ'))
                    <div class="perguntas-frequentes pb-2">
                        <div class="app-title {{ $config->tema }}">
                            <h1>🤷 Perguntas frequentes</h1>
                        </div>
                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-sm btn-block text-left collapsed" type="button"
                                            data-toggle="collapse" data-target="#collapseOne" aria-expanded="false"
                                            aria-controls="collapseOne">
                                            Acessando suas compras
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        Existem <strong>duas</strong> formas de você conseguir acessar suas compras, a
                                        primeira é logando no site, clicando no carrinho de compras no menu superior e a
                                        segunda é visitando o sorteio e clicando em "Ver meus números".
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion mt-2" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h2 class="mb-0">
                                        <button class="btn btn-sm btn-block text-left collapsed" type="button"
                                            data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                            aria-controls="collapseTwo">
                                            Como envio o comprovante ?
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        Caso você tenha feito o pagamento via PIX QR Code ou copiando o código, não é
                                        necessário enviar o comprovante, aguardando até 5 minutos após o pagamento, o
                                        sistema irá dar baixa automaticamente, para mais dúvidas entre em contato conosco
                                        pelo whatsapp.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
        <br>
        @include('layouts.footer')
    </div>
    
    <br>
@endsection
