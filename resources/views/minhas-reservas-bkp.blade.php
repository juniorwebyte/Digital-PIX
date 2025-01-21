@extends('layouts.app')
<style>
    body {
        background-color: #132439 !important;
    }

    /* width */
    #div-cotas::-webkit-scrollbar {
        width: 10px;
    }

    /* Track */
    #div-cotas::-webkit-scrollbar-track {
        box-shadow: inset 0 0 5px grey;
        border-radius: 10px;
    }

    /* Handle */
    #div-cotas::-webkit-scrollbar-thumb {
        background: #28a745 !important;
        border-radius: 10px;
    }

    /* Handle on hover */
    #div-cotas::-webkit-scrollbar-thumb:hover {
        background: #28a745 !important;
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

        <div class="row mb-4">
            <div class="col-md-12">
                <label style="color: #fff">Selecione a Rifa</label>
                <select name="" id="" class="form-control" onchange="showHideReservas(this)">
                    <option value="0">Mostrar Todas</option>
                    @foreach ($rifas as $key => $rifa)
                        <option value="{{ $key }}">{{ $rifa }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row" style="margin-bottom: 130px;">
            @foreach ($reservas as $reserva)
                <div class="col-md-7 row-rifa rifa-{{ $reserva->rifa()->id }}" style="margin-bottom: 20px;">
                    <div class="card" style="border: none;background: #020f1e;">
                        <div class="card-body" style="background-color: #020f1e;">
                            <h5 class="card-title" style="color: #fff;"><i class="bi bi-cash"></i> Informações da Reserva
                            </h5>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td style="color: #fff;">Participante:
                                            {{ $reserva->name }}</td>
                                        <td style="color: #fff;"></td>
                                    </tr>
                                    <tr>
                                        <td style="color: #fff;">Telefone:
                                            {{ $reserva->telephone }}</td>
                                        <td style="color: #fff;"></td>
                                    </tr>
                                    <tr>
                                        <td style="color: #fff;">Status:
                                            {!! $reserva->statusBadge() !!}</td>
                                        <td style="color: #fff;"></td>
                                    </tr>
                                    @if ($reserva->pagos > 0)
                                        <tr>
                                            <td style="color: #fff;">
                                                Meu(s) bilhete(s) pago(s):
                                                {{ $reserva->pagos + $reserva->reservados }} COTAS
                                                <div id="div-cotas" class="mt-2" style="max-height: 200px;overflow: auto;">
                                                    @if ($reserva->rifa()->modo_de_jogo == 'numeros')
                                                        @foreach ($reserva->pagos() as $numPago)
                                                            <span class="badge text-bg-success" style=""><i
                                                                    class="fa fa-check"></i> {{ $numPago }} </span>
                                                        @endforeach
                                                    @else
                                                        @foreach ($reserva->pagos() as $numPago)
                                                            <span class="badge text-bg-success" style=""><i
                                                                    class="fa fa-check"></i> {{ $numPago->grupoFazendinha() }} </span>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>    
                                    @else
                                        <tr>
                                            <td style="color: #fff;">
                                                Meu(s) bilhete(s) aguardando pagamento: {{ $reserva->reservados }} COTAS<br><br>
                                                @if ($reserva->rifa()->type_raffles == 'automatico')
                                                    Números serão gerados após o pagamento!
                                                @else
                                                    @foreach ($reserva->reservados() as $numRes)
                                                        <span class="badge text-bg-warning" style=""><i
                                                                class="fa fa-clock"></i> {{ $numRes }} </span>
                                                    @endforeach
                                                @endif

                                                @if ($reserva->qtdReservados() > 0)
                                                    <br>
                                                    <a href="{{ route('pagarReserva', $reserva->id) }}"
                                                        class="btn btn-sm btn-success mt-2">Pagar</a>
                                                @endif
                                            </td>
                                            <td></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-5 row-rifa rifa-{{ $reserva->rifa()->id }}" style="margin-bottom: 20px;">
                    <div class="card checkout" style="border: none;background: #020f1e;">
                        <div class="card-body" style="background-color: #020f1e;">
                            <h5 class="card-title" style="color: #fff;"><i class="bi bi-trophy"></i> Informações do Sorteio
                            </h5>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td style="color: #fff;">Sorteio:</td>
                                        <td style="color: #fff;">{{ $reserva->rifa()->name }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

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

        function showHideReservas(element) {
            var selected = element.value;
            document.querySelectorAll('.row-rifa').forEach((el) => {
                el.classList.add('d-none')
            });

            if(selected == 0){
                document.querySelectorAll('.row-rifa').forEach((el) => {
                    el.classList.remove('d-none')
                });
            }
            else{
                document.querySelectorAll(`.rifa-${selected}`).forEach((el) => {
                    el.classList.remove('d-none')
                });
            }
        }

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
