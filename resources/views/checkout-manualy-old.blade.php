@extends('layouts.app')

<style>
    body {
        background-color: #e3e3e3 !important;
    }

    .nav-link.active {
        color: #fff !important;
        background-color: #000 !important;
        border-color: #dee2e6 #dee2e6 #fff;
    }

    #form-checkout {
        display: flex;
        flex-direction: column;
        max-width: 600px;
    }

    .containerPayment {
        height: 39px;
        display: inline-block;
        border: 1px solid #fff;
        border-radius: 10px;
        padding: 1px 2px;
        margin-top: 10px;
        color: #fff;
    }

    .hidden {
        display: none;
    }
</style>

@section('title', 'Page Title')

@section('sidebar')

@stop

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6" style="margin-bottom: 20px;">
                <div class="title">
                    <h5 style="color: #000;margin-top: 10px;">Formas de pagamento</h5>
                </div>

                <div class="card" style="border: none;background-color: transparent!important;margin-bottom: 30px;"
                    id="divCart">
                    <div class="card-body"
                        style="background-color: #fff;
                border-bottom-left-radius: 0px!important;
                border-bottom-right-radius: 0px!important;
                border: 1px solid #a7d1be;
                border-bottom: none;">
                        <ul class="nav nav-tabs" id="myTab" role="tablist" style="font-size: 12px;">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                    aria-controls="home" aria-selected="true"><small style="text-align: center;">OPÇÃO
                                        1</small><br>PIX COPIA E COLA</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                    aria-controls="contact" aria-selected="false"><small style="text-align: center;">OPÇÃO
                                        2</small><br>QR CODE PIX</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" id="credit-tab" data-toggle="tab" href="#credit" role="tab"
                                    aria-controls="credit" aria-selected="false"><small style="text-align: center;">OPÇÃO
                                        3</small><br>Cartão de crédito</a>
                            </li> --}}
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                <div class="row" style="text-align: center;align-items: center;justify-content: center;">
                                    <div class="container" style="margin-top: 20px;">
                                        <div class="col-md-12 alert alert-warning"
                                            style="color: #ffffff;background-color: #ff2c2c;border-color: #ff2c2c;">
                                            <smal>Copie o código abaixo e utilize a opção
                                                <b style="font-size: 18px;">"PIX COPIA E COLA"</b> no aplicativo que você
                                                vai fazer o pagamento.
                                            </smal>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="display: flex;justify-content: center;">
                                        <input type="text" readonly
                                            style="width: 100%;background-color: #fff;border: 3px solid #000;border-style: dotted;border-radius: 5px;color: #000;"
                                            id="brcodepix" value="{{ $codePIX }}"></input>
                                        <button type="button" id="clip_btn" class="btn blob"
                                            style="background-color: #ff9800!important;color: #fff;font-weight: bold;min-width: 130px;margin-left:5px;"
                                            data-toggle="tooltip" data-placement="top" title="COPIAR CHAVE PIX"
                                            onclick="copiar()">COPIAR CHAVE PIX</i></button>
                                    </div>
                                    <div class="" style="text-align: center;margin-top: 20px;">
                                        <smal
                                            style="text-align: center;
                                    color: #000;
                                    justify-content: center;
                                    display: flex;">
                                            <a href="" style="color: #ff2c2c;font-weight: bold;" data-toggle="modal"
                                                data-target="#exampleModal">Como funciona?</a></smal>
                                        <!-- FBXWEB - Bootstrap correção barra de progresso  -->
                                        @if ($rifa->expiracao > 0)
                                            <div class="progress_reserva">
                                                <p class="desc"><b>Tempo restante para pagamento: </b></p>
                                                <span id="cpclock">
                                                    <span id="cpminutes"></span>:<span id="cpseconds"></span>
                                                </span>
                                                <div class="progress" role="progressbar"
                                                    aria-label="Animated striped example" aria-valuenow="100"
                                                    aria-valuemin="0" aria-valuemax="100">
                                                    <div id="cpprogress"
                                                        class="progress-bar progress-bar-striped progress-bar-animated"
                                                        style="width: 100%"></div>
                                                </div>
                                            </div>
                                        @endif
                                        <!-- //final FBXWEB - Bootstrap correção barra de progresso -->
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                <div class="" style="margin-top: 20px;text-align: center;">
                                    <img src="data:image/jpeg;base64,{{ $qrCode }}" style="width: 50%;">
                                </div>
                                <br>
                                <smal
                                    style="text-align: center;
                                color: #000;
                                justify-content: center;
                                display: flex;">
                                    Leia o QR CODE no aplicativo do seu banco para efetuar o pagamento!
                                </smal>
                                <!-- FBXWEB - Bootstrap correção barra de progresso  -->
                                <div class="progress_reserva text-center">
                                    <p class="desc"><b>Tempo restante para pagamento: </b></p>
                                    <span id="qrclock">
                                        <span id="qrminutes"></span> : <span id="qrseconds"></span>
                                    </span>
                                    <div class="progress" role="progressbar" aria-label="Animated striped example"
                                        aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                        <div id="qrprogress"
                                            class="progress-bar progress-bar-striped progress-bar-animated"
                                            style="width: 100%"></div>
                                    </div>
                                </div>
                                <!-- //final FBXWEB - Bootstrap correção barra de progresso -->
                            </div>
                            <div class="tab-pane fade" id="credit" role="tabpanel" aria-labelledby="credit-tab">
                                <div id="cardPaymentBrick_container" style="margin-top: 20px;"></div>
                                <div class="" id="statusPayment" style="color: #ffffff;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card alert alert-success mb-3"
                        style="border-top: 0px;
                    border-top-left-radius: 0px;
                    border-top-right-radius: 0px;
                    border-bottom-left-radius: 20px;
                    border-bottom-right-radius: 20px;">
                        <div class="card-body"
                            style="text-align: center;display: flex;flex-direction: column;padding: 0px!important;">
                            <span style="font-size: 18px;color: #333;">Após o pagamento a sua reserva é validada
                                automaticamente confira em seu e-mail os dados da sua reserva e boa sorte :)</span>
                        </div>
                    </div>
                </div>
                <div class="card"
                    style="border: none;background-color: transparent!important;margin-bottom: 30px;display:none"
                    id="divPixSuccess">
                    <div class="card-body text-center text-success" style="background-color: #fff;border: 2px dashed;">
                        <div class="row">
                            <i class="fa fa-check-circle fa-6x" style="margin-bottom: 2rem;"></i>
                        </div>
                        <h3>Seu pagamento foi aprovado com sucesso!</h3>
                        <div>
                            <?php
                            $varID = $telephone . '=' . $productID;
                            ?>
                            <a href="javascript:void(0)" onclick="verPedidos()" class="btn btn-success mt-4"><i
                                    class="fa fa-eye"></i> Visualizar Pedidos</a>
                        </div>

                        <script>
                            function verPedidos(){
                                $('#form-pedidos').submit();
                            }
                        </script>

                        <form action="{{route('minhasReservas')}}" id="form-pedidos" method="POST" style="display: none;">
                            {{ csrf_field() }}
                            <input type="text" name="telephone" id="telephone" value="{{ $telephone }}">
                        </form>
                    </div>
                </div>
                <div class="card"
                    style="border: none;background-color: transparent!important;margin-bottom: 30px;display:none"
                    id="divPixTimeOut">
                    <div class="card-body text-center text-danger" style="background-color: #fff;border: 2px dashed;">
                        <div class="row">
                            <i class="fa fa-times-circle fa-6x" style="margin-bottom: 2rem;"></i>
                        </div>
                        <h3>Desculpe, mas seu tempo acabou! <br>Tente novamente!</h3>
                        <a href="{{ route('product', $rifa->slug) }}" class="btn btn-xs btn-danger"> RESERVAR RIFA </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6" style="margin-bottom: 20px;">
                <div class="title">
                    <h5 style="color: #000;margin-top: 10px;">Resumo da sua reserva, realize o pagamento</h5>
                </div>

                <div class="container" style="background-color: #fff;">
                    <div class="row">
                        <div class="col-4" style="padding: 10px;">
                            <img src="/products/{{ $image }}" style="width: 100%;border-radius: 100%;">
                        </div>
                        <div class="col-8" style="padding-top: 10px;padding-bottom: 10px;">
                            <span style="color: #000;">
                                <b style="color: #000!important;">{{ $product }}</b><br>
                                <b style="color: #000;">Participante:</b> {{ $participant }}<br>
                                <b style="color: #000;">Telefone:</b> {{ $telephone }}<br>
                                <b style="color: #000;">Cotas:</b>
                                @if ($rifa->modo_de_jogo == 'numeros')
                                    @foreach ($numbers as $key => $number)
                                        @if ($key > 0)
                                            ,
                                        @endif
                                        {{ $number->number }}
                                    @endforeach    
                                @else
                                    @foreach ($participante->reservados() as $key => $number)
                                        @if ($key > 0)
                                            ,
                                        @endif
                                        {{ $number->grupoFazendinha() }}
                                    @endforeach
                                @endif
                                
                                <br>
                                <b style="color: #000;">Total a pagar:</b> R$: {{ $price }}
                            </span>
                        </div>
                        <img src="/images/seguro.png" style="width: 100%;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border: none;">
                <div class="modal-header" style="background-color: #18293c;">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: #fff;text-decoration: none;">Como
                        funciona?</h5>
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

                            <p>Cole o código, confirme o valor e faça o pagamento. O seu <b>número da sorte será confirmado
                                    na hora</b> :)</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #18293c;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        style="width: 100%;background-color: #ff2c2c;border: none;">Ok, Entendi</button>
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

            alert("Chave PIX COPIA E COLA copiado com sucesso.");
        }



        let freezeTimmer = new Date().setMinutes(new Date().getMinutes());
        let countdownDate = new Date().setMinutes(new Date().getMinutes() + {!! $minutosRestantes !!})
        let countDifference = countdownDate - freezeTimmer;
        let timerInterval;
        const minutesElem = document.querySelector("#cpminutes"),
            secondsElem = document.querySelector("#cpseconds"),
            qRminutesElem = document.querySelector("#qrminutes"),
            qRsecondsElem = document.querySelector("#qrseconds"),
            timerRunnigContent = document.querySelector("#divCart"),
            timerEndContent = document.querySelector("#divPixTimeOut"),
            cpProgressElementBar = document.querySelector("#cpprogress"),
            qrProgressElementBar = document.querySelector("#qrprogress");

        const formatZero = (time) => {
            let dateFormated,
                calculated = Math.floor(Math.log10(time) + 1);

            if (calculated < 1) {
                dateFormated = `<span>0${time}</span>`;
            }
            if (calculated === 1) {
                dateFormated = `<span>0${time}</span>`;
            }
            if (calculated > 1) {
                dateFormated = `<span>${time}</span>`;
            }

            return dateFormated;
        }



        const progressBarPercent = (difference, timeTotal) => {
            let color;
            let percent = Math.floor((difference * 100) / timeTotal);
            switch (percent) {
                case 100:
                    color = "bg-success";
                    break;
                case 55:
                    color = "bg-info";
                    break;
                case 35:
                    color = "bg-warning";
                    break;
                case 25:
                    color = "bg-danger";
                    break;
            }

            return data = new Array(percent, color);
        }


        const startCountdown = () => {
            const now = new Date().getTime();
            const countdown = new Date(countdownDate).getTime();
            const difference = (countdown - now) / 1000;

            let countedDifference = Math.floor(difference) * 1000;
            let countedFinalTimmer = Math.floor(countdownDate - freezeTimmer);
            let progressBar = progressBarPercent(countedDifference, countedFinalTimmer);


            if (difference < 1) {
                endCountdown();
            }

            let days = Math.floor((difference / (60 * 60 * 24)));
            let hours = Math.floor((difference % (60 * 60 * 24)) / (60 * 60));
            let minutes = Math.floor((difference % (60 * 60)) / 60);
            let seconds = Math.floor(difference % 60);

            minutesElem.innerHTML = formatZero(minutes);
            secondsElem.innerHTML = formatZero(seconds);
            qRminutesElem.innerHTML = formatZero(minutes);
            qRsecondsElem.innerHTML = formatZero(seconds);
            cpProgressElementBar.setAttribute("aria-valuenow", progressBar[0]);
            qrProgressElementBar.setAttribute("aria-valuenow", progressBar[0]);
            cpProgressElementBar.classList.add(progressBar[1]);
            qrProgressElementBar.classList.add(progressBar[1]);
            cpProgressElementBar.style.width = progressBar[0] + '%'
            qrProgressElementBar.style.width = progressBar[0] + '%'


        }

        const endCountdown = () => {
            clearInterval(timerInterval);
            timerRunnigContent.className = 'hidden';
            timerEndContent.style.display = 'block';
        }

        var expiracao = {{ $rifa->expiracao }};
        window.addEventListener('load', () => {
            if (expiracao > 0) {
                startCountdown();
                timerInterval = setInterval(startCountdown, 1000);
            }
        });

        <?php
        $newID = $codePIXID . '-' . $productID;
        ?>

        $(document).ready(function() {
            let timerPix = setInterval(function checkPixSuccess() {
                $.ajax({
                    url: "{{ route('findPixStatus', $newID) }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    },
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        'id': "{{ $codePIXID }}",
                        'product_id': "{{ $productID }}"

                    },

                    success: function(data) {
                        if (data.status === true) {
                            document.getElementById("divCart").className = 'hidden';
                            document.getElementById("divPixSuccess").style.display = 'block'
                            clearInterval(timerPix);
                            clearInterval(timerInterval);

                        }
                    }
                });

            }, 2000);
        });


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

    <script>
        var price = "{{ $price }}";
        var resultPrice = price.toString().replace(',', '.');

        const bricksBuilder = mp.bricks();
        const renderCardPaymentBrick = async (bricksBuilder) => {
            const settings = {
                initialization: {
                    amount: resultPrice, // valor total a ser pago
                    payer: {
                        email: "{{ $email }}",
                    },
                },
                customization: {
                    visual: {
                        style: {
                            theme: 'default', // | 'dark' | 'bootstrap' | 'flat'
                        }
                    },
                },
                callbacks: {
                    onReady: () => {
                        // callback chamado quando o Brick estiver pronto
                    },
                    onSubmit: (cardFormData) => {
                        //  callback chamado o usuário clicar no botão de submissão dos dados
                        //  exemplo de envio dos dados coletados pelo Brick para seu servidor

                        // Adicionar com o método concat sem alterar o array original
                        let novoArray = [].concat(cardFormData, '{{ $codePIXID }}');

                        return new Promise((resolve, reject) => {
                            fetch("{{ route('paymentCredit') }}", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                            'content')
                                    },
                                    body: JSON.stringify(novoArray),

                                })
                                .then((response) => {
                                    // receber o resultado do pagamento

                                    const status = response.url.split('=');



                                    if (status[1] == 'approved') {
                                        document.getElementById("statusPayment").innerHTML =
                                            'Pagamento realizado com sucesso!';
                                    }

                                    resolve();

                                })
                                .catch((error) => {
                                    // lidar com a resposta de erro ao tentar criar o pagamento
                                    reject();
                                })
                        });
                    },
                    onError: (error) => {
                        // callback chamado para todos os casos de erro do Brick
                    },
                },
            };
            window.cardPaymentBrickController = await bricksBuilder.create('cardPayment',
                'cardPaymentBrick_container', settings);
        };
        renderCardPaymentBrick(bricksBuilder);
    </script>
@stop
