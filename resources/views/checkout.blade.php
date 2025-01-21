@extends('layouts.app')

<style>
    body {
        background-color: #132439 !important;
    }

    .nav-link.active {
        color: #495057;
        background-color: #020f1e !important;
        border-color: #dee2e6 #dee2e6 #fff;
    }
</style>

@section('title', 'Page Title')

@section('sidebar')

@stop

@section('content')
<!--<div class="" style="background-color: #9c2526;text-align: center;justify-content: center;">
    <div class=" date-promotion">
        <p style="font-weight: bold;
    text-transform: uppercase;
    color: #ffffff;padding-top: 10px;">Prazo para pagamento</p>

        <div style="display: flex;color: #fff;
    text-align: center;
    justify-content: center;
    font-size: 28px;">
            <div id="horas" class="time"></div>:
            <div id="minutos" class="time"></div>:
            <div id="segundos" class="time"></div>
            <div id="debug"></div>
        </div>
    </div>
</div>-->

<!--<div class="container" style="text-align: center;font-weight: bold;font-size: 18px;">
    <i class="bi bi-shield-fill-check" style="color: #29b300;"></i> COMPRA 100% SEGURA
</div>-->

<div class="container">
    <!--<div class="sub-title">Vários participantes já tiveram seu sonho realizado, você pode ser o próximo!</div>-->

    <div class="row">
        <div class="col-md-6" style="margin-bottom: 20px;">
            <div class="title">
                <h5 style="color: #fff;margin-top: 10px;">Reserva aguardando pagamento...</h5>
            </div>

            <div class="container" style="background-color: #020f1e;">
                <div class="row">
                    <div class="col-3" style="padding: 10px;">
                        <img src="/products/{{$image}}" style="width: 100%;border-radius: 100%;">
                    </div>
                    <div class="col-9" style="padding-top: 10px;padding-bottom: 10px;">
                        <span style="color: #fff;">
                            <b style="color: #f4f4f4!important;">{{$product}}</b><br>
                            <b style="color: #c7c7c7;">Participante:</b> {{$participant}}<br>
                            <b style="color: #c7c7c7;">Telefone:</b> {{$telephone}}<br>
                            <b style="color: #c7c7c7;">Cotas:</b> {{str_replace(',', ', ', $numbers)}}<br>
                            <b style="color: #c7c7c7;">Total:</b> R$: {{$price}}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6" style="margin-bottom: 20px;">
            <div class="title">
                <h5 style="color: #fff;margin-top: 10px;">Formas de pagamento</h5>
            </div>

            <div class="card" style="border: none;">
                <div class="card-body" style="background-color: #020f1e;">
                    <!--text-align: center;display: flex;flex-direction: column;-->
                    <img src="/images/pix-106.png" style="width: 150px;"><br><br>

                    <ul class="nav nav-tabs" id="myTab" role="tablist" style="font-size: 12px;">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><small style="text-align: center;">OPÇÃO 1</small><br>PIX COPIA E COLA</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><small style="text-align: center;">OPÇÃO 2</small><br>CNPJ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false"><small style="text-align: center;">OPÇÃO 2</small><br>QR CODE</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">


                            <!--<small style="color: #fff;">QR CODE</small>-->
                            <div class="row" style="text-align: center;align-items: center;justify-content: center;">

                                <div class="container" style="margin-top: 20px;">

                                    <!--<img src="data:image/png;base64,<?= $imagePIX; ?>" style="width: 50%;"><br><br>-->


                                    <div class="col-md-12 alert alert-warning" style="color: #ffffff;
    background-color: #ff2c2c;
    border-color: #ff2c2c;
