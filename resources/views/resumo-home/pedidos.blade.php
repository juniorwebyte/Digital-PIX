@extends('layouts.admin')

<style>
    .item-compra {
        border: 1px solid;
        color: white;
        /* background-color: grey; */
        border-radius: 5px;
        /* border-radius: 10px; */
    }

    .reservado {
        background-color: rgb(68, 124, 170);
    }

    .pago {
        background-color: rgb(17, 109, 17);
    }

    .qtd-livres {
        padding-left: 10px !important;
        padding-right: 10px !important;
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
    }

    .qtd-pagos {
        padding-left: 10px !important;
        padding-right: 10px !important;
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
    }

    .qtd-reservas {
        padding-left: 10px !important;
        padding-right: 10px !important;
    }

    .info-qtd {
        cursor: pointer;
    }
</style>

@section('content')
    <div class="container" style="max-width:100%;min-height:100%;">
        <div class="col-md-12 text-center">
            <h4>Resumo Pedidos</h4>
            <h6>Participantes: {{ $participantes->count() }}</h6>
            <h6>Total de Cotas: {{ $participantes->sum('pagos') + $participantes->sum('reservados') }}</h6>
            <h6>Total: R$ {{ number_format($participantes->sum('valor'), 2, ",", ".") }}</h6>
        </div>


        @foreach ($participantes as $participante)
            <div class="row p-1 item-compra {{ $participante->pagos > 0 ? 'pago' : 'reservado' }}">
                <div class="col-md-1">
                    <img class="rounded" src="/products/{{ $participante->rifa()->imagem()->name }}" width="80">
                </div>
                <div class="col-md-6 d-flex align-items-center">
                    <label>
                        <span class="bg-success">Rifa:</span> {{ $participante->rifa()->name }} <br>

                        <span class="bg-success">Participante:</span> {{ $participante->name }}

                    </label>
                </div>
                <div class="col-md-4 d-flex align-items-center">
                    <span>
                        {{ count($participante->numbers()) }} Cotas <br>
                        R$ {{ number_format($participante->valor, 2, ',', '.') }}
                    </span>
                </div>
            </div>
        @endforeach

        {{ $participantes->links() }}
    </div>
@endsection
