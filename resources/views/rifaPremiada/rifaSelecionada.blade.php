{{-- <div class="row mt-2">
    <div class="col-md-12 text-center">
        <img class="rounded" width="150" src="{{ asset('products') . '/' . $rifa->imagem()->name }}">
    </div>
    <input type="hidden" id="idRifa" value={{ $rifa->id }}>
</div>

<div class="row d-flex justify-content-center mt-1">
    <div class="col-md-2">
        <input type="text" class="form-control" id="cota-busca" placeholder="Cota">
        <button onclick="buscarCota()" class="btn btn-info btn-block mt-1" type="button"><i
                class="fas fa-search"></i>&nbsp;Buscar</button>
    </div>
</div> --}}

<div class="row d-flex justify-content-center mt-1">
    <div class="card" style="width: 18rem;">
        <img class="rounded mt-2" src="{{ asset('products') . '/' . $rifa->imagem()->name }}">
        <input type="hidden" id="idRifa" value={{ $rifa->id }}>
        <div class="card-body text-center">
            <input type="text" class="form-control" id="cota-busca" placeholder="Buscar Cota Premiada">
            <button onclick="buscarCota()" class="btn btn-info btn-block mt-1" type="button"><i
                    class="fas fa-search"></i>&nbsp;Buscar</button>
            <div class="mt-2">
                <span id="resultado-busca" style="font-size: 20px;"></span>
            </div>
        </div>
    </div>
</div>

<script>

    $('#cota-busca').on('keydown', function(e) {
        if(e.keyCode == 13) buscarCota();
    });

    function buscarCota() {
        var id = $('#idRifa').val();
        var cota = $('#cota-busca').val();
        $('#resultado-busca').html('')
        loading();
        $.ajax({
            url: "{{ route('buscarCotaPremiada') }}",
            type: 'POST',
            dataType: 'json',
            data: {
                "id": id,
                "cota": cota
            },
            success: function(response) {
                loading()
                $('#resultado-busca').html(response.html)
                $('#cota-busca').select();
                // if (response == 0) {
                //     $('#resultado-busca').html('Cota não encontrada!')
                //     $('#cota-busca').select();
                // } else {
                //     $('#resultado-busca').html(`<strong>Ganhador: ${response.name}</strong>`)
                //     $('#cota-busca').select();
                // }
            },
            error: function(error) {
                loading()
            }
        })
    }
</script>
