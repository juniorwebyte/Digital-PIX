@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="title">
            <h3><i class="fas fa-people-arrows"></i> ÁREA DE AFILIADOS</h3>
        </div>
        <div class="sub-title">NOVO CADASTRO!</div>


        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $error }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endforeach
        @endif



        <form class="form-signin" method="POST" action="{{ route('afiliado.novo') }}" style="text-align: center;">
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-6">
                    <label>Nome</label>
                    <input type="text" name="nome" value="{{ old('nome') }}" required class="form-control">
                </div>
                <div class="col-md-6">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label>CPF</label>
                    <input type="text" name="cpf" value="{{ old('cpf') }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label>Chave Pix</label>
                    <input type="text" name="pix" value="{{ old('pix') }}" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label>Senha</label>
                    <input type="password" name="senha" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Confirmar Senha</label>
                    <input type="password" name="conf_senha" class="form-control" required>
                </div>
            </div>

            <div class="form-group mt-4">
                <div class="">
                    <button type="submit" class="btn btn-success">
                        Cadastrar
                    </button>
                </div>
                <a class="btn btn-link" href="{{ route('afiliado.home') }}">
                    Já possui cadastro ?
                </a>
            </div>

        </form>
    </div>
@endsection
