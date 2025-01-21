<div class="raffles mt-2">
    @foreach ($participante->numbers() as $reserva)
        <span class="badge bg-success"> <i class="fa fa-check"></i> {{ $reserva }}</span>
    @endforeach
</div>
