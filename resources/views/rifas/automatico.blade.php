<style>
    .body-compra-auto {
        background-color: #fff;
        border: none;
        border-radius: 10px;
        margin-top: 20px;
    }

    .body-compra-auto.dark {
        background: #222222;
    }

    .title-compra-auto h5 {
        color: #000;
    }

    .title-compra-auto span {
        color: #000;
    }

    .title-compra-auto.dark h5 {
        color: #fff;
    }

    .title-compra-auto.dark span {
        color: #fff;
    }

    .btn-add-qtd {
        color: #000;
        background-color: #fff;
        border-radius: 0px;
        padding: 10px;
        margin: 2px;
        border: 1px solid;
        width: 100%;
        min-width: 50px;
        max-width: 300px;
    }

    .btn-add-qtd.dark {
        background: rgba(0, 0, 0, .1) !important;
        border-color: rgba(0, 0, 0, .1) !important;
        color: #fff !important;
    }
</style>

<div class="card" style="border: none;border-radius: 10px;background-color: transparent;margin-bottom: 50px!important;">
    <div class="card-body body-compra-auto {{ $config->tema }}" style="">
        <div class="" style="">
            <?php $resultNumber = $totalPago; ?>
        </div>
        <div class="title-compra-auto {{ $config->tema }}" style="margin-bottom: 10px;">
            <h5 style="font-weight: bold;">COMPRA AUTOMÁTICA</h5>
            <span style="">O site escolhe números aleatórios para você.</span><br>
        </div>


        <div class="row d-flex justify-content-center">
            @foreach ($productModel->comprasAuto()->where('qtd', '>', 0) as $compra)
                <div class="col-6">
                    <div class="btn-auto btn-add-qtd {{ $config->tema }} {{ $compra->popular ? 'btn-popular' : '' }}" onclick="addQtd('{{ $compra->qtd }}')">
                        <span style="font-weight: 900">+  {{ $compra->qtd < 10 ? '0' : '' }}{{ $compra->qtd }}</span><br>
                        <span style="font-size: 14px;font-weight: bold;">SELECIONAR</span>
                        @if ($compra->popular)
                            <span class="badge bg-success text-popular">MAIS POPULAR</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{-- <div style="display: flex;justify-content: center;position:relative">
            <div class="btn-auto btn-add-qtd {{ $config->tema }}" onclick="addQtd('5')">
                + 5<br>
                <span style="font-size: 14px;font-weight: bold;">SELECIONAR</span>
            </div>
            <div class="btn-auto btn-add-qtd {{ $config->tema }}" onclick="addQtd('10')">
                + 10<br>
                <span style="font-size: 14px;font-weight: bold;">SELECIONAR</span>

            </div>
        </div>
        <div class="" style="display: flex;justify-content: center;">
            <div class="btn-auto btn-add-qtd {{ $config->tema }}" onclick="addQtd('30')">
                + 30<br>
                <span style="font-size: 14px;font-weight: bold;">SELECIONAR</span>
            </div>
            <div class="btn-auto btn-popular btn-add-qtd {{ $config->tema }}" onclick="addQtd('50')">
                + 50<br>
                <span style="font-size: 14px;font-weight: bold;">SELECIONAR</span>
                <span class="badge bg-success text-popular">MAIS POPULAR</span>
            </div>
        </div>
        <div class="" style="display: flex;justify-content: center;">
            <div class="btn-auto btn-add-qtd {{ $config->tema }}" onclick="addQtd('100')">
                + 100<br>
                <span style="font-size: 14px;font-weight: bold;">SELECIONAR</span>
            </div>
            <div class="btn-auto btn-add-qtd {{ $config->tema }}" onclick="addQtd('500')">
                + 500<br>
                <span style="font-size: 14px;font-weight: bold;">SELECIONAR</span>
            </div>
        </div> --}}
        <div class="" style="margin-top: 20px;margin-bottom: 20px;text-align: center;">
            <div class="amount">
                <div class="form-group"
                    style="margin-bottom: 0;display: flex;justify-content: center;flex-direction: inherit;align-items: center;">
                    <button class="btn-amount-qtd" onclick="addQtd('-')"
                        style="color: #000;margin-right: 5px;">-</button>
                    <input type="number"
                        style="text-align: center;background-color: #E5E5E5;color: #000000;font-weight: bold;"
                        id="numbersA" value="{{ $productModel->minimo }}" min="{{ $productModel->minimo }}"
                        max="{{ $productModel->maximo }}" onblur="numerosAleatorio();" onkeyup="numerosAleatorio()"
                        class="form-control" placeholder="Quantidade de cotas">
                    <button class="btn-amount-qtd" onclick="addQtd('+')"
                        style="color: #000;margin-left: 5px;">+</button>
                </div>
                <button type="button" class="btn btn-danger reservation btn-amount blob bg-success"
                    style="color: #fff;border: none;width: 100%;margin-top: 5px;font-weight: bold;"
                    onclick="validarQtd()"><i class="far fa-check-circle"></i>&nbsp;Participar
                    do sorteio<span id="numberSelectedTotalHome" style="color: #fff;float:right"></span></button>
            </div>
        </div>
    </div>
</div>
