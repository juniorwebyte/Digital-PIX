@extends('layouts.app')

<link rel="manifest" href="/manifest.json">
<script type="text/javascript" src="sw.js"></script>

<script>
    function duvidas(){
        window.open('https://api.whatsapp.com/send?phone={{ $user->telephone }}', '_blank');
    }
</script>

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

    @media (max-width: 768px) {
        .carousel {
            display: none !important;
        }
    }
</style>


@section('title', '')


@section('sidebar')

@stop



@section('content')



    <div class="container rounded-top-5" id="" style="background-color:#e3e3e3;padding-bottom:75px;" >
        <!-- START CARROUSEL LEX -->

        <div id="carouselExampleIndicators" class="carousel slide" style="margin-top:37px;" data-bs-ride="carousel">
            <div class="carousel-indicators" style="margin-bottom:0px!important;">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active mt-3  ">
                    <img src="./images/banner1.jpg" class="d-block w-100 rounded-top-5" alt="...">
                </div>
                <div class="carousel-item mt-3">
                    <img src="./images/banner2.jpeg" class="d-block w-100 rounded-top-5" alt="...">
                </div>
                <div class="carousel-item mt-3">
                    <img src="./images/banner1.jpg" class="d-block w-100 rounded-top-5" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <!-- END CARROUSEL LEX -->




        <div class="title" style="text-align:center;" id="card-rifas">
            <h3 style="color: #464444;margin-top:40px;">SORTEIOS <span style="color: #00cb2c;">EM ANDAMENTO</span></h3>
        </div>
        <div class="sub-title" style="color: #464444;margin-bottom: 20px!important;text-align:center;" id="card-rifas">Participe você pode ser o próximo ganhador!!!</div>

        <div class="row" id="card-rifas">
            @foreach($products as $product)
                @if($product->visible == 1)
                    @if($product->status == 'Ativo' OR $product->status == 'Agendado')
                        <div class="col-md-4">
                            <div class="card" style="margin-bottom: 25px;">
                                <a href="{{route('product', ['slug' => $product->slug])}}">
                                    <img src="/products/{{$product->imagem()->name}}" class="card-img-top" alt="{{$product->name}}" style="min-height: 250px;max-height: 250px;">
                                </a>
                                <div class="card-body" style="background-color: #fff;">
                                    <div class="ribbon"><span>{{$product->status}}</span></div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!--<h5 class="card-title">{{substr($product->name, 0, 24) . '...'}}</h5>-->
                                            <h5 class="card-title" style="color: #464444;font-weight: bold;">{{$product->name}}</h5>
                                        </div>
                                        <div class="col-md-12">
                                            <p class="card-text" style="color: #464444;">
                                                @if($product->status == 'Ativo')
                                                    R$: <span style="font-size: 24px;color: #464444;">{{$product->price}}</span>
                                                @elseif($product->status == 'Agendado')
                                                    <span style="font-size: 24px;color: #464444;">@if($product->draw_date != null)
                                                            Sorteio dia {{\Carbon\Carbon::parse($product->draw_date)->format('d/m/Y')}}
                                                        @endif
                                </span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    @if($product->status == 'Finalizado')
                                        <a href="{{route('product', ['slug' => $product->slug])}}" class="btn btn-success" style="width: 100%;color: #fff;
    background-color: #9c2526;
    border-color: #9c2526;">Ver Ganhador</a>
                                    @elseif($product->status == 'Agendado')
                                        <a href="{{route('product', ['slug' => $product->slug])}}" class="btn btn-success" style="width: 100%;color: #333;
    background-color: #f4f4f4;
    border-color: #f4f4f4;">Venda Encerrada</a>
                                    @else
                                        <a href="{{route('product', ['slug' => $product->slug])}}" class="btn btn-success blob" style="width: 100%;color: #fff;
    background-color: #05a936;
    border-color: #00cb2c;">Clique e Participe</a>
                                    @endif
                                </div>
                            </div>
                        </div>

                    @else

                    @endif
                @endif
            @endforeach
        </div>

        {{--START RIFA FAVORITA LEXLUTHOR--}}


        <div class="row" id="card-rifa-favorita">
            <h1 class="mt-1">
               ⚡ Prêmios
               <small class="text-muted" style="font-size: 15px;">Escolha sua sorte</small>
            </h1>
            @foreach($products as $product)
                @if($product->visible == 1)
                    @if($product->favoritar == 1)
                        @if($product->status == 'Ativo' OR $product->status == 'Agendado')
                            <div class="col-md-4">
                                <div class="card" style="border-radius: 15px;">
                                    <a href="{{route('product', ['slug' => $product->slug])}}">
                                        <img src="/products/{{$product->imagem()->name}}" class="card-img-top" alt="{{$product->name}}" style="min-height: 350px;;max-height: 350px;;">
                                    </a>
                                    <div class="card-body d-flex flex-row" style="align-items: center;justify-content: space-around; background-color: #fff;border-radius: 20px!important;">
                                        {{-- <div class="ribbon"><span>{{$product->status}}</span></div> --}}
                                        <div class="row d-flex flex-row">
                                            <div class="col-md-12">
                                                <!--<h5 class="card-title">{{substr($product->name, 0, 24) . '...'}}</h5>-->
                                                <h5 class="card-title" style="color: #464444; font-weight: 600; font-size: 15px;">{{$product->name}}</h5>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="card-text" style="color: #464444;">
                                                    @if($product->status == 'Ativo')
                                                        R$: <span style="font-size: 16px;color: #464444; font-weight: 600;">{{$product->price}}</span>
                                                    @elseif($product->status == 'Agendado')
                                                        <span style="font-size: 16px;color: #464444; ">@if($product->draw_date != null)
                                                                Sorteio dia {{\Carbon\Carbon::parse($product->draw_date)->format('d/m/Y')}}
                                                            @endif
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        @if($product->status == 'Finalizado')
                                            <a href="{{route('product', ['slug' => $product->slug])}}" class="" style="margin-top: 30px;"><span class="badge bg-success blob font-xsss">Ver Ganhador</span></a>
                                        @elseif($product->status == 'Agendado')
                                            <a href="{{route('product', ['slug' => $product->slug])}}" class="" style="margin-top: 30px;"><span class="badge bg-success blob font-xsss">Encerrada</span></a>
                                        @else
                                            
                                            <a href="{{route('product', ['slug' => $product->slug])}}" class="" style="margin-top: 30px;"><span class="badge bg-success blob font-xsss">Participe</span></a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        @else

                        @endif
                    @endif
                @endif
            @endforeach
        </div>




        {{--END RIFA FAVORITA LEXLUTHOR--}}

        {{--START SESSÃO DÚVIDAS--}}
        <div onclick="duvidas()" class="container d-flex duvida"  style="background-color: #ffffff5e;border-radius:10px;height: 60px;align-items: center;justify-content: center;margin-top:7px;">
            <div class="row" id="" style="height:60px;width:200px;border-radius:10px;align-items: center;justify-content:center;margin-left: 55px;" >
                <div class="d-flex" style="width:50px;justify-content:center;align-items:center;background-color:#b9b9b9;height:35px;border-radius:10px;text-align:center;font-size:20px">🤷</div>
                <div class="col" style="display:flex !important;flex-direction:column;justify-content:center">
                    <h6 class="mb-0 font-md" style="font-size:15px;">Dúvidas</h6>
                    <p class="mb-0  font-sm text-muted" style="font-size:12px;">Fale conosco</p>
                </div>
            </div>
        </div>
        {{--END SESSÃO DÚVIDAS--}}

        {{--START RIFAS MOBILE--}}

        <div class="container" id="card-rifa-mobile" style="margin-bottom:0px;">
            @foreach($products as $product)
                @if($product->visible == 1)
                    @if($product->favoritar == 0)
                        @if($product->status == 'Ativo' OR $product->status == 'Agendado')
                            <div class="row" style="background-color: #fff;height: auto;border-radius: 10px;margin-top:7px;" >
                                <div class="col-4 d-flex" style="justify-content: center;align-items: center;">
                                    <a href="{{route('product', ['slug' => $product->slug])}}">
                                        <img src="/products/{{$product->imagem()->name}}" class="img" alt="{{$product->name}}" style="padding: 0px;
    border-radius: 15px;height:85px;width:100px;">
                                    </a>
                                </div>
                                <div class="col-8" style="padding:0px!important; display:grid; align-items: center" >
                                   <div class="row" style="padding:0px;margin:0px;">
                                        <p class="mt-1" style="padding:0px;margin:0px;font-weight: 400;font-size: 15px;line-height: 1;">{{$product->name}}</p>
                                   </div>
                                   <div class="row">
                                        <p class="text-muted" style="margin:0px;line-height: normal;">Sorteio será baseado na loteria</p>
                                   </div>
                                   <div class="row d-flex" style="padding:0px;margin:0px;padding-bottom: 5px;
}">
                                        <a href="{{route('product', ['slug' => $product->slug])}}" class="" style="margin-top: 0px;padding: 0px;"><span class="badge bg-success font-xsss">Participe</span></a>
                                   </div>
                                        
                                        
                                    </a>
                                </div>
                                
                            </div>
                        @endif
                    @endif
                @endif
            @endforeach

        </div>
        {{--END RIFAS MOBILE--}}
          
        @if(!empty($winners[0]))
            <h1 class="mt-3" id="ganhadores">
               🎉 Ganhadores
               <small class="text-muted" style="font-size: 15px;">sortudos</small>
            </h1>

            <div class="container">

                @foreach($winners as $winner)

                    <div class="row mt-1" style="background-color: #fff;padding: 5px;border-radius: 20px;color: #000;">
                        <div class="col-2" style="justify-content: center;align-items: center;text-align: center;display: flex;border: 1px green solid; border-radius: 15px;">
                            <a href="{{route('product', ['slug' => $product->slug])}}">
                                <img src="images/sem-foto.jpg" class="" alt="{{$product->name}}" style="min-height: 50px;max-height: 20px;border-radius:10px;">
                            </a>
                        </div>
                        <div class="col-8">
                            {!!$winner->winner!!}<br>
                            Sorteio: <a href="{{route('product', ['slug' => $winner->slug])}}" style="color:#28a745">{{$winner->name}}</a>
                        </div>
                        <div class="col-2" style="justify-content: center;align-items: center;text-align: center;display: flex;">
                            <a href="{{route('product', ['slug' => $product->slug])}}">
                                <img src="/products/{{$winner->imagem()->name}}" class="" alt="{{$product->name}}" style="min-height: 50px;max-height: 20px;border-radius:250px;">
                            </a>
                        </div>
                    </div>

                @endforeach

            </div>
        @endif
    </div>

@stop