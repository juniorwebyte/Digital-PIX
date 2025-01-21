<div class="col-md-12 text-center">
    Sorteio: {{ $rifa->name }}
</div>

<form action="{{ route('informarGanhadores') }}" id="form-informar-ganhadores" method="POST">
    @csrf
    <input type="hidden" name="idRifa" value="{{ $rifa->id }}">
    <div class="row">
        @foreach ($rifa->premios()->where('descricao', '!=', '') as $premio)
            <div class="col-md-12 mt-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{ $premio->ordem }} º</span>
                    </div>
                    <input type="text" min="0" max="{{ $rifa->qtd - 1 }}" placeholder="Informe o numero da cota - {{ $premio->descricao }}" class="form-control" name="cotas[{{ $premio->ordem }}]" required>
                </div>
            </div>
        @endforeach
    </div>

    <button class="btn btn-sm btn-success mt-2 float-right">Definir Ganhadores</button>
</form>