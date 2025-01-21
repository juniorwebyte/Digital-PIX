<style>
    .disponivel-rm {
        background-color: #A0A1A3;
        color: #fff;
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
    }

    .reservadas-rm {
        background-color: #F0BF1A;
        color: #fff;
    }

    .pagas-rm {
        background-color: #6C757E;
        color: #fff;
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
    }
</style>

<div class="container" id="rafflesSection" style="margin-top: 10px;text-align: center">
    <h6 style=" color: #000;font-weight: bold; font-size: 12px;"><i class="bi bi-award"></i> Escolha você mesmo
        clicando no(s)
        número(s) desejado(s)!!!</h6>
</div>

<input type="number" style="text-align: center;background-color: #E5E5E5;color: #000000;font-weight: bold; display:none"
    id="numbersA" value="{{ $productModel->minimo }}" min="{{ $productModel->minimo }}" max="{{ $productModel->maximo }}"
    onblur="numerosAleatorio();" onkeyup="numerosAleatorio()" class="form-control" placeholder="Quantidade de cotas">

@if (env('APP_URL') == 'rifasonline.link')
    <div class="d-flex justify-content-between font-weight-600 mb-2" style="font-size: 12px;">
        <div class="col-md-4 p-1 text-center disponivel-rm">
            COTAS <br> DISPONÍVEIS ({{ $productModel->qtdNumerosDisponiveis() }})
        </div>
        <div class="col-md-4 p-1 text-center reservadas-rm">
            COTAS <br> RESERVADAS ({{ $productModel->qtdNumerosReservados() }})
        </div>
        <div class="col-md-4 p-1 text-center pagas-rm">
            COTAS <br> PAGAS ({{ $productModel->qtdNumerosPagos() }})
        </div>
    </div>
@else
    <div class="d-flex justify-content-between font-weight-600 mb-2">
        <div class="seletor-item rounded d-flex justify-content-between box-shadow-08 font-xs" style="cursor: pointer;"
            onclick="showNumbers('disponivel')">
            <div class="nome bg-white rounded-start text-dark p-2">
                Livres
            </div>
            <div class="num bg-cota text-white p-2 rounded-end">
                {{ $productModel->qtdNumerosDisponiveis() }}
            </div>
        </div>

        <div class="seletor-item rounded d-flex justify-content-between box-shadow-08 font-xs" style="cursor: pointer;"
            onclick="showNumbers('reservado')">
            <div class="nome bg-white rounded-start text-dark p-2">
                Reserv
            </div>
            <div class="num bg-info text-white p-2 rounded-end">
                {{ $productModel->qtdNumerosReservados() }}
            </div>
        </div>

        <div class="seletor-item rounded d-flex justify-content-between box-shadow-08 font-xs" style="cursor: pointer;"
            onclick="showNumbers('pago')">
            <div class="nome bg-white rounded-start text-dark p-2">
                Pagos
            </div>
            <div class="num bg-success text-white p-2 rounded-end">
                {{ $productModel->qtdNumerosPagos() }}
            </div>
        </div>
    </div>
@endif




<div class="container text-center">
    <div class="raffles {{ $product[0]->status == 'Finalizado' ? 'finished' : '' }}" id="raffles"
        style="margin-bottom: 150px !important;">
        <div id="message-raffles" class="blob"
            style="background-color: transparent;color: #000;font-weight: bold;text-align: center;">
        </div>
    </div>
</div>



<div class="d-flex justify-content-center">
    <div class="payment" id="payment" style="display: none; width: 500px !important;margin-bottom: 10px;">
        <div class="row justify-content-center">
            <div class="col-md-12 col-9" style="background-color: #fff; color: #000; border-radius: 10px;">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center" style="width: 100%">
                            <span id="numberSelected" class="scrollmenu"></span>
                        </div>
                    </div>
                    <div class="row"
                        style="text-align: center;background-color: #fff; margin-top: 5px; justify-content-center; margin-bottom: 10px;">
                        <div class="col-12 d-flex justify-content-center">
                            <center style="width: 400px;">
                                <button type="button" class="btn btn-danger reservation blob"
                                    style="border: none;color: #fff;font-weight: bold;width: 100%;background-color: green" onclick="openModalCheckout()"><i
                                        class="far fa-check-circle"></i>&nbsp;Participar do
                                    sorteio
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
