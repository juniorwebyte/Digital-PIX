@extends('layouts.admin')
<div class="container bg-black" style="margin-top: 0px;">
    <div class="row">
        <div class="col-sm-8 bg-primary">
            <h4 style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: bold;text-shadow: 0 0 0.6em #2d3746, 0 0 0.6em #2d3746, 0 0 0.6em #2d3746;">{{$product[0]->name}}</h4>
            <!-- Facebook -->
            <a class="btn btn-primary" style="background-color: #3b5998;width: 50px;" href="#!" role="button"><i class="fab fa-facebook-f" style="font-size: 30px;"></i></a>
            <!-- Instagram -->
            <a class="btn btn-primary" style="background-color: #ac2bac;" href="#!" role="button"><i class="fab fa-instagram" style="font-size: 30px;"></i></a>
            <!-- Whatsapp -->
            <a class="btn btn-primary" style="background-color: #25d366;" href="#!" role="button"><i class="fab fa-whatsapp" style="font-size: 30px;"></i></a>
        </div>
        <div class="col-sm-4 bg-danger"></div>
    </div>
</div>
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Adicionar Sorteios</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-info">
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if (session()->has('success'))
                    <div class="alert alert-success">
                        <ul>
                            <li>{{ session('success') }}</li>
                        </ul>
                    </div>
                    @endif

                    <form action="{{route('addProduct')}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nome</label>
                                    <input type="text" class="form-control" name="name" placeholder="Exemplo: Fusca 88" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlFile1">Imagem</label>
                                    <input type="file" class="form-control-file" name="images[]" accept="image/*" multiple required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="exampleInputEmail1">Valor</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">R$:</span>
                                    </div>
                                    <input type="text" class="form-control" name="price" placeholder="Exemplo: 10,00" maxlength="6" id="price" onkeyup="formatarMoeda()" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Quantidade de números</label>
                            <input type="number" class="form-control" name="numbers" min="1" max="99999" placeholder="Exemplo: 10" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Descrição do Sorteio</label>
                            <textarea class="form-control" id="summernote" name="description" rows="3" required></textarea>
                        </div>

                        <button type="submit" onClick="this.form.submit(); this.disabled=true; this.value='Cadastrando…';" class="btn btn-success">Publicar</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.col-->
    </div>
    <!-- ./row -->
</section>

<script>
    function formatarMoeda() {
        var elemento = document.getElementById('price');
        var valor = elemento.value;


        valor = valor + '';
        valor = parseInt(valor.replace(/[\D]+/g, ''));
        valor = valor + '';
        valor = valor.replace(/([0-9]{2})$/g, ",$1");

        if (valor.length > 6) {
            valor = valor.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
        }

        elemento.value = valor;
        if (valor == 'NaN') elemento.value = '';

    }
</script>
@endsection