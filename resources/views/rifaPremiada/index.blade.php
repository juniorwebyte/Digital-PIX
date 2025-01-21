@extends('layouts.admin')

@section('content')
    <div class="container mt-3" style="max-width:100%;min-height:100%;">
        <div class="table-wrapper ">
            <div class="table-title">
                <div class="row mb-3">
                    <div class="col d-flex justify-content-center">
                        <h2>Cota <b>Premiada</b></h2>
                    </div>
                </div>
            </div>
        </div>

        <select class="form-control block" onchange="selecionarRifa(this)">
            <option value="0">Selecione a rifa desejada</option>
            @foreach ($rifas as $rifa)
                <option value="{{ $rifa->id }}">{{ $rifa->name }}</option>
            @endforeach
        </select>

        <span id="conteudo"></span>
    </div>

    <script>
        function selecionarRifa(el) {
            $('#conteudo').html('')

            if(el.value == 0) return;
            
            loading();
            $.ajax({
                url: "{{ route('selecionarRifa') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    "id": el.value
                },
                success: function(response) {
                    loading()
                    if (response.html) {
                        $('#conteudo').html(response.html)
                        $('#cota-busca').focus();
                    }
                },
                error: function(error) {
                    loading()
                }
            })
        }
    </script>
@endsection