">
                                        <smal>Copie o código abaixo e utilize a opção <b style="font-size: 18px;">"PIX COPIA E COLA"</b> no aplicativo que você vai fazer o pagamento.</smal>
                                    </div>
                                </div>

                                <div class="col-md-12" style="display: flex;
    justify-content: center;">
                                    <input type="text" readonly style="width: 100%;background-color: #f4f4f4;border: 3px solid #ffffff;border-style: dotted;border-radius: 5px;background-color: #132439;color: #fff;" id="brcodepix" value="<?= $codePIX; ?>"></input>
                                    <button type="button" id="clip_btn" class="btn blob" style="background-color: #ff9800!important;color: #fff;font-weight: bold;min-width: 130px;" data-toggle="tooltip" data-placement="top" title="COPIAR CÓDIGO PIX" onclick="copiar()">COPIAR CÓDIGO PIX</i></button>
                                </div>
                            </div>

                            <small style="color: #fff;margin-top: 10px;text-align: center;justify-content: center;align-items: center;display: flex;">O tempo para você pagar acaba em: </small>

                            <div style="display: flex;color: #fff;
    text-align: center;
    justify-content: center;
    font-size: 16px;">
                                <div id="minutos" class="time"></div>:
                                <div id="segundos" class="time"></div>
                                <div id="debug"></div>
                            </div><br>

                            <div class="" style="text-align: center;">
                                <a href="" style="color: #ff2c2c;font-weight: bold;" data-toggle="modal" data-target="#exampleModal">Como funciona?</a><br><br>
                            </div>


                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">


                            <div class="card" style="border: none;text-align: center;">
                                <div class="card-body" style="background-color: #020f1e;color: #fff;">
                                    FAVORECIDO: FABIO FERREIRA DESENVOLVIMENTO DE SISTEMAS EIRELI<br><br>
                                    CNPJ: <b>39790457000182</b><br><br>
                                    <smal style="color: red;"><b>Atenção</b>: Pagamentos a com chave <b>CNPJ</b> é preciso enviar o comprovante de pagamento!</smal>
                                </div>
                            </div>


                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">


                            <div class="" style="margin-top: 20px;text-align: center;">
                                <img src="data:image/png;base64,<?= $imagePIX; ?>" style="width: 50%;">
                            </div><br>

                            <smal style="text-align: center;
    color: #fff;
    justify-content: center;
    display: flex;">Leia o QR CODE no aplicativo do seu banco para efetuar o pagamento!</smal>
                           

                        </div>
                    </div>


                </div>
            </div><br>

            <!--<div class="card alert alert-success">
                <div class="card-body" style="text-align: center;display: flex;flex-direction: column;padding: 0px!important;">
                    <span style="font-size: 25px;color: #333;">Siga-nos nas redes sociais para acompanhar as atualizações do sorteio! <br> <a href="https://instagram.com/sucessonaescolhaoficial"><i class="bi bi-instagram" style="color: #d41b45;font-size: 30px;"></i></a> <a href="https://facebook.com/sucessonaescolhaoficial"><i class="bi bi-facebook" style="color: #395498;font-size: 30px;"></i></a></span>
                </div>
            </div>-->

            <div class="card alert alert-success">
                <div class="card-body" style="text-align: center;display: flex;flex-direction: column;padding: 0px!important;">
                    <span style="font-size: 20px;color: #333;">Já fez o pagamento? Envie o comprovante de pagamento para nós!!! Envie pelo
                        <a href="https://api.whatsapp.com/send/?phone=55{{$telephoneConsulting->telephone}}&text=Olá,%20segue%20o%20meu%20comprovante%20de%20pagamento%20%20da(s)%20cota(s)%20{{$numbers}}" target="_blank" style="font-size: 25px;color: #333;text-decoration: none;"> <span style="background-color: #28a745;
    padding: 5px;
    border-radius: 5px;
    color: #ffffff;">WhatsApp</span></a></span>
                </div>
            </div>

            <img src="/images/seguro.png" style="width: 100%;">

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border: none;">
            <div class="modal-header" style="background-color: #18293c;">
                <h5 class="modal-title" id="exampleModalLabel" style="color: #fff;text-decoration: none;">Como funciona?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="background-color: #18293c;">
                <div class="row">
                    <div class="col-md-12" style="text-align: center;color: #fff;">
                        <img src="/images/pix-106.png" style="width: 150px;"><br><br>

                        <b style="font-size: 18px;">Como pagar com PIX?</b><br><br>

                        <p style="color: #ff2c2c;font-weight: bold;">1º passo</p>

                        <p>Copie o código que foi gerado</p>

                        <p style="color: #ff2c2c;font-weight: bold;">2º passo</p>

                        <p>Abra um aplicativo em que você tenha o PIX habilitado e use a opção PIX COPIA E COLA</p>

                        <p style="color: #ff2c2c;font-weight: bold;">3º passo</p>

                        <p>Cole o código, confirme o valor e faça o pagamento. O seu <b>número da sorte será confirmado na hora</b> :)</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background-color: #18293c;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="width: 100%;background-color: #ff2c2c;border: none;">Ok, Entendi</button>
            </div>
        </div>
    </div>
</div>

<div class="" style="background-color: #0F9EE2;">
    <div class="" style="background-color: #0F9EE2!important;">
        <div class="container">
            <div class="row" style="color: #ffffff;padding-top: 30px;padding-bottom: 60px;">
                <div class="col-md-3" style="min-height: 200px;">
                    <span class="" style="font-size: 190px;
    position: absolute;
    top: -70px;
    left: 20px;
    color: #333;
    opacity: 0.3;">1</span>
                    <h4 class="" style="font-weight: bold;">
                        <i class="bi bi-search"></i>
                        ESCOLHA O SORTEIO
                    </h4>
                    <p class="" style="font-size: 20px;">Escolha o prêmio que gostaria de concorrer, verifique a descrição, regulamento
                        do sorteio e fotos. Em caso de dúvidas entre em contato com o administrador.</p>
                </div>
                <div class="col-md-3" style="min-height: 200px;">
                    <span class="" style="font-size: 190px;
    position: absolute;
    top: -70px;
    left: 20px;
    color: #333;
    opacity: 0.3;">2</span>
                    <h4 class="" style="font-weight: bold;">
                        <i class="bi bi-check-circle"></i>
                        SELECIONE SEUS NÚMEROS
                    </h4>
                    <p class="" style="font-size: 20px;">Você pode escolher quantos números desejar!
                        Mais números, mais chances de ganhar.</p>
                </div>
                <div class="col-md-3" style="min-height: 200px;">
                    <span class="" style="font-size: 190px;
    position: absolute;
    top: -70px;
    left: 20px;
    color: #333;
    opacity: 0.3;">3</span>
                    <h4 class="" style="font-weight: bold;">
                        <i class="bi bi-cash"></i>
                        FAÇA O PAGAMENTO
                    </h4>
                    <p class="" style="font-size: 20px;">Faça o pagamento no(s) método(s) de pagamento(s) disponíveis no site.</p>
                </div>
                <div class="col-md-3" style="min-height: 200px;">
                    <span class="" style="font-size: 190px;
    position: absolute;
    top: -70px;
    left: 20px;
    color: #333;
    opacity: 0.3;">4</span>
                    <h4 class="" style="font-weight: bold;">
                        <i class="bi bi-hourglass-split"></i>
                        AGUARDE O SORTEIO
                    </h4>
                    <p class="" style="font-size: 20px;">Aguarde o Sorteio. Cruze os dedos! Você pode ser o próximo sorteado.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copiar() {
            var copyText = document.getElementById("brcodepix");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
            document.getElementById("clip_btn").innerHTML = 'COPIADO';

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
            minutes = Math.floor((dateDiff % 15));

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