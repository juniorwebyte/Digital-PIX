@extends('layouts.app')

@if (isset($product))
    @section('title', $product[0]->name)
    @section('description', '')
    @section('ogTitle', $product[0]->name)
    @section('ogUrl', url(''))
    @section('ogImage', url('/products/' . $product[0]->image))
    @section('sidebar')

    @section('ogContent')
        <meta property="og:title" content="{{ $product[0]->name }}">
        <meta property="og:description" content="{{ $product[0]->subname }}">
        <meta property="og:image" itemprop="image" content="{{ url('/products/' . $product[0]->image) }}">
        <meta property="og:type" content="website">
    @endsection
@stop



@section('content')
    <script>
        function infoParticipante(msg) {
            Swal.fire(msg)
        }
    </script>

    <link rel="stylesheet" href="{{ asset('css/product-detail-v2.css') }}">

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

    <style>
        @media screen and (max-width: 768px) {
            .detail {
                /* margin-top: 90px !important; */
                /* margin-top: 20px !important; */
                /* margin-top: -15px !important; */
                position: absolute;
                z-index: 9999 !important;
            }
        }

            .rifa-content.dark {
                background: #383838;
            }

            ::-webkit-scrollbar {
                display: none;
            }
    </style>

    <div class="container detail">
        <input type="hidden" id="product-name" value="{{ $productModel->name }}">
        <div class="row justify-content-center">
            <div class="col-md-6 rifa-content {{ $config->tema }}">
                <input type="hidden" id="raffleType" value="{{ $productModel->type_raffles }}">
                <input type="hidden" id="modoDeJogo" value="{{ $productModel->modo_de_jogo }}">
                @include('rifas.common')

                @if ($product[0]->status == 'Finalizado')
                    @include('rifas.finalizada')
                @else
                    @include('rifas.ativas')


                    @if ($productModel->modo_de_jogo == 'fazendinha-completa' || $productModel->modo_de_jogo == 'fazendinha-meio')
                        @if ($productModel->modo_de_jogo == 'fazendinha-completa')
                            @include('rifas.fazendinha')
                        @else
                            @include('rifas.fazendinha-meia')
                        @endif
                    @else
                        @if ($type_raffles == 'automatico')
                            @include('rifas.automatico')
                        @elseif ($type_raffles == 'manual' || $type_raffles == 'mesclado')
                            @include('rifas.manual')

                            @if ($type_raffles == 'mesclado')
                                @include('rifas.mesclado')
                            @endif
                        @endif
                    @endif
                @endif
            </div>
        </div>
        <br>
        @include('layouts.footer')
    </div>


    @include('rifas.modal')

    <script>
        document.getElementById('telephone3').addEventListener('input', function(e) {
            var aux = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
            e.target.value = !aux[2] ? aux[1] : '(' + aux[1] + ') ' + aux[2] + (aux[3] ? '-' + aux[3] : '');
        });

        $(document).ready(function() {
            numerosAleatorio();

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
            var disponivel = parseInt('{{ $productModel->qtdNumerosDisponiveis() }}');
            if (qtd > disponivel) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Quantidade indisponível!',
                    footer: 'Disponível: ' + disponivel
                });
            } else {
                openModalCheckout();
            }
        }

        function openModalCheckout() {
            var raffleType = $('#raffleType').val();
            var modoJogo = $('#modoDeJogo').val();
            if (raffleType == 'manual' || modoJogo == 'fazendinha-completa' || modoJogo == 'fazendinha-meio') {
                var qtdCompra = $('#qtdManual').val()
            } else {
                var qtdCompra = $('#qtdNumbers').val()
            }

            var nomeRifa = $('#product-name').val()

            $('#qtd-checkout').text(qtdCompra)
            $('#rifa-checkout').text(nomeRifa)

            $('#staticBackdrop').modal('show')
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

        function infoPromo() {
            Swal.fire('Escolha os números abaixo, o desconto será aplicado automaticamente!');
        }

        function addQtd(e, valor = null) {
            if (!validaMaxMin(e)) {
                alert('Qtd mínima de compra atingida.')
                return
            }

            const input = document.getElementById('numbersA');

            if (valor != null) {
                input.value = parseInt(e);
                numerosAleatorio(valor);

                openModalCheckout();
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
                } else {
                    input.value = parseInt(input.value) + parseInt(e);
                    numerosAleatorio();
                }

                // else if (e === '1') {
                //     input.value = parseInt(input.value) + 1;

                //     numerosAleatorio();
                // } else if (e === '5') {
                //     input.value = parseInt(input.value) + 5;

                //     numerosAleatorio();
                // } else if (e === '10') {
                //     input.value = parseInt(input.value) + 10;

                //     numerosAleatorio();
                // } else if (e === '30') {
                //     input.value = parseInt(input.value) + 30;

                //     numerosAleatorio();
                // } else if (e === '15') {
                //     input.value = parseInt(input.value) + 15;

                //     numerosAleatorio();
                // } else if (e === '50') {

                //     input.value = parseInt(input.value) + 50;


                //     numerosAleatorio();
                // } else if (e === '100') {

                //     input.value = parseInt(input.value) + 100;


                //     numerosAleatorio();
                // } else if (e === '150') {


                //     input.value = parseInt(input.value) + 150;

                //     numerosAleatorio();
                // } else if (e === '200') {


                //     input.value = parseInt(input.value) + 200;

                //     numerosAleatorio();
                // } else if (e === '500') {


                //     input.value = parseInt(input.value) + 500;

                //     numerosAleatorio();
                // }
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
                var lDescontos = JSON.parse(descontos)
                var percentDesconto = 0;


                lDescontos.forEach(function(i) {
                    if (qtd >= parseInt(i.numeros)) {
                        percentDesconto = i.desconto
                    }
                })

                if (percentDesconto > 0) {
                    total = value.toString().replace(",", ".") * qtd - (value.toString().replace(",", ".") * qtd *
                        percentDesconto /
                        100);
                    totalFomat = total.toLocaleString('pt-br', {
                        style: 'currency',
                        currency: 'BRL'
                    });

                    totalPromo = total.toLocaleString('pt-br', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    });

                    // alert(totalPromo);
                    $('#promo').val(totalPromo)
                } else {
                    $('#promo').val(0)
                    total = value.toString().replace(",", ".") * qtd;
                    totalFomat = total.toLocaleString('pt-br', {
                        style: 'currency',
                        currency: 'BRL'
                    });
                }
            }


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
        const descontos = '{!! $productModel->promosAtivas() !!}'
        let total;

        function wdm() {
            var teste = JSON.parse(descontos)
            console.log(teste)
        }

        function selectFazendinha(id) {
            const x = document.getElementById(id);

            console.log(x);

            if (x.classList.contains('selected-group')) {

                x.classList.remove("selected-group");

                numbersManual.splice(numbersManual.indexOf(x.id), 1);

                // document.getElementById('numberSelected').innerHTML = numbersManual;
                $('#selected-' + x.id).remove()
                // document.getElementById('numberSelectedModal').innerHTML = numbersManual;
                document.getElementById('numberSelectedInput').value = numbersManual;
                document.getElementById('qtdManual').value = numbersManual.length;

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


                x.classList.add("selected-group");

                numbersManual.push(x.id);

                // document.getElementById('numberSelected').innerHTML = numbersManual;

                var teste = document.createElement('div');
                var texto = document.createTextNode(x.dataset.grupo);
                teste.classList = 'number-selected fazendinha';
                teste.id = 'selected-' + x.id
                teste.appendChild(texto)
                document.getElementById('numberSelected').appendChild(teste)

                //document.getElementById('numberSelectedModal').innerHTML = numbersManual;
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

                document.getElementById('qtdManual').value = numbersManual.length;
                document.getElementById("payment").style.display = "";

            }
        }



        function selectRaffles(id, key) {
            const x = document.getElementById(id);

            if (x.classList[3] == "selected") {

                x.classList.remove("selected");

                numbersManual.splice(numbersManual.indexOf(x.id + '-' + key), 1);

                // document.getElementById('numberSelected').innerHTML = numbersManual;
                $('#selected-' + x.id).remove()
                document.getElementById('numberSelectedModal').innerHTML = numbersManual;
                document.getElementById('numberSelectedInput').value = numbersManual;
                document.getElementById('qtdManual').value = numbersManual.length;

                $('#promo').val(0)
                var lDescontos = JSON.parse(descontos)
                var percentDesconto = 0;

                lDescontos.forEach(function(i) {
                    if (numbersManual.length >= parseInt(i.numeros)) {
                        percentDesconto = i.desconto
                    }
                })

                if (percentDesconto > 0) {
                    total = valuePrices.toString().replace(",", ".") * numbersManual.length - (valuePrices.toString()
                        .replace(",", ".") * numbersManual.length * percentDesconto / 100);
                    totalFomat = total.toLocaleString('pt-br', {
                        style: 'currency',
                        currency: 'BRL'
                    });

                    totalPromo = total.toLocaleString('pt-br', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    });

                    // alert(totalPromo);
                    $('#promo').val(totalPromo)
                } else {
                    $('#promo').val(0)
                    total = valuePrices.toString().replace(",", ".") * numbersManual.length;
                    totalFomat = total.toLocaleString('pt-br', {
                        style: 'currency',
                        currency: 'BRL'
                    });
                }

                // total = valuePrices.toString().replace(",", ".") * numbersManual.length;
                // totalFomat = total.toLocaleString('pt-br', {
                //     style: 'currency',
                //     currency: 'BRL'
                // });

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
                x.classList.add("selected");

                numbersManual.push(x.id + '-' + key);

                var teste = document.createElement('div');
                var texto = document.createTextNode(x.id);
                teste.classList = 'number-selected';
                teste.id = 'selected-' + x.id
                teste.appendChild(texto)
                document.getElementById('numberSelected').appendChild(teste)

                document.getElementById('numberSelectedModal').innerHTML = numbersManual;
                document.getElementById('numberSelectedInput').value = numbersManual;
                document.getElementById('qtdManual').value = numbersManual.length;

                const productID = '{{ $product[0]->id }}';

                $('#promo').val(0)
                var lDescontos = JSON.parse(descontos)
                var percentDesconto = 0;

                lDescontos.forEach(function(i) {
                    if (numbersManual.length >= parseInt(i.numeros)) {
                        percentDesconto = i.desconto
                    }
                })

                if (percentDesconto > 0) {
                    total = valuePrices.toString().replace(",", ".") * numbersManual.length - (valuePrices.toString()
                        .replace(",", ".") * numbersManual.length * percentDesconto / 100);
                    totalFomat = total.toLocaleString('pt-br', {
                        style: 'currency',
                        currency: 'BRL'
                    });

                    totalPromo = total.toLocaleString('pt-br', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    });

                    // alert(totalPromo);
                    $('#promo').val(totalPromo)
                } else {
                    $('#promo').val(0)
                    total = valuePrices.toString().replace(",", ".") * numbersManual.length;
                    totalFomat = total.toLocaleString('pt-br', {
                        style: 'currency',
                        currency: 'BRL'
                    });
                }

                //*********************************************//
                // total = valuePrices.toString().replace(",", ".") * numbersManual.length;
                // totalFomat = total.toLocaleString('pt-br', {
                //     style: 'currency',
                //     currency: 'BRL'
                // });



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

                    document.getElementById('messageIn').innerHTML = data[0] + ' acabou de comprar 🤑';
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

        function showNumbers(status) {
            document.querySelectorAll('.disponivel').forEach((el) => {
                el.style.display = 'none';
            });

            document.querySelectorAll('.reservado').forEach((el) => {
                el.style.display = 'none';
            });

            document.querySelectorAll('.pago').forEach((el) => {
                el.style.display = 'none';
            });

            document.querySelectorAll(`.${status}`).forEach((el) => {
                el.style.display = '';
            });
        }

        function showNumbersFazendinha(status) {
            document.querySelectorAll('.fazenda-disponivel').forEach((el) => {
                el.style.display = 'none';
            });

            document.querySelectorAll('.fazenda-reservado').forEach((el) => {
                el.style.display = 'none';
            });

            document.querySelectorAll('.fazenda-pago').forEach((el) => {
                el.style.display = 'none';
            });

            document.querySelectorAll(`.fazenda-${status}`).forEach((el) => {
                el.style.display = '';
            });
        }
    </script>
@endif
@stop
