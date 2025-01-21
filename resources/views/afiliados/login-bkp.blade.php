@extends('layouts.app')

@section('content')
<div class="container">
    <div class="title">
        <h3><i class="fas fa-people-arrows"></i> ÁREA DE AFILIADOS</h3>
    </div>
    <div class="sub-title">Seja nosso afiliado!</div>

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

    <form class="form-signin" method="POST" action="{{ route('afiliado.login') }}" style="text-align: center;">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="col-md-4 control-label">E-Mail</label>

            <div class="col-md-12" style="max-width: 250px;
    display: block;
    margin-right: auto;
    margin-left: auto;">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="col-md-4 control-label">Senha</label>

            <div class="col-md-12" style="max-width: 250px;
    display: block;
    margin-right: auto;
    margin-left: auto;">
                <input id="password" type="password" class="form-control" name="password" required>

                @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="">
                <button type="submit" class="btn btn-primary">
                    Entrar
                </button>
            </div>
            <a class="btn btn-link" href="{{ route('afiliado.cadastro') }}">
                Se tornar afiliado
            </a>
        </div>

    </form>
</div>
@endsection