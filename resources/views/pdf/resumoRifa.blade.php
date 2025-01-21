<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Resumo Rifa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <style>
        .quadro {
            width: 25%;
            border: solid;
            border-width: thin;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            color: white;
            font-weight: bold;
        }

        .f-12 {
            font-size: 12px;
        }
    </style>
    <style>
        @page {
            size: A4
        }
    </style>
</head>

<body>
    <center>
        <h3>{{ $participante->rifa()->name }}</h3>
    </center>
    <br>

    <div style="width: 90% !important;">
        <div class="row">
            <div class="col-md-4">
                <label>
                    <strong>Nome: </strong> {{ $participante->name }}
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label>
                    <strong>Telefone: </strong> {{ '(**) ***** - ' . substr($participante->telephone, -4) }}
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label>
                    <strong>Status: </strong> {{ $participante->reservados > 0 ? 'Reservado' : 'Pago' }}
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label>
                    <strong>Cotas </strong>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4" style="max-width: 100%;">
                <label>
                    @foreach ($participante->numbers() as $key => $number)
                    @if ($key > 0)
                        , 
                    @endif
                        {{ $number }}
                        {{-- <span class="badge bg-success"> {{ $number }}</span> --}}
                    @endforeach
                </label>
            </div>
        </div>
    </div>
</body>

</html>
