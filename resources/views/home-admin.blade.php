@extends('layouts.admin')


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@section('content')
    <style>
        .dashboard-itens {
            display: flex;
            justify-content: space-between;
        }

        .dashboard-item {
            position: relative;
            width: 23%;
            height: 135px;
            background-color: #292727;
            border-radius: 10px;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .dashboard-itens {
                flex-direction: column;
            }

            .dashboard-item {
                width: 100%;
                margin-bottom: 20px;
            }
        }



        .dashboard-item.profit {
            background-color: #0966cf73;
            border: 1px solid #0966cf73;
        }

        .dashboard-item.request {
            background-color: #234667;
            border: 1px solid #0e6495;
        }

        .dashboard-item.pending_request {
            background-color: #2e3b46;
            border: 1px solid #0e6495;
        }

        .dashboard-item.pending_entry {
            background-color: #1f3349;
            border: 1px solid #0e6495;
        }

        .dashboard-item-body {
            padding: 10px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            font-size: 1.5rem;
        }

        .dashboard-item-body p {
            margin-right: 10px;
            color: #f5f5f5;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;

        }

        .dashboard-item-body p:first-child {
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .dashboard-item-body p:nth-child(2) {
            font-size: 1.1rem;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .dashboard-item-body i {
            position: absolute;
            font-size: 6rem;
            top: 20px;
            right: 11px;
            opacity: .2;
            color: #fff;
        }

        .blink {
            margin-top: 5px;
            animation: animate 1.5s linear infinite;
        }

        @keyframes animate {
        0% {
            opacity: 0;
        }

        50% {
            opacity: 0.7;
        }

        100% {
            opacity: 0;
        }
    }
    </style>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Home</h1>
                    <h6>Clique no card para mais informações!</h6>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>



    <section class="content">
        <div class="container-fluid">
            <a href="{{ route('rifaPremiada') }}" class="btn btn-block btn-primary mb-2">COTA PREMIADA</a>
            <div class="dashboard-itens">
                <div class="dashboard-item profit block-copy">
                    <div class="dashboard-item-body">
                        <p>Afiliados</p>
                        <p>0</p>
                        <i class="fas fa-people-arrows blink"></i>
                    </div>
                </div>

                <div class="dashboard-item request block-copy" onclick="link('{{ route('resumo.rifasAtivas') }}')">
                    <div class="dashboard-item-body">
                        <p>Rifas Ativas</p>
                        <p>{{ $rifas->count() }}</p>
                        <i class="fa-solid fa-receipt blink"></i>
                    </div>
                </div>

                <div class="dashboard-item pending_request block-copy" onclick="link('{{ route('resumo.pendentes') }}')">
                    <div class="dashboard-item-body">
                        <p>Pedidos Pendentes</p>
                        <p>{{ $participantes->where('reservados', '>', 0)->count() }}</p>
                        <i class="fa-solid fa-hourglass blink"></i>
                    </div>
                </div>

                <div class="dashboard-item pending_entry block-copy" onclick="link('{{ route('resumo.ranking') }}')">
                    <div class="dashboard-item-body">
                        <p>Ranking</p>
                        {{-- <p>R$ {{ number_format($participantes->where('reservados', '>', 0)->sum('valor'), 2, ",", ".") }}</p> --}}
                        <i class="fas fa-medal blink"></i>
                    </div>
                </div>
            </div>
        </div>
        </div>
    @endsection

    <script>
        function link(url) {
            window.location.href = url;
        }
    </script>
