@extends('layouts.app')

<link rel="manifest" href="/manifest.json">
<script type="text/javascript" src="sw.js"></script>
<style>
    body {
        background: #000 !important;
    }
</style>

<script>
    function duvidas() {
        window.open('https://api.whatsapp.com/send?phone={{ $user->telephone }}', '_blank');
    }

    function verRifa(route) {
        window.location.href = route
    }
</script>

<style>
    @media (max-width: 768px) {
        .app-main {
            margin-top: 50px !important;
        }
    }

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
            float: right;
            padding-right: 10px;
            font-weight: thin;
            text-align: center;
            margin-top: 10px;
            color: #000;
        }
    </style>

    <div class="container app-main">
        <div class="row justify-content-center">
            <div class="col-md-6 col-12 rifas">
                <div class="app-title">
                    <h1>⚡ Prêmios</h1>
                    <div class="app-title-desc">Escolha sua sorte</div>
                </div>

                {{-- Rifa em destaque --}}
                @foreach ($products->where('favoritar', '=', 1) as $product)
                    <a href="{{ route('product', ['slug' => $product->slug]) }}">
                        <div class="card-rifa-destaque">
                            <div class="img-rifa-destaque">
                                <img src="/products/{{ $product->imagem()->name }}" alt="" srcset="">
                            </div>
                            <div class="title-rifa-destaque">
                                @if ($product->draw_date)
                                    <span class="data-sorteio">
                                        Data do sorteio <br>
                                        <span
                                            class="badge bg-success">{{ date('d/m/Y', strtotime($product->draw_date)) }}</span>
                                    </span>
                                @endif

                                <h1>{{ $product->name }}</h1>
                                <p>Sorteio será realizado pela Federal</p>
                                {!! $product->status() !!}
                            </div>
                        </div>
                    </a>
                @endforeach

                {{-- Outras Rifas --}}
                @foreach ($products->where('favoritar', '=', 0) as $product)
                    <a href="{{ route('product', ['slug' => $product->slug]) }}">
                        <div class="card-rifa">
                            <div class="img-rifa">
                                <img src="/products/{{ $product->imagem()->name }}" alt="" srcset="">
                            </div>
                            <div class="title-rifa title-rifa-destaque">
                                @if ($product->draw_date)
                                    <span class="data-sorteio">
                                        Data do sorteio <br>
                                        <span
                                            class="badge bg-success">{{ date('d/m/Y', strtotime($product->draw_date)) }}</span>
                                    </span>
                                @endif

                                <h1>{{ $product->name }}</h1>
                                <p>Sorteio será realizado pela Federal</p>
                                {!! $product->status() !!}
                            </div>
                        </div>
                    </a>
                @endforeach

                {{-- Fale Conosco --}}
                <div onclick="duvidas()" class="container d-flex duvida" style="">
                    <div class="row">
                        <div class="d-flex icone-duvidas">🤷</div>
                        <div class="col" class="text-duvidas">
                            <h6 class="mb-0 font-md f-15">Dúvidas</h6>
                            <p class="mb-0  font-sm f-12 text-muted">Fale conosco</p>
                        </div>
                    </div>
                </div>

                {{-- Ganhadores --}}
                @if ($ganhadores->count() > 0)
                    <div class="app-title">
                        <h1>🎉 Ganhadores</h1>
                        <div class="app-title-desc">sortudos</div>
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
                    </style>

                    <div class="ganhadores">

                        @foreach ($ganhadores as $ganhador)
                            <div class="ganhador"
                                onclick="verRifa('{{ route('product', ['slug' => $ganhador->rifa()->slug]) }}')">
                                <div class="ganhador-foto">
                                    <img src="images/sem-foto.jpg" class="" alt="{{ $product->name }}"
                                        style="min-height: 50px;max-height: 20px;border-radius:10px;">
                                </div>
                                <div class="ganhador-desc">
                                    <h3>{{ $ganhador->ganhador }}</h3>
                                    <p>
                                        Ganhou <strong>{{ $ganhador->descricao }}</strong> cota {{ $ganhador->cota }} <br>
                                        <strong>Sorteio: </strong>
                                        {{ date('d/m/Y', strtotime($ganhador->rifa()->draw_prediction)) }}
                                    </p>
                                </div>
                                <div class="ganhador-rifa">
                                    <img src="/products/{{ $ganhador->rifa()->imagem()->name }}">
                                </div>
                            </div>
                        @endforeach

                    </div>
                @endif
            </div>
        </div>
    </div>

    <br><br>
@endsection
