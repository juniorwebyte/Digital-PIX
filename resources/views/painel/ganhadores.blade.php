@extends('layouts.admin')

@section('content')
    <div class="container mt-3" style="max-width:100%;min-height:100%;">
        <div class="col d-flex justify-content-center">
            <h2>Ganhadores</h2>
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

        @if (session()->has('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{{ session('success') }}</li>
                </ul>
            </div>
        @endif

        <form action="{{ route('ganhador.addFoto') }}" method="POST" enctype="multipart/form-data" id="form-foto" class="d-none">
            @csrf
            <input type="text" name="idGanhador" id="idGanhador">
            <input type="file" name="foto" id="btnFoto" accept="image/png, image/jpeg">
        </form>

        <table class="table table-striped table-bordered table-responsive-md table-hover align=center" id="table_rifas">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nome</th>
                    <th>Ação</th>
                    <th>Prêmio</th>
                    <th>Acões</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ganhadores as $ganhador)
                    <tr>
                        <td style="width: 50px;">
                            @if ($ganhador->foto)
                                <img src="{{ asset($ganhador->foto) }}" width="50">
                            @else
                                <img src="{{ asset('images/sem-foto.jpg') }}" width="50">
                            @endif
                        </td>
                        <td style="vertical-align: middle">{{ $ganhador->ganhador }}</td>
                        <td style="vertical-align: middle">{{ $ganhador->rifa()->name }}</td>
                        <td style="vertical-align: middle">{{ $ganhador->descricao }}</td>
                        <td style="vertical-align: middle">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-expanded="false">
                                    Ações
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" style="cursor: pointer" data-id="{{ $ganhador->id }}"
                                        onclick="alterarFoto(this)"><i class="bi bi-pencil-square"></i>&nbsp;Alterar
                                        Foto</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.7.0.min.js"
    integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script>
    function alterarFoto(el) {
        let idGanhador = el.dataset.id;
        $('#idGanhador').val(idGanhador)
        $('#btnFoto').click();
    }

    $(function(e) {
        document.getElementById("btnFoto").addEventListener("change", function() {
            $('#form-foto').submit()
        });
    })
</script>
