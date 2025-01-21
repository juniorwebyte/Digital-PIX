<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detalhes Compra</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #printable,
            #printable * {
                visibility: visible;
            }

            #printable {
                position: fixed;
                left: 0;
                top: 0;
            }
        }
    </style>
</head>

<body>
    <div id="printable" style="width: 100%">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <div class="row mt-4">
            <div class="col-md-6">
                <label>Nome</label> <br>
                <span>{{ $participante->name }}</span>
            </div>
            <div class="col-md-6">
                <label>Email</label> <br>
                <span>{{ $participante->email }}</span>
            </div>
        </div>
    
        <div class="row mt-4">
            <div class="col-md-12">
                <label>Telefone</label> <br>
                <a style="text-decoration: none; color: #000" target="_blank"
                    href="{{ $participante->linkWpp() }}"><span>{{ $participante->telephone }}</span></a>
            </div>
        </div>
    
        <div class="row mt-4">
            <div class="col-md-12">
                <label>Sorteio</label> <br>
                <span>{{ $participante->rifa()->name }}</span>
            </div>
        </div>
    
        <hr>

        <div class="row mt-4">
            <div class="col-md-4">
                <label>Subtotal</label> <br>
                <span>R$ {{ number_format($participante->valor, 2, ',', '.') }}</span>
            </div>
    
            <div class="col-md-4">
                <label>Desconto</label> <br>
                <span>R$ 0,00</span>
            </div>
    
            <div class="col-md-4">
                <label>Subtotal</label> <br>
                <span>R$ {{ number_format($participante->valor, 2, ',', '.') }}</span>
            </div>
    
            <div class="col-md-4 mt-4">
                <label>Situação da compra</label> <br>
                <span>{{ $participante->status() }}</span>
            </div>
        </div>

        <hr>
    
        <div class="raffles mt-2">
            <label>Cotas</label> <br>
            <div id="div-cotas" style="max-height: 200px;overflow: auto;">
                @if ($participante->pagos > 0)
                    @foreach ($participante->numbers() as $number)
                        <span class="badge"> <i class="fa fa-check"></i> {{ $number }}</span>
                    @endforeach
                @else
                    @foreach ($participante->numbers() as $number)
                        <span class="badge"> <i class="fa fa-clock"></i> {{ $number }}</span>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</body>

</html>

<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script>
    $(document).ready(function() {

        window.print();

        const print = function() {
            window.print();
        }

        window.addEventListener("afterprint", function(event) {
            window.close()
        });

    });
</script>
