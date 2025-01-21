@extends('layouts.admin')

@section('content')
    <br><br>
    @foreach ($videos as $key => $video)
        @if ($key > 0)
            <hr><hr>
        @endif

        <div class="row d-flex justify-content-center text-center">
            <div class="col-md-12 justify-content-center text-center">
                <h6>{{ $video->title }}</h6>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $video->link }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
        </div>
    @endforeach
    {{-- <div class="row d-flex justify-content-center text-center">
        <div class="col-md-12 justify-content-center text-center">
            <h6>Conhecendo o Painel Administrativo</h6>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/JgyfWB-E" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>
    </div>

    <hr>
    <hr>

    <div class="row d-flex justify-content-center text-center">
        <div class="col-md-12 justify-content-center text-center">
            <h6>Como Definir Ganhador Pelo Número Da Loteria Federal</h6>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/hxDW8T0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>
    </div> --}}

    <br><br><br>
@endsection