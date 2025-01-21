<div class="card mt-3"
    style="border: none;border-radius: 10px;background-color: #f1f1f1;;height:auto;padding:10px;margin-bottom: 100px;">
    @if ($productModel->premios()->where('descricao', '!=', '')->where('ganhador', '!=', '')->count() == 0)
        <h2 style="text-align: center">
            Aguardando Sorteio!
        </h2>
    @else
        <h2 style="text-align: center">
            Rifa Finalizada!
        </h2>
    @endif



    @if (env('APP_URL') == 'agencyrauen.com')
        <h4>
            Aguardando sorteio pela loteria federal
        </h4>
    @endif

    @if ($productModel->premios()->where('descricao', '!=', '')->where('ganhador', '!=', '')->count() > 0)
        <h1 class="mt-3" id="ganhadores">
            🎉 Ganhadores
        </h1>
        @foreach ($productModel->premios()->where('descricao', '!=', '') as $premio)
            <div class="row mt-2 ">
                <div class="col-md-4">
                    <label><strong>Prêmio {{ $premio->ordem }}:
                        </strong>{{ $premio->descricao }}</label>
                </div>
                <div class="col-md-4">
                    <label><strong>Ganhador: </strong>{{ $premio->ganhador }}</label>
                </div>
                <div class="col-md-4">
                    <label><strong>Cota: </strong>{{ $premio->cota }}</label>
                </div>
            </div>
        @endforeach
    @endif
</div>
