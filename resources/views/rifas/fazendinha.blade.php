{{-- <div class="d-flex justify-content-between font-weight-600 mb-4">
    <div class="seletor-item rounded d-flex justify-content-between box-shadow-08 font-xs" style="cursor: pointer" onclick="showNumbersFazendinha('disponivel')">
        <div class="nome bg-white rounded-start text-dark p-2">
            Livres
        </div>
        <div class="num bg-success text-white p-2 rounded-end">
            {{ $totalDispo }}
        </div>
    </div>

    <div class="seletor-item rounded d-flex justify-content-between box-shadow-08 font-xs" style="cursor: pointer" onclick="showNumbersFazendinha('reservado')">
        <div class="nome bg-white rounded-start text-dark p-2">
            Reserv
        </div>
        <div class="num bg-warning text-white p-2 rounded-end">
            {{ $totalReser }}
        </div>
    </div>

    <div class="seletor-item rounded d-flex justify-content-between box-shadow-08 font-xs" style="cursor: pointer" onclick="showNumbersFazendinha('pago')">
        <div class="nome bg-white rounded-start text-dark p-2">
            Pagos
        </div>
        <div class="num bg-info text-white p-2 rounded-end">
            {{ $totalPago }}
        </div>
    </div>
</div> --}}

<style>
    .grupo-fazendinha {
        cursor: pointer;
        width: 25%;
        height: 150px;
        background-size: cover;
        /* margin-left: 10px !important; */
        margin-top: 5px;
    }

    @media (max-width: 768px) {
        .grupo-fazendinha {
            height: 100px !important;
        }

        .pago{
            height: 100%;
        }

        .reservado{
            height: 100%;
        }
    }

    .reservado {
        background-color: #ffc10775;
        width: 100%;
        height: 90%;
    }

    .pago {
        background-color: #0094f0b3;
        width: 100%;
        height: 90%;
    }

    .selected-group {
        opacity: 0.5;
    }

    .h150 {
        height: 150px;
        background-size: 50%;
        background-repeat: no-repeat
    }
</style>

<div class="font-weight-600 mb-4 d-flex text-center justify-content-center" style="flex-wrap: wrap">
    @foreach ($productModel->numbers() as $numero)
        @if ($numero->statusFormated() == 'disponivel')
            <div class="grupo-fazendinha {{ 'fazenda-'. $numero->statusFormated() }}" data-grupo="{{ $numero->grupoFazendinha() }}"
                onclick="selectFazendinha('{{ $numero->number }}')" id="{{ $numero->number }}"
                style="background-image: url('{{ asset('images/bixos/' . $numero->number . '.webp') }}'); background-size: 100%;background-repeat: no-repeat">
            </div>
        @else
            <div title="{{ $numero->status }} por {{ $numero->participante()->name }}" onclick="info('{{ $numero->status }} por {{ $numero->participante()->name }}')" class="grupo-fazendinha {{ 'fazenda-'. $numero->statusFormated() }}" data-grupo="{{ $numero->grupoFazendinha() }}" id="{{ $numero->number }}"
                style="background-image: url('{{ asset('images/bixos/' . $numero->number . '.webp') }}'); background-size: 100%;background-repeat: no-repeat">
                <div class="{{ $numero->statusFormated() }}"></div>
            </div>
        @endif
        
    @endforeach
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
                                    style="border: none;color: #fff;font-weight: bold;width: 100%;background-color: green"
                                    data-toggle="modal" onclick="openModalCheckout()"><i
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


<br><br><br>

<script>
    function info(msg){
        Swal.fire(msg)
    }
</script>
