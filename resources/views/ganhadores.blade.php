@extends('layouts.app')

<link rel="manifest" href="/manifest.json">
<script type="text/javascript" src="sw.js"></script>

<style>
    body {
        /*background-color: #181818 !important;*/
        /*background-color: #132439 !important;*/
        background-color: #000 !important;
        background-size: cover;
        width: 100%;
        background-position: bottom;
        background-repeat: no-repeat;
        padding-top:40px;


        /*background-image: url('images/background-asfalto.jpg');*/
    }
</style>


@section('title', 'Page Title')


@section('sidebar')

@stop



@section('content')
    <div class="container rounded-top-5" id="" style="background-color:#e3e3e3;padding-bottom:75px;min-height: 100vh;" >
        @if(!empty($winners[0]))
            <h1 class="mt-3" id="ganhadores">
               🎉 Ganhadores
               <small class="text-muted" style="font-size: 15px;">sortudos</small>
            </h1>

            <div class="container">

                @foreach($winners as $winner)

                    <div class="row mt-1" style="background-color: #fff;padding: 5px;border-radius: 20px;color: #000;">
                        <div class="col-2" style="justify-content: center;align-items: center;text-align: center;display: flex;border: 1px green solid; border-radius: 15px;">
                            <a href="{{route('product', ['id' => $winner->id])}}">
                                <img src="images/sem-foto.jpg" class="" alt="{{$winner->name}}" style="min-height: 50px;max-height: 20px;border-radius:10px;">
                            </a>
                        </div>
                        <div class="col-8">
                            {!!$winner->winner!!}<br>
                            Sorteio: <a href="{{route('product', ['id' => $winner->id])}}" style="color:#28a745">{{$winner->name}}</a>
                        </div>
                        <div class="col-2" style="justify-content: center;align-items: center;text-align: center;display: flex;">
                            <a href="{{route('product', ['id' => $winner->id])}}">
                                <img src="{{ asset('products/' . $winner->imagem()->name) }}" class="" alt="{{$winner->name}}" style="min-height: 50px;max-height: 20px;border-radius:250px;">
                            </a>
                        </div>
                    </div>

                @endforeach

            </div>
        @endif
        @include('layouts.footer')
    </div>

@stop