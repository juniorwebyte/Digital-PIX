@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @foreach ($pagamentos as $pagamento)
                    <p>{{ $pagamento->participante()->name }}</p>
                @endforeach
            </div>
        </div>
    </div>
@endsection