@extends('layouts.admin')

@section('content')
    <div class="container mt-3" style="max-width:100%;min-height:100%;">
        <div class="table-wrapper ">
            <div class="table-title">
                <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-center">
                            <h2>Editar Cliente</b></h2>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label>Nome</label>
                            <input type="text" name="nome" value="{{ $cliente->nome }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label>Telefone</label>
                            <input type="text" name="telephone" id="telephone1" value="{{ $cliente->telephone }}"
                                class="form-control">
                        </div>
                    </div>

                    <button class="button btn-block btn-sm btn-success mt-3">Salvar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('telephone1').addEventListener('input', function(e) {
            var aux = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
            e.target.value = !aux[2] ? aux[1] : '(' + aux[1] + ') ' + aux[2] + (aux[3] ? '-' + aux[3] : '');
        });
    </script>
@endsection
