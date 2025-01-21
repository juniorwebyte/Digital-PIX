<!-- Stored in resources/views/layouts/master.blade.php -->

<html lang="pt-br">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ asset('/css/app-original-2.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Language" content="pt-br">

    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">

    <meta name="color-scheme" content="light only">
    <meta name="X-DarkMode-Default" value="false" />

    @yield('ogContent')


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- Fontawesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- jQuery 1.8 or later, 33 KB -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>



    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <!-- Fotorama from CDNJS, 19 KB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>

    <!--<script defer src="{{ mix('js/app.js') }}"></script>
    <script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>-->

    <title><?php echo @$data['social']->name; ?> @yield('title')</title>

    @if (env('APP_ENV') == 'local')
    @else
        <meta name="facebook-domain-verification" content="<?php echo @$data['social']->verify_domain_fb; ?>" />

        <?php echo @$data['social']->pixel; ?>
    @endif

    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <script>
        const mp = new MercadoPago("<?php echo @$data['social']->key_pix_public; ?>");
    </script>
</head>

<body>
    @section('sidebar')
    @show

    <?php
    $subDomain = explode('.', request()->getHost());
    ?>


    <nav class="navbar navbar-expand-lg  fixed-top px-0 py-3 " style="background-color:#000;">

        <div class="container" style="justify-content:space-evenly;align-items: center;">
            <div class="row">
                <!-- Logo -->
                <a class="" href="{{ route('inicio') }}"
                    style="margin-left:20px;color: #ffffff!important;font-family: 'Roboto Condensed', sans-serif;">
                    @if (@$data['social']->logo)
                        <img src="{{ asset('products/' . @$data['social']->logo) }}" alt="" width="100"
                            height="50">
                    @else
                        Agency Rauen
                    @endif
                </a>
            </div>
            <!-- Carrinho Icon -->
            <div class="">
                <a data-bs-toggle="modal" data-bs-target="#consultar-reservas" class="btn btn-link"
                    style="width: 100%;margin-left: 0px;">
                    <i class="bi bi-cart-check"
                        style="color: #dfdfdf;font-size: 25px;margin-left: 100px; cursor:pointer;"></i>
                </a>
            </div>
            <!-- Navbar toggle -->
            <!--<span ><i class="bi bi-cart4" style="font-size:30px;margin-left:80px;margin-right:10px;color: #dfdfdf;"></i></i></i></span>-->
            <div class="row">
                <button class="navbar-toggler mr-3 " type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span><i class="bi bi-filter-right" style="color:#dfdfdf;font-size:40px;"></i></span>
                </button>
            </div>


            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <!-- Nav -->
                <div class="navbar-nav mx-lg-auto" style="margin-left:20px">
                    <a class="nav-item nav-link active" style="color:#dfdfdf!important;" href="{{ route('inicio') }}"
                        aria-current="page"><i class="bi bi-phone-flip" style="color:#dfdfdf;"></i> Home</a>
                    <a class="nav-link" href="{{ route('inicio') }}" style="color:#dfdfdf!important;"><i
                            class="bi bi-calendar3" style="color:#dfdfdf;"></i> SORTEIOS <span
                            class="sr-only">(current)</span></a>
                    <a class="nav-link" href="{{ route('ganhadores') }}" style="color:#dfdfdf!important;"><i
                            class="bi bi-calendar3" style="color:#dfdfdf;"></i> GANHADORES</a>
                    <a class="nav-link" href="{{ route('terms') }}" style="color:#dfdfdf!important;"><i
                            class="bi bi-file-text" style="color:#dfdfdf;"></i> Termos e condições de uso</a>

                </div>

                {{-- <div class="col" style="display:flex;"> --}}
                {{-- Whatsapp --}}
                {{-- <a class="nav-item nav-link active" href="#" aria-current="page"><i class="fab fa-whatsapp fa-2x " style="color: #25d366;"></i></a> --}}
                {{-- Youtube --}}
                {{-- <a class="nav-item nav-link active" href="#" aria-current="page"> <i class="fab fa-youtube fa-2x ml-3" style="color: #ed302f;"></i></a> --}}
                {{-- Instagram --}}
                {{-- <a class="nav-item nav-link active" href="#" aria-current="page"> <i class="fab fa-instagram fa-2x ml-3" style="color: #C13584;"></i></a> --}}
            </div>

            {{-- Action --}}
            {{-- <div class="d-flex align-items-lg-center mt-3 mt-lg-0 ml-3">
        <a href="#" class="btn btn-lg btn-success w-full w-lg-auto">
          Adiquirir o Sistema
        </a>
      </div> --}}

        </div>
        </div>
    </nav>
    <div class="row  d-flex mt-5">
        <!--<a href="https://api.whatsapp.com/send/?phone=5511916059141" id="btn-ctt-whatsapp" style="margin-top: 5px;" target="_blank" class="visible"><label id="wa_msg_ctt"><i class="bi bi-whatsapp"></i></label></a>

       <a href="https://chat.whatsapp.com/EjrmnV9LpMG8DJxivu" id="btn-ctt-whatsapp" target="_blank" class="visible"><label id="wa_msg_ctt"><i class="bi bi-whatsapp"></i> GRUPO</label></a>

       @if (@$data['social']->group_whats == null)
@else
<a href="<?php echo @$data['social']->group_whats; ?>" style="right: 2px;
    bottom: 0;
    position: fixed;
    margin: 11px;  z-index: 100;  background-color: #28a745;
    padding: 8px 8px;
    font-size: 16px;
    color: #fff;
    line-height: 14px;
    border-radius: 8px 8px 8px 8px;
    text-align: center;
    font-weight: bold;" data-toggle="tooltip" data-placement="top" title="Whatsapp"><i class="bi bi-whatsapp" style="font-size: 2rem; color: #fff;"></i></a>
@endif

       <a href="https://t.me/+kseyi6M41Jhh" style="right: 0;
    bottom: 0;
    position: fixed;
    margin: 11px;  z-index: 100;" data-toggle="tooltip" data-placement="top" title="Grupo Telegram"><i class="bi bi-telegram" style="font-size: 3rem; color: #2EA3D4;"></i></a>-->
    </div>

    <!-- Modal  consultar -->
    <div class="modal fade" id="consultar-reservas" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" style="z-index: 9999999;">
        <div class="modal-dialog">
            <div class="modal-content" style="border: none;">
                <div class="modal-header" style="background-color: #020f1e;">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: #fff;">CONSULTAR RESERVAS</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                        style="color: #fff;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background-color: #020f1e;">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('minhasReservas') }}" method="POST" style="display: flex;">
                                {{ csrf_field() }}
                                <input type="text" name="telephone" id="telephone"
                                    style="background-color: #fff;border: none;color: #000000;margin-right:5px;"
                                    aria-describedby="passwordHelpBlock" maxlength="15" placeholder="Celular com DDD"
                                    class="form-control" required>
                                <button type="submit" class="btn btn-danger">Buscar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @yield('content')

    <div id='app'
        style="    color: #fff;
    width: 210px;
    text-align: center;
    position: fixed;
    bottom: 0;
    border-radius: 10px;
    padding: 10px;
    margin: 10px;">
        <example-component />
    </div>







    @if (@$data['social']->footer == null)
        <footer class="footer"
            style="height:auto;background-color: #000;margin-top:0px!important; padding-top: 10px; padding-bottom: 10px;">
            <div class="container" style="text-align: center; padding-top: 5px;padding-bottom: 5px;">
                <!-- Facebook -->
                <a class="btn btn-primary" style="background-color: #2760AE;border: none;font-size: 20px;"
                    href="https://www.facebook.com/{{ @$data['social']->facebook }}" target="_blank"
                    rel="noreferrer noopener" role="button"><i class="bi bi-facebook"></i></a>
                <!-- Instagram -->
                <a class="btn btn-primary" style="background-color: #CF235F;border: none;font-size: 20px;"
                    href="https://www.instagram.com/{{ @$data['social']->instagram }}" target="_blank"
                    rel="noreferrer noopener" role="button"><i class="bi bi-instagram"></i></a>
                <!-- Whatsapp -->
                <a class="btn btn-primary" style="background-color: #25d366;border: none;"
                    href="https://api.whatsapp.com/send?phone={{ @$data['user']->telephone }}" target="_blank"
                    rel="noreferrer noopener" role="button"><i class="bi bi-whatsapp"
                        style="font-size: 20px;"></i></a>
                @if (env('FOOTER_CLIENTE'))
                    <br>
                    <a href="https://api.whatsapp.com/send?phone=5514998977909" target="_blank" style="text-decoration: none"><span class="text-muted" style="color: #fff!important; font-size: 12px;">Desenvolvido por Fácil Script</span></a>
                @endif
            </div>
        </footer>
    @else
        <footer class="footer " style="height:auto;background-color: #000;margin-top:0px!important;">
            <div class="container" style="text-align: center; padding-top: 5px;padding-bottom: 5px;">
                <span class="text-muted" style="color: #fff!important;">{{ @$data['social']->footer }}</span>
                @if (env('FOOTER_CLIENTE'))
                    <br>
                    <a href="https://api.whatsapp.com/send?phone=5514998977909" target="_blank" style="text-decoration: none"><span class="text-muted" style="color: #fff!important; font-size: 12px;">Desenvolvido por Fácil sript</span></a>
                @endif
            </div>
        </footer>
    @endif

    <script>
        document.getElementById('telephone').addEventListener('input', function(e) {
            var aux = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
            e.target.value = !aux[2] ? aux[1] : '(' + aux[1] + ') ' + aux[2] + (aux[3] ? '-' + aux[3] : '');
        });

        document.getElementById('telephone1').addEventListener('input', function(e) {
            var aux = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
            e.target.value = !aux[2] ? aux[1] : '(' + aux[1] + ') ' + aux[2] + (aux[3] ? '-' + aux[3] : '');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>
