<div class="paymentAutomatic" id="paymentAutomatic" style="display: none;width: 80% !important">
    <div class="row">
        <div class="col-md-12" style="background: #000000;padding-top: 10px;">
            <div class="container">
                <div class="row">
                    <div class="col-8">
                        <h3 style="color: #ff1c1c!important;font-size: 18px;margin: 0px;font-weight: bold;">
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
                                id="numbersA" value="1" min="1" onblur="numerosAleatorio(this);"
                                class="form-control" placeholder="Quantidade de cotas">
                            <button class="btn-amount-qtd" onclick="addQtd('+')"
                                style="color: #000;margin-left: 5px;width: 50px;">+</button>
                        </div>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-danger reservation btn-amount blob"
                            style="border: none;color: #fff;font-weight: bold;width: 100%;background-color: #ff1c1c"
                            onclick="validarQtd()">COMPRAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
