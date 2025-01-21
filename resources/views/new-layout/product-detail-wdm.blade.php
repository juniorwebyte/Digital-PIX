@extends('layouts.app')
<style>
    body {
        background-color: #fff !important;
    }

    ul.nav.nav-tabs {
        /*background-color: #333;
        border-radius: 20px;*/
    }

    a.nav-link.active.show {
        background-color: #9c2526;
    }

    .nav-tabs .nav-item.show .nav-link,
    .nav-tabs .nav-link.active {
        color: #495057;
        background-color: #222222 !important;
        border-radius: 10px;
        border-color: #dee2e6 #dee2e6 #fff;
    }

    .nav-tabs {
        border-bottom: none !important;
    }

    .nav-tabs .nav-link {
        margin-bottom: -1px;
        border-radius: 10px !important;
        border: 1px solid transparent;
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;
    }

    .nav-tabs .nav-item.show .nav-link,
    .nav-tabs .nav-link.active {
        color: #495057;
        background-color: #132439 !important;
        border-radius: 10px;
        border-color: #dee2e6 #dee2e6 #fff;
    }

    /* width */
    #teste::-webkit-scrollbar {
        width: 10px;
    }

    /* Track */
    #teste::-webkit-scrollbar-track {
        box-shadow: inset 0 0 5px grey;
        border-radius: 10px;
    }

    /* Handle */
    #teste::-webkit-scrollbar-thumb {
        background: #28a745 !important;
        border-radius: 10px;
    }

    /* Handle on hover */
    #teste::-webkit-scrollbar-thumb:hover {
        background: #28a745 !important;
    }

    .list-group-item {
        background-color: #000 !important;
        border: 1px solid #333 !important;
        color: #fff;
    }

    .btn-auto {
        background-color: #E5E5E5 !important;
        border-radius: 10px !important;
        border-color: #E5E5E5 !important;
        font-size: 22px;
        min-height: 100px;
        justify-content: center !important;
        align-items: center !important;
        text-align: center;
    }

    .btn-popular {
        background-color: #fff !important;
        border-color: green !important;
    }

    .popular {
        background-color: green;
    }

    .text-popular {
        margin-top: -21px;
        right: 10px;
        position: absolute;
        margin-top: -55px;
        font-size: 12px !important;
        margin-right: 80px;
    }

    .item-ranking {
        width: 45% !important;
        color: #000;
        background-color: #fff;
        border-radius: 0px;
        padding: 10px;
        border: 1px solid;
        margin-top: 10px !important;
        margin-left: 5px;
    }

    .finished a {
        background-color: #9fa1a3 !important;
        color: #fff !important;
    }

    @media (max-width: 768px) {
        .text-popular {
            margin-right: 35px;
        }
    }

    .number-selected:hover {
        text-decoration: none;
    }

    .number{
        width: 15% !important;
        margin-top: 5px;
        margin-left: 5px;
        text-decoration: none;
        padding: 8px !important;
        color: #fff !important;
        font-weight: 100 !important;
        font-family: Montserrat,sans-serif !important;
    }

    .selected{
        background: red !important;
    }

    .scrollmenu a:hover{
        text-decoration: none !important;
    }

    .number-selected {
        width: 20%;
        text-decoration: none;
        color: #000;
        background-color: #585858;
        vertical-align: middle;
        border-radius: 6px;
        padding: 10px;
        text-align: center;
        justify-content: center;
        font-weight: bold;
        background-origin: border-box;
        -webkit-mask: radial-gradient(circle 10px at right, #000 95%, #000) right, radial-gradient(circle 10px at left, #000 95%, #000) left;
        -webkit-mask-size: 51% 100%;
        -webkit-mask-repeat: no-repeat;
        display: inline-flex;
        margin-left: 5px;
        margin-top: 5px;
    }
</style>
@if (isset($product))
    @section('title', $product[0]->name)
    @section('description', '')
    @section('ogTitle', $product[0]->name)
    @section('ogUrl', url(''))
    @section('ogImage', url('/products/' . $product[0]->image))
    @section('sidebar')

    @section('ogContent')
        {{-- <meta property="og:site_name" content="Nome do site"> --}}
        <meta property="og:title" content="{{ $product[0]->name }}">
        <meta property="og:description" content="{{ $productDescription }}">
        <meta property="og:image" itemprop="image" content="{{ url('/products/' . $product[0]->image) }}">
        <meta property="og:type" content="website">
    @endsection
@stop

<style>
    @media (max-width: 768px) {
        .app-main {
            margin-top: 50px;
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
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content" style="border: none;">
                        <div class="modal-header" style="background-color: #020f1e;color: #fff;">
                            <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-info-circle"></i> Aviso</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                style="color: #fff;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="background-color: #020f1e;color: #fff;">
                            <div style="text-align: center;">{{ $error }}</div>
                        </div>
                        <div class="modal-footer" style="background-color: #020f1e;color: #fff;">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $('#exampleModal').modal({
                    show: true
                });
            </script>
        @endforeach
    @endif

    <div class="container" style="margin-top: 0px;">
        <div class="row justify-content-center">
            <div class="col-md-6"
                style="background: #e4e4e4; margin-top: 40px;border-top-right-radius: 20px; border-top-left-radius: 20px;">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner" style="margin-top: -20px;">
                        @foreach ($productModel->fotos() as $key => $foto)
                            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}" style="margin-top: 30px;"
                                id="slide-foto-{{ $foto->id }}">
                                <img src="/products/{{ $foto->name }}"
                                    style="border-top-right-radius: 20px;border-top-left-radius: 20px;"
                                    class="d-block w-100" alt="...">
                            </div>
                        @endforeach
                    </div>

                    <div class="title-rifa-destaque"
                        style="background: #fff;border-bottom-right-radius: 20px;border-bottom-left-radius: 20px; padding-bottom: 10px;">
                        <h1>{{ $productModel->name }}</h1>
                        <p>Sorteio será realizado pela Federal</p>
                        {!! $productModel->status() !!}
                    </div>
                </div>


                <div class="container mt-2">
                    <div class="text-center">
                        <span>POR APENAS</span>
                        <span class="badge p-2" style="font-size: 14px; background: #000; color: #d1d1d1">R$
                            {{ $product[0]->price }}</span>
                    </div>
                </div>

                @if (env('REQUIRED_DESCRIPTION'))
                    <div class="card mt-3"
                        style="border: none;border-radius: 10px;background-color: #f1f1f1;;max-height: 250px;padding:10px;margin-bottom: 0px; overflow: scroll">
                        <p>
                            {!! $productDescription !!}
                        </p>
                    </div>
                @endif

                <div class="mt-2 d-flex" style="justify-content: space-between;">
                    <div class="item d-flex align-items-center font-xs">
                        <div class="ms-2 me-1" style="font-size: .9em">Sorteio</div>
                        <div class="tag btn btn-sm bg-white bg-opacity-50 font-xss box-shadow-08"
                            style="font-weight: 600">{{ date('d/m/Y', strtotime($productModel->draw_prediction)) }} ás
                            {{ date('H:i', strtotime($productModel->draw_prediction)) }}</div>
                    </div>

                    <div>
                        <!-- Facebook -->
                        <a class="btn btn-primary" style="background-color: #2760AE;border: none;font-size: 20px;"
                            href="https://www.facebook.com/sharer/sharer.php?u={{ Request::url() }}" target="_blank"
                            rel="noreferrer noopener" role="button"><i class="bi bi-facebook"></i></a>
                        <!-- Telegram -->
                        <a class="btn btn-primary" style="background-color: #2F9DDF;border: none;"
                            href="https://t.me/+556984465865" target="_blank" rel="noreferrer noopener"
                            role="button"><i class="bi bi-telegram" style="font-size: 20px;"></i></a>
                        <!-- Whatsapp -->
                        <a class="btn btn-primary" style="background-color: #25d366;border: none;"
                            href="https://api.whatsapp.com/send?text={{ Request::url() }}" target="_blank"
                            rel="noreferrer noopener" role="button"><i class="bi bi-whatsapp"
                                style="font-size: 20px;"></i></a>
                        <!-- Twitter -->
                        <a class="btn btn-primary" style="background-color: #34B3F7;border: none;"
                            href="https://twitter.com/intent/tweet?text=Vc%20pode%20ser%20o%20Próximo%20Ganhador%20{{ Request::url() }}"
                            target="_blank" rel="noreferrer noopener" role="button"><i class="bi bi-twitter"
                                style="font-size: 20px;"></i></a>
                    </div>
                </div>

                @if ($product[0]->status == 'Finalizado')
                    <div class="card mt-3"
                        style="border: none;border-radius: 10px;background-color: #f1f1f1;;height:auto;padding:10px;margin-bottom: 100px;">
                        <h2 style="text-align: center">
                            Rifa Finalizada!
                        </h2>
                        @if (env('APP_URL') == 'rifasonline.link')
                            <h4>
                                Aguardando sorteio pela loteria federal
                            </h4>
                        @endif
                        <h1 class="mt-3" id="ganhadores">
                            🎉 Ganhadores
                        </h1>
                        @foreach ($productModel->premios()->where('descricao', '!=', '') as $premio)
                            <div class="row mt-2 ">
                                <div class="col-md-4">
                                    <label><strong>Prêmio {{ $premio->ordem }}:
                                        </strong>{{ $premio->descricao }}</label>
                                </div>
                                <div class="col-md-4">
                                    <label><strong>Ganhador: </strong>{{ $premio->ganhador }}</label>
                                </div>
                                <div class="col-md-4">
                                    <label><strong>Cota: </strong>{{ $premio->cota }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- Ranking de compradores (WDM) --}}
                    @if (count($ranking) > 0)
                        <div class="card" style="border: none;border-radius: 10px;background-color: transparent;">
                            <div class="card-body"
                                style="background-color: #f1f1f1;border: none;border-radius: 10px;margin-top: 10px;">
                                <div class="" style="">
                                    <?php $resultNumber = $totalPago; ?>
                                </div>
                                <div class="" style="margin-bottom: 10px;">
                                    <h5 style="color: #000; font-weight: bold;">RANKING DE COMPRADORES</h5>
                                    <span style="color: #000;">Quem compra mais ganha.</span><br>
                                </div>


                                <div class="row" style="display: flex;justify-content:center;position:relative">
                                    @foreach ($ranking as $key => $rk)
                                        <div class="btn-auto item-ranking" onclick="addQtd('5')">
                                            {{ $key + 1 }}º {{ $key === 0 ? '🥇' : '🥈' }}<br>
                                            <span
                                                style="font-size: 20px;font-weight: bold;">{{ $rk->name }}</span>
                                            <br>
                                            <span style="font-size: 12px;">Qtd. de Bilhetes
                                                {{ $rk->totalReservas }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Promoções --}}
                    @if ($productModel->promocoes()->where('qtdNumeros', '>', 0)->count() > 0)
                        <div class="card" style="border: none;border-radius: 10px;background-color: transparent;">
                            <div class="card-body"
                                style="background-color: #f1f1f1;border: none;border-radius: 10px;margin-top: 20px;">
                                <div class="" style="margin-bottom: 10px;">
                                    <h1 class="mt-1">
                                        📣 Promoção
                                        <small class="text-muted" style="font-size: 15px;">Compre mais
                                            barato!</small>
                                    </h1>
                                </div>
                                <div class="row">
                                    @foreach ($productModel->promocoes()->where('qtdNumeros', '>', 0) as $promo)
                                        <div class="col-6" style="margin-bottom: 8px;" data-toggle="modal"
                                            data-target="#staticBackdrop"
                                            onclick="addQtd('{{ $promo->qtdNumeros }}', '{{ $promo->valorFormatted() }}')">
                                            <div class="bg-success"
                                                style="color: #fff;text-align: center;border-radius:6px;"><strong>
                                                    {{ $promo->qtdNumeros }} POR - R$:
                                                    {{ $promo->valorFormatted() }}</strong>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Ver meus premios e Parcial --}}
                    <div class="col-auto mb-3">
                        <div class="row mt-2">
                            <div
                                class="{{ env('APP_URL') == 'rifasonline.link' ? 'col-md-12 col-12' : 'col-md-6 col-6' }}">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    onclick="openModal()" class="btn btn-secondary btn-sm bg-secondary"
                                    style="width: 100%; {{ env('APP_URL') == 'rifasonline.link' ? 'background-color: red !important' : '' }}">
                                    Ver meus números
                                </button>
                            </div>
                            <div
                                class="{{ env('APP_URL') == 'rifasonline.link' ? 'col-md-12 col-12 mt-2' : 'col-md-6 col-6' }}">


                                @if (env('APP_URL') != 'rifasonline.link')
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#modal-premios"
                                        class="btn btn-secondary btn-sm bg-secondary" style="width: 100%;">
                                        Prêmios
                                    </button>
                                @endif
                            </div>
                        </div>

                        @if ($productModel->parcial)
                            <div class="row mt-4 justify-content-center">
                                <div class="col-md-12">
                                    <div class="progress-sell">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                role="progressbar" style="width: {{ $productModel->porcentagem() }}%"
                                                aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                                {{ $productModel->porcentagem() }}%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>


                    @if ($type_raffles == 'automatico')
                        {{-- Compra automatica --}}
                        <div class="card"
                            style="border: none;border-radius: 10px;background-color: transparent;margin-bottom: 50px!important;">
                            <div class="card-body"
                                style="background-color: #f1f1f1;border: none;border-radius: 10px;margin-top: 20px;">
                                <div class="" style="">
                                    <?php $resultNumber = $totalPago; ?>
                                </div>
                                <div class="" style="margin-bottom: 10px;">
                                    <h5 style="color: #000; font-weight: bold;">COMPRA AUTOMÁTICA</h5>
                                    <span style="color: #000;">O site escolhe números aleatórios para você.</span><br>
                                </div>

                                <div class="" style="display: flex;justify-content: center;position:relative">
                                    <div class="btn-auto" onclick="addQtd('5')"
                                        style="color: #000;
                                background-color: #fff;
                                border-radius: 0px;
                                padding: 10px;
                                margin: 2px;
                                border: 1px solid;
                                width: 100%;
                                min-width: 50px;
                                max-width: 300px;">
                                        + 5<br>
                                        <span style="font-size: 14px;font-weight: bold;">SELECIONAR</span>
                                    </div>
                                    <div class="btn-auto" onclick="addQtd('10')"
                                        style="color: #000;
                                background-color: #fff;
                                border-radius: 0px;
                                padding: 10px;
                                margin: 2px;
                                border: 1px solid;
                                width: 100%;
                                min-width: 50px;
                                max-width: 300px;">
                                        + 10<br>
                                        <span style="font-size: 14px;font-weight: bold;">SELECIONAR</span>

                                    </div>
                                </div>
                                <div class="" style="display: flex;justify-content: center;">
                                    <div class="btn-auto" onclick="addQtd('30')"
                                        style="color: #000;
                                background-color: #fff;
                                border-radius: 0px;
                                padding: 10px;margin: 2px;
                                border: 1px solid;
                                width: 100%;
                                min-width: 50px;
                                max-width: 300px;">
                                        + 30<br>
                                        <span style="font-size: 14px;font-weight: bold;">SELECIONAR</span>
                                    </div>
                                    <div class="btn-auto btn-popular" onclick="addQtd('50')"
                                        style="color: #000;
                                background-color: #fff;
                                border-radius: 0px;
                                padding: 10px;
                                margin: 2px;
                                border: 1px solid;
                                width: 100%;
                                min-width: 50px;
                                max-width: 300px;">
                                        + 50<br>
                                        <span style="font-size: 14px;font-weight: bold;">SELECIONAR</span>
                                        <span class="badge bg-success text-popular">MAIS POPULAR</span>
                                    </div>
                                </div>
                                <div class="" style="display: flex;justify-content: center;">
                                    <div class="btn-auto" onclick="addQtd('100')"
                                        style="color: #000;
                                background-color: #fff;
                                border-radius: 0px;
                                padding: 10px;
                                margin: 2px;
                                border: 1px solid;
                                width: 100%;
                                min-width: 50px;
                                max-width: 300px;">
                                        + 100<br>
                                        <span style="font-size: 14px;font-weight: bold;">SELECIONAR</span>
                                    </div>
                                    <div class="btn-auto" onclick="addQtd('500')"
                                        style="color: #000;
                                    background-color: #fff;
                                    border-radius: 0px;padding: 10px;
                                    margin: 2px;
                                    border: 1px solid;
                                    width: 100%;
                                    min-width: 50px;
                                    max-width: 300px;">
                                        + 500<br>
                                        <span style="font-size: 14px;font-weight: bold;">SELECIONAR</span>
                                    </div>
                                </div>
                                {{-- <div class="" style="text-align: center;margin-top: 20px;">
                                    <span id="numberSelectedTotalHome" style="color: #000;"></span>
                                </div> --}}
                                <div class="" style="margin-top: 20px;margin-bottom: 20px;text-align: center;">
                                    <div class="amount">
                                        <div class="form-group"
                                            style="margin-bottom: 0;display: flex;justify-content: center;flex-direction: inherit;align-items: center;">
                                            <button class="btn-amount-qtd" onclick="addQtd('-')"
                                                style="color: #000;margin-right: 5px;">-</button>
                                            <input type="number"
                                                style="text-align: center;background-color: #E5E5E5;color: #000000;font-weight: bold;"
                                                id="numbersA" value="{{ $productModel->minimo }}"
                                                min="{{ $productModel->minimo }}" max="{{ $productModel->maximo }}"
                                                onblur="numerosAleatorio();" onkeyup="numerosAleatorio()"
                                                class="form-control" placeholder="Quantidade de cotas">
                                            <button class="btn-amount-qtd" onclick="addQtd('+')"
                                                style="color: #000;margin-left: 5px;">+</button>
                                        </div>
                                        <button type="button"
                                            class="btn btn-danger reservation btn-amount blob bg-success"
                                            style="color: #fff;border: none;width: 100%;margin-top: 5px;font-weight: bold;"
                                            onclick="validarQtd()"><i class="far fa-check-circle"></i>&nbsp;Participar do sorteio<span id="numberSelectedTotalHome" style="color: #fff;float:right"></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif ($type_raffles == 'manual' || $type_raffles == 'mesclado')
                        <div class="container" id="rafflesSection" style="margin-top: 10px;text-align: center">
                            <h4 style=" color: #000;font-weight: bold;"><i class="bi bi-award"></i> Escolha você mesmo
                                clicando no(s)
                                número(s) desejado(s)!!!</h4>
                        </div>

                        <div class="col-auto mb-3">
                            <div role="group" aria-label="Cotas" class="btn-group d-flex">
                                <button type="button" class="btn btn-secondary filter-button active"
                                    data-filter="disponivel" style="background-color: #9fa1a3">
                                    <small style="font-size: 12px;">COTAS<br>
                                        DISPONÍVEIS (<b>{{ $totalDispo }}</b>)</small>
                                </button>
                                <button type="button" class="btn btn-info filter-button"
                                    style="background-color: rgb(241,191,26); border-color: rgb(241,191,26)"
                                    data-filter="reservado">
                                    <small style="font-size: 12px;color:#fff;">COTAS<br>
                                        RESERVADAS (<b>{{ $totalReser }}</b>)</small>
                                </button>
                                <button type="button" class="btn btn-secondary filter-button" data-filter="pago">
                                    <small style="font-size: 12px;">COTAS<br>
                                        PAGAS (<b>{{ $totalPago }}</b>)</small>
                                </button>
                            </div>
                        </div>

                        <div class="container text-center">
                            <div class="raffles {{ $product[0]->status == 'Finalizado' ? 'finished' : '' }}"
                                id="raffles" style="margin-bottom: 150px !important;">
                                <div id="message-raffles" class="blob"
                                    style="background-color: transparent;color: #000;font-weight: bold;text-align: center;">
                                </div>
                            </div>
                        </div>



                        <div class="d-flex justify-content-center">
                            <div class="payment" id="payment" style="display: none; width: 500px !important;margin-bottom: 10px;">
                                <div class="row">
                                    <div class="col-md-12"
                                        style="background-color: #fff; color: #000; border-radius: 10px;">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-12 text-center" style="width: 100%">
                                                    <span id="numberSelected" class="scrollmenu"></span>
                                                </div>
                                            </div>
                                            <div class="row" style="text-align: center;background-color: #fff; margin-top: 5px; justify-content-center; margin-bottom: 10px;">
                                                <div class="col-12 d-flex justify-content-center">
                                                    <center style="width: 400px;">
                                                        <button type="button" class="btn btn-danger reservation blob"
                                                        style="border: none;color: #fff;font-weight: bold;width: 100%;background-color: green"
                                                        data-toggle="modal"
                                                        data-target="#staticBackdrop"><i class="far fa-check-circle"></i>&nbsp;Participar do sorteio
                                                        <span style="font-size: 14px; float:right"><span
                                                            id="numberSelectedTotal"></span></span></button>
                                                    </center>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($type_raffles == 'mesclado')
                            <div class="paymentAutomatic" id="paymentAutomatic"
                                style="display: none;width: 80% !important">
                                <div class="row">
                                    <div class="col-md-12" style="background: #000000;padding-top: 10px;">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-8">
                                                    <h3
                                                        style="color: #ff1c1c!important;font-size: 18px;margin: 0px;font-weight: bold;">
                                                        COMPRA AUTOMÁTICA</h3>
                                                </div>
                                                <div class="col-4">
                                                    <b><span id="numberSelectedTotalHome"
                                                            style="color: #fff;font-size: 12px;font-weight: bold;"></span></b>
                                                </div>
                                            </div>
                                            <span style="color: #fff;">O site escolhe números aleatórios para
                                                você.</span><br>
                                        </div>
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-6" style="display: flex;align-items: center;">
                                                    <div class="form-group" style="margin-bottom: 0;display: flex;">
                                                        <button class="btn-amount-qtd" onclick="addQtd('-')"
                                                            style="color: #000;margin-right: 5px;width: 50px;">-</button>
                                                        <input type="number"
                                                            style="text-align: center;background-color: #000000;color: #fff;font-weight: bold;"
                                                            id="numbersA" value="1" min="1"
                                                            onblur="numerosAleatorio(this);" class="form-control"
                                                            placeholder="Quantidade de cotas">
                                                        <button class="btn-amount-qtd" onclick="addQtd('+')"
                                                            style="color: #000;margin-left: 5px;width: 50px;">+</button>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <button type="button"
                                                        class="btn btn-danger reservation btn-amount blob"
                                                        style="border: none;color: #fff;font-weight: bold;width: 100%;background-color: #ff1c1c"
                                                        onclick="validarQtd()">COMPRAR</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                @endif
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 999999999;">
        <div class="modal-dialog">
            <form action="{{ route('bookProductManualy') }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-content" style="border: none;">
                    <div class="modal-header" style="background-color: #939393;color: #fff;">
                        <h5 class="modal-title" id="staticBackdropLabel">FINALIZAR RESERVA</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="color: #fff;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="background: #efefef;color: #939393;">
                        <div class="form-group">
                            @if ($type_raffles == 'manual')
                                <label>Pagamento referente à participação na ação entre amigos
                                    <b>{{ $product[0]->product }}</b> com os números:</label>
                            @else
                                <label>Pagamento referente à participação na ação entre amigos
                                    <b>{{ $product[0]->product }}.</b></label>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="numberSelected" id="numberSelectedModal"
                                        style="overflow-y: auto;width: 190px;"></div>
                                </div>
                            </div>
                            @if ($type_raffles == 'manual')
                                <input type="hidden" class="form-control" name="qtdNumbers" value="">
                            @else
                                <input type="hidden" class="form-control" name="qtdNumbers" id="qtdNumbers">
                            @endif
                            <input type="hidden" class="form-control" name="productName"
                                value="{{ $product[0]->name }}">
                            <input type="hidden" class="form-control" name="productID"
                                value="{{ $product[0]->id }}">
                            <input type="hidden" class="form-control" name="numberSelected"
                                id="numberSelectedInput">
                            @if ($type_raffles == 'manual')
                                <small class="form-text" style="color: green;"><b>Valor a pagar: <small
                                            style="font-size: 15px;"
                                            id="numberSelectedTotalModal"></small></b></small>
                            @else
                                <small class="form-text" style="color: green;"><b>Valor a pagar: <small
                                            style="font-size: 15px;"
                                            id="numberSelectedTotalModal"></small></b></small>
                            @endif
                        </div>
                        <!--<legend>Por favor, preencha os dados abaixo:</legend>-->
                        <div class="form-group">
                            <label>NOME COMPLETO</label>
                            <input type="text" class="form-control"
                                style="background-color: #fff;border: none;color: #333;" name="name"
                                placeholder="Informe seu nome completo" required>
                        </div>
                        <div class="form-group">
                            <label>E-mail (opcional)</label>
                            <input type="email" class="form-control"
                                style="background-color: #fff;border: none;color: #333;" name="email"
                                id="email" placeholder="Informe o seu e-mail" maxlength="50" required>
                        </div>
                        <div class="form-group {{ $productModel->gateway == 'mp' ? 'd-none' : '' }}">
                            <label>CPF (somente números)</label>
                            <input type="number" class="form-control"
                                style="background-color: #fff;border: none;color: #333;" name="cpf"
                                id="cpf" placeholder="Informe o seu CPF" maxlength="50" required>
                        </div>
                        <div class="form-group">
                            <label>CELULAR (Whatsapp)</label>
                            <input type="text" class="form-control numbermask"
                                style="background-color: #fff;border: none;color: #333;" name="telephone"
                                id="telephone1" placeholder="Informe seu telefone com DDD" maxlength="15" required>
                        </div>
                        <input type="hidden" id="promo" name="promo">
                        <!--<small class="form-text text-muted">Reservando seu(s) número(s), você declara que leu e concorda com nossos <a href="{{ url('terms-of-use') }}">Termos de Uso</a>.</small>-->
                    </div>
                    <div class="modal-footer" style="background: #939393;color: #fff;">
                        <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>-->
                        <button type="submit"
                            onClick="this.form.submit(); this.disabled=true; this.value='Sending…'; "
                            class="btn btn-success"
                            style="width: 100%;min-height: 60px;border: none;color: #fff;font-weight: bold;width: 100%;background-color: green">PROSSEGUIR</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        style="z-index: 9999999;">
        <div class="modal-dialog">
            <div class="modal-content" style="border: none;">
                <div class="modal-header" style="background-color: #020f1e;">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: #fff;">CONSULTAR RESERVAS</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                        style="color: #fff;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background-color: #020f1e;">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('consultingReservation') }}" method="POST"
                                style="display: flex;">
                                {{ csrf_field() }}
                                <input type="hidden" name="productID" value="{{ $product[0]->id }}">
                                <input type="text" id="telephone3" name="telephone"
                                    style="background-color: #fff;border: none;color: #000;margin-right:5px;"
                                    aria-describedby="passwordHelpBlock" maxlength="15" placeholder="Celular com DDD"
                                    class="form-control" required>
                                <button type="submit" class="btn btn-danger">Buscar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border: none;">
                <div class="modal-header" style="background-color: #020f1e;">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: #fff;">DÚVIDAS FREQUENTES</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color: #fff;background-color: red!important;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background-color: #020f1e;color: #ffffff;">
                    <b style="text-transform: uppercase;">- É confiável?</b><br>
                    <span style="color: #999999;">R: Sim, sorteio pela milhar da loteria federal.</span><br>
                    <b style="text-transform: uppercase;">- Que dia é o sorteio?</b><br>
                    <span style="color: #999999;">R: Após a venda de todas as cotas, no site você pode acompanhar as
                        vendas!</span><br>
                    <b style="text-transform: uppercase;">- Como participar da nossa rifa?</b><br>
                    <span style="color: #999999;">R: Existe duas formas compra automática e compra manual.</span><br>
                    <b style="text-transform: uppercase;">- Forma de pagamento</b><br>
                    <span style="color: #999999;">R: Somente PIX Copia e Cola ou CNPJ</span><br>
                    <b style="text-transform: uppercase;">- Se eu escolher o veículo</b><br>
                    <span style="color: #999999;">R: Vamos entregar na sua garagem o prêmio.</span>
                </div>
                <div class="modal-footer" style="background-color: #020f1e;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Premios --}}
    <div class="modal fade" id="modal-premios" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" style="z-index: 9999999;">
        <div class="modal-dialog">
            <div class="modal-content" style="border: none;">
                <div class="modal-header" style="background-color: #020f1e;">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: #fff;">PRÊMIOS</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                        style="color: #fff;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="">
                    <div class="col-md-12 text-center">
                        Estes são os prêmios disponíveis no sorteio <strong>{{ $productModel->name }}</strong>
                    </div>
                    <hr>
                    @foreach ($productModel->premios()->where('descricao', '!=', '') as $premio)
                        <div class="row mt-4">
                            <div class="col-md-12 text-center">
                                <label><strong>Prêmio {{ $premio->ordem }}: </strong>{{ $premio->descricao }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="blob green" id="messageIn"
        style="position: fixed;
        bottom: 15px;
        z-index: 99999;
        color: #fff;
        padding: 3px;
        font-weight: bold;
        font-size: 12px;
        width: 180px;
        text-align: center;
        z-index: 99999;border-radius: 20px;left: 10px;">
    </div>
    <script>
        document.getElementById('telephone3').addEventListener('input', function(e) {
            var aux = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
            e.target.value = !aux[2] ? aux[1] : '(' + aux[1] + ') ' + aux[2] + (aux[3] ? '-' + aux[3] : '');
        });

        $(document).ready(function() {
            $(window).on('scroll', function() {
                if ($(this).scrollTop() > 400) {
                    if ('{{ $totalDispo }}' > 0) {
                        $("#paymentAutomatic").fadeIn();
                    }
                } else {
                    $("#paymentAutomatic").fadeOut();
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("body").tooltip({
                selector: '[data-toggle=tooltip]'
            });
        });

        setTimeout(getNumbers, 2000);
        document.getElementById("message-raffles").innerHTML = "CARREGANDO AS COTAS...";

        function getNumbers() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                dataType: 'json',
                url: "{{ route('getRafflesAjax') }}",
                data: {
                    idProductURL: '{{ $product[0]->id }}'
                },
                success: function(data) {

                    //console.log('RAFFLE', data);

                    document.getElementById("raffles").innerHTML = data.join('');

                    document.getElementById("message-raffles").style.display = 'none';


                },
            });


        }
    </script>
    <script>
        function openModal() {
            $('#exampleModal').modal('show');
        }

        function openModal1() {
            $('#exampleModal1').modal('show');
        }
    </script>

    <script>
        function validarQtd() {
            var qtd = parseInt(document.getElementById('numbersA').value);
            var disponivel = parseInt('{{ $totalDispo }}');
            if (qtd > disponivel) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Quantidade indisponível!',
                    footer: 'Disponível: ' + disponivel
                });
            } else {
                $('#staticBackdrop').modal('show')
            }
        }

        function validaMaxMin(operacao) {
            const input = document.getElementById('numbersA');
            var oldValue = input.value
            var max = parseInt(input.max)
            var min = parseInt(input.min)


            if (operacao === '+') {
                var newValue = parseInt(oldValue) + 1;
                if (newValue > max) return false;
            } else if (operacao === '-') {
                var newValue = parseInt(oldValue) - 1;
                if (newValue < min) return false;
            }

            return true;
        }

        function addQtd(e, valor = null) {
            if (!validaMaxMin(e)) {
                return
            }

            const input = document.getElementById('numbersA');

            if (valor != null) {
                input.value = parseInt(e);
                numerosAleatorio(valor)
            } else {
                if (e === '+') {
                    console.log('+++++++++++++');
                    input.value = parseInt(input.value) + 1;

                    numerosAleatorio();

                } else if (e === '-') {
                    if (parseInt(input.value) == 1) {

                    } else {
                        input.value = parseInt(input.value) - 1;
                    }

                    numerosAleatorio();
                } else if (e === '1') {
                    input.value = parseInt(input.value) + 1;

                    numerosAleatorio();
                } else if (e === '5') {
                    input.value = parseInt(input.value) + 5;

                    numerosAleatorio();
                } else if (e === '10') {
                    input.value = parseInt(input.value) + 10;

                    numerosAleatorio();
                } else if (e === '30') {
                    input.value = parseInt(input.value) + 30;

                    numerosAleatorio();
                } else if (e === '15') {
                    input.value = parseInt(input.value) + 15;

                    numerosAleatorio();
                } else if (e === '50') {

                    input.value = parseInt(input.value) + 50;


                    numerosAleatorio();
                } else if (e === '100') {

                    input.value = parseInt(input.value) + 100;


                    numerosAleatorio();
                } else if (e === '150') {


                    input.value = parseInt(input.value) + 150;

                    numerosAleatorio();
                } else if (e === '200') {

                    input.value = 0;
                    input.value = parseInt(input.value) + 200;

                    numerosAleatorio();
                } else if (e === '500') {


                    input.value = parseInt(input.value) + 500;

                    numerosAleatorio();
                }
            }


        }
    </script>
    <script type="text/javascript">
        var qtd = 1;
        document.getElementById('qtdNumbers').value = qtd;

        const value = "{{ $product[0]->price }}";

        console.log("BOA", value);

        total = value.toString().replace(",", ".") * qtd;
        totalFomat = total.toLocaleString('pt-br', {
            style: 'currency',
            currency: 'BRL'
        });

        console.log(totalFomat);

        fromatPrice = value.toLocaleString('pt-br', {
            style: 'currency',
            currency: 'BRL'
        });

        document.getElementById('numberSelectedTotalModal').innerHTML = totalFomat.toString().replace(".", ",");
        if (qtd <= 1) {
            document.getElementById('numberSelectedTotalHome').innerHTML = totalFomat.toString().replace(
                ".", ",");
        } else {
            document.getElementById('numberSelectedTotalHome').innerHTML = totalFomat.toString().replace(
                ".", ",");
        }

        function numerosAleatorio(valor = null) {

            qtd = document.getElementById('numbersA').value;

            document.getElementById('qtdNumbers').value = qtd;

            const value = "{{ $product[0]->price }}";

            total = value.toString().replace(",", ".") * qtd;
            totalFomat = total.toLocaleString('pt-br', {
                style: 'currency',
                currency: 'BRL'
            });

            const productID = '{{ $product[0]->id }}';

            if (valor != null) {
                total = valor.toString().replace(",", ".");
                totalFomat = total.toLocaleString('pt-br', {
                    style: 'currency',
                    currency: 'BRL'
                });
                $('#promo').val(valor)
            } else {
                $('#promo').val(0)
                if (qtd == 5000) {
                    total = value.toString().replace(",", ".") * qtd - (value.toString().replace(",", ".") * qtd * 10 /
                        100);
                    totalFomat = total.toLocaleString('pt-br', {
                        style: 'currency',
                        currency: 'BRL'
                    });
                } else if (qtd == 1000) {
                    total = value.toString().replace(",", ".") * qtd - (value.toString().replace(",", ".") * qtd * 10 /
                        100);
                    totalFomat = total.toLocaleString('pt-br', {
                        style: 'currency',
                        currency: 'BRL'
                    });
                } else if (qtd == 150) {
                    total = value.toString().replace(",", ".") * qtd - (value.toString().replace(",", ".") * qtd * 10 /
                        100);
                    totalFomat = total.toLocaleString('pt-br', {
                        style: 'currency',
                        currency: 'BRL'
                    });
                } else if (qtd == 200) {
                    total = value.toString().replace(",", ".") * qtd - (value.toString().replace(",", ".") * qtd * 10 /
                        100);
                    totalFomat = total.toLocaleString('pt-br', {
                        style: 'currency',
                        currency: 'BRL'
                    });
                } else {
                    total = value.toString().replace(",", ".") * qtd;
                    totalFomat = total.toLocaleString('pt-br', {
                        style: 'currency',
                        currency: 'BRL'
                    });
                }
            }

            console.log(parseFloat(total));

            document.getElementById('numberSelectedTotalModal').innerHTML = totalFomat.toString().replace(".", ",");
            if (qtd <= 1) {
                document.getElementById('numberSelectedTotalHome').innerHTML = totalFomat.toString()
                    .replace(".", ",");
            } else {
                document.getElementById('numberSelectedTotalHome').innerHTML = totalFomat.toString()
                    .replace(".", ",");
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $(".filter-button").click(function() {

                $(".filter-button").removeClass('active');
                $(this).addClass('active');

                var value = $(this).attr('data-filter');

                //console.log(value);

                /*if (value == "all") {
                    $(".filter").not('.filter[filter-item="' + value + '"]').css("display", "flex");
                } else {*/
                $(".filter").not('.filter[filter-item="' + value + '"]').css("display", "none");

                $(".filter").filter('.' + value).css("display", "inline-flex");
                //}
            });
        });
    </script>
    <script>
        const numbersManual = [];
        const valuePrices = "{{ $product[0]->price }}";
        let total;

        function selectRaffles(id) {
            const x = document.getElementById(id);

            console.log(x);

            if (x.classList[3] == "selected") {

                x.classList.remove("selected");

                numbersManual.splice(numbersManual.indexOf(x.id), 1);

                // document.getElementById('numberSelected').innerHTML = numbersManual;
                $('#selected-'+x.id).remove()
                document.getElementById('numberSelectedModal').innerHTML = numbersManual;
                document.getElementById('numberSelectedInput').value = numbersManual;

                total = valuePrices.toString().replace(",", ".") * numbersManual.length;
                totalFomat = total.toLocaleString('pt-br', {
                    style: 'currency',
                    currency: 'BRL'
                });
                document.getElementById('numberSelectedTotal').innerHTML = totalFomat.toString().replace(".", ",");
                document.getElementById('numberSelectedTotalModal').innerHTML = totalFomat.toString().replace(".", ",");

                if (numbersManual.length == 0) {
                    if ('{{ $type_raffles == 'manual' }}') {
                        document.getElementById("payment").style.display = "none";
                        document.getElementById("paymentAutomatic").style.display = "block";

                    } else if ('{{ $type_raffles == 'mesclado' }}') {
                        document.getElementById("payment").style.display = "none";
                        document.getElementById("paymentAutomatic").style.display = "block";

                    } else {

                    }

                    const value = "{{ $product[0]->price }}";

                    total = value.toString().replace(",", ".") * 1;
                    totalFomat = total.toLocaleString('pt-br', {
                        style: 'currency',
                        currency: 'BRL'
                    });

                    document.getElementById('qtdNumbers').value = 1;
                    document.getElementById('numbersA').value = 1;

                    document.getElementById('numberSelectedTotalModal').innerHTML = totalFomat.toString().replace(".", ",");

                    document.getElementById('numberSelectedTotalHome').innerHTML = totalFomat.toString()
                        .replace(".", ",");
                }
            } else {
                if ('{{ $type_raffles == 'mesclado' }}') {
                    document.getElementById('qtdNumbers').value = null;
                    document.getElementById("paymentAutomatic").style.display = "none";

                } else {

                }


                x.classList.add("selected");

                numbersManual.push(x.id);

                // document.getElementById('numberSelected').innerHTML = numbersManual;

                var teste = document.createElement('div');
                var texto = document.createTextNode(x.id);
                teste.classList = 'number-selected';
                teste.id = 'selected-' + x.id
                teste.appendChild(texto)
                document.getElementById('numberSelected').appendChild(teste)

                document.getElementById('numberSelectedModal').innerHTML = numbersManual;
                document.getElementById('numberSelectedInput').value = numbersManual;

                const productID = '{{ $product[0]->id }}';

                if (numbersManual.length == 10 && productID == 12) {
                    total = 120;
                    totalFomat = total.toLocaleString('pt-br', {
                        style: 'currency',
                        currency: 'BRL'
                    });
                } else {
                    total = valuePrices.toString().replace(",", ".") * numbersManual.length;
                    totalFomat = total.toLocaleString('pt-br', {
                        style: 'currency',
                        currency: 'BRL'
                    });
                }

                document.getElementById('numberSelectedTotal').innerHTML = totalFomat.toString().replace(".", ",");
                document.getElementById('numberSelectedTotalModal').innerHTML = totalFomat.toString().replace(".", ",");

                document.getElementById("payment").style.display = "";

            }
        }
    </script>
    <script>
        //aqui vai sempre ser a hora atual
        var startDate = new Date();
        console.log("HORASSSSS", startDate);
        //como exemplo vou definir a data de fim com base na data atual
        var endDate = new Date('{{ $product[0]->draw_prediction }}');
        //endDate.setDate(endDate.getDate() + 60);

        //aqui é a diferenca entre as datas, basicamente é com isso que voce calcula o tempo restante
        var dateDiff;
        var days, hours, minutes, seconds;
        var $day = $('#dias');
        var $hour = $('#horas');
        var $minute = $('#minutos');
        var $second = $('#segundos');
        var $debug = $('#debug');
        var timer;

        function update() {
            var diffMilissegundos = endDate - startDate;
            var diffSegundos = diffMilissegundos / 1000;
            var diffMinutos = diffSegundos / 60;
            var diffHoras = diffMinutos / 60;
            var diffDias = diffHoras / 24;
            var diffMeses = diffDias / 30;

            seconds = Math.floor((diffSegundos % 60));
            minutes = Math.floor((diffMinutos % 60));
            hours = Math.floor((diffHoras % 60));
            days = Math.floor(diffDias % 60);

            $day.text(days);
            $hour.text(hours);
            $minute.text(minutes);
            $second.text(seconds);

            if (days == 0 && hours == 0 && minutes == 0 && seconds == 0) {
                window.location.reload();
            }

            startDate.setSeconds(startDate.getSeconds() + 1);
        }
        update();
        timer = setInterval(update, 1000);
    </script>
    <script language="javascript">
        var tempo = new Number();
        // Tempo em segundos
        tempo = 900;

        function startCountdown() {

            // Se o tempo não for zerado
            if ((tempo - 1) >= 0) {

                // Pega a parte inteira dos minutos
                var min = parseInt(tempo / 60);
                // Calcula os segundos restantes
                var seg = tempo % 60;

                // Formata o número menor que dez, ex: 08, 07, ...
                if (min < 10) {
                    min = "0" + min;
                    min = min.substr(0, 2);
                }
                if (seg <= 9) {
                    seg = "0" + seg;
                }

                // Cria a variável para formatar no estilo hora/cronômetro
                horaImprimivel = min + 'm' + ' ' + seg + 's';
                //JQuery pra setar o valor
                $("#promoMinutes").html(horaImprimivel);

                // Define que a função será executada novamente em 1000ms = 1 segundo
                setTimeout('startCountdown()', 1000);

                // diminui o tempo
                tempo--;

                // Quando o contador chegar a zero faz esta ação
            } else {
                window.open('../controllers/logout.php', '_self');
            }

        }

        // Chama a função ao carregar a tela
        startCountdown();
    </script>
    <script>
        $('.carousel').on('touchstart', function(event) {
            const xClick = event.originalEvent.touches[0].pageX;
            $(this).one('touchmove', function(event) {
                const xMove = event.originalEvent.touches[0].pageX;
                const sensitivityInPx = 5;

                if (Math.floor(xClick - xMove) > sensitivityInPx) {
                    $(this).carousel('next');
                } else if (Math.floor(xClick - xMove) < -sensitivityInPx) {
                    $(this).carousel('prev');
                }
            });
            $(this).on('touchend', function() {
                $(this).off('touchmove');
            });
        });
    </script>
    <script>
        var refInterval = window.setInterval('update()', 1000 * 60 * 1); // 30 seconds

        var update = function() {
            $('#messageIn').fadeIn('fast');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                dataType: 'json',
                url: "{{ route('randomParticipant') }}",
                success: function(data) {

                    document.getElementById('messageIn').innerHTML = data[0] + ' acabou de comprar';
                },
            });


            setTimeout(function() {
                $('#messageIn').fadeOut('fast');
            }, 2000); // <-- time in milliseconds            
        }

        update();

        function changeSlide(el) {
            var id = el.dataset.id;
            document.querySelectorAll('.carousel-item').forEach((el) => el.classList.remove('active'));
            document.getElementById('slide-foto-' + id).classList.add('active');
        }
    </script>
@endif
@stop
