@extends('layouts.app')

<style>
    body {
        background-color: #132439 !important;
    }
</style>

@section('title', 'Page Title')

@section('sidebar')

@stop

@section('content')
<div class="container">
    <div class="title">
        <h3 style="color: #fff;">MINHAS RESERVAS</h3>
    </div>
    <div class="row" style="margin-bottom: 130px;">
        <div class="col-md-7" style="margin-bottom: 20px;">
            <div class="card" style="border: none;">
                <div class="card-body" style="background-color: #020f1e;">
                    <h5 class="card-title" style="color: #fff;"><i class="bi bi-cash"></i> Informações da Reserva</h5>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td style="color: #fff;">Participante: {{$participantDetail == null ? '' : $participantDetail->name}}</td>
                                <td style="color: #fff;"></td>
                            </tr>
                            <tr>
                                <td style="color: #fff;">Telefone: {{$participantDetail == null ? '' : $participantDetail->telephone}}</td>
                                <td style="color: #fff;"></td>
                            </tr>
                            <tr>
                                <td style="color: #fff;">Meu(s) bilhete(s) pago(s):</td>
                                <td>
                                    @foreach($resultRafflesALLs as $resultRafflesALL)
                                    <b style="background-color: #28a745;color: #fff;border-radius: 10px;padding: 5px;">
                                        {{$resultRafflesALL->number}}<br>
                                    </b><br>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td style="color: #fff;">
                                    Meu(s) bilhete(s) reservado(s):
                                </td>
                                <td>

                                    @foreach($participantReserveds as $participantReserved)

                                    <b style="background-color: #ff9800;color: #fff;border-radius: 10px;padding: 5px;">

                                        <?php

                                        echo $participantReserved->number . "<br>";

                                        ?>
                                    </b><br>


                                    @endforeach

                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @if($participantReserveds == '[]')

                    @else
                    <!--<button type="button" class="btn btn-success blob" style="width: 100%;margin-top: 10px;margin-bottom: 10px;height: 120px;font-size: 20px;text-transform: uppercase;" data-toggle="modal" data-target="#staticBackdrop">Clique para pagar sua reserva<br> R$: {{$priceBR}}</button>-->


                    <div style="color: #fff;text-align: center;">CHAVE PIX<br><?php echo @$data['social']->key_pix ?></div>

                    <img src="/images/seguro.png" style="width: 100%;">

                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-5" style="margin-bottom: 20px;">
            <div class="card checkout" style="border: none;">
                <div class="card-body" style="background-color: #020f1e;">
                    <h5 class="card-title" style="color: #fff;"><i class="bi bi-trophy"></i> Informações do Sorteio</h5>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td style="color: #fff;">Sorteio:</td>
                                <td style="color: #fff;">{{$product->name}}</td>
                            </tr>
                            <!--<tr>
                                <td>Data do Sorteio:</td>
                                <td>
                                    @if($product->draw_date == NULL)
                                    Data do sorteio será marcada e divulgada após a venda de todas as cotas!
                                    @else
                                    {{$product->draw_date}}
                                    @endif
                                </td>
                            </tr>-->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 999999999;">
    <div class="modal-dialog">
        <div class="modal-content" style="border: none;">
            <div class="modal-header" style="background-color: #132439;color: #fff;">
                <h5 class="modal-title" id="staticBackdropLabel">PAGAMENTO VIA PIX
                    <!--<img src="{{asset('images/pix-106.png')}}" style="width: 80px;margin-bottom: 5px;">-->
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="background-color: #132439;">

                <div class="title">
                    <h5 style="color: #fff;margin-top: 10px;">Reserva aguardando pagamento...</h5>
                </div>

                <div class="card" style="border: none;">
                    <div class="card-body" style="background-color: #020f1e;color: #fff;">
                        <b>CHAVE PIX</b><br>
                        FAVORECIDO: FABIO FERREIRA DESENVOLVIMENTO DE SISTEMAS EIRELI<br>
                        CNPJ: 39.790.457/0001-82
                    </div>
                </div><br>

                <div class="card alert alert-success" style="margin-top: 10px;">
                    <div class="card-body" style="text-align: center;display: flex;flex-direction: column;padding: 0px!important;">
                        <span style="font-size: 20px;color: #333;">Já fez o pagamento? Envie o comprovante de pagamento para nós!!! Envie pelo
                            <a href="https://api.whatsapp.com/send/?phone=55{{$telephone->telephone}}&text=Olá,%20segue%20meu%20comprovante%20do%20sorteio%20{{$product->name}}%20da(s)%20cota(s)%20{{$numberReserveds}}" target="_blank" style="font-size: 25px;color: #333;text-decoration: none;"> <span style="background-color: #28a745;
    padding: 5px;
    border-radius: 5px;
    color: #ffffff;">Whatsapp</span></a></span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    function copiar(e) {

        console.log(e);

        var copyText = document.getElementById("brcodepix" + e);
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");
        document.getElementById("clip_btn" + e).innerHTML = 'COPIADO';

        /*$('#clip_btn').click(function() {
            $('#brcodepix').removeAttr('disabled');
            $('#brcodepix').select();
            document.execCommand("copy");
            $('#brcodepix').attr('disabled', 'disabled');
        });*/


        alert("Código PIX copiado com sucesso.");

    }


    function copiarCNPJ() {
        var copyText = document.getElementById("codeCNPJ");
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */
        document.execCommand("copy");
        document.getElementById("clip_btn_CNPJ").innerHTML = '<i class="bi bi-clipboard-check"></i> Copiado';

        //document.getElementById("card").style.display = "block";

        alert("CHAVE CNPJ copiada, agora pague no APP do seu banco!");

    }
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script>
    //aqui vai sempre ser a hora atual
    var startDate = new Date();
    //como exemplo vou definir a data de fim com base na data atual
    var endDate = new Date();
    endDate.setDate(endDate.getDate() + 1);

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
        dateDiff = endDate - startDate;
        dateDiff = dateDiff / 1000;

        seconds = Math.floor((dateDiff % 60));

        dateDiff = dateDiff / 60;
        minutes = Math.floor((dateDiff % 60));

        dateDiff = dateDiff / 60;
        hours = Math.floor((dateDiff % 24));

        days = Math.floor(dateDiff / 24);

        $day.text(days);
        $hour.text(hours);
        $minute.text(minutes);
        $second.text(seconds);

        startDate.setSeconds(startDate.getSeconds() + 1);
    }
    update();
    timer = setInterval(update, 1000);
</script>
@stop