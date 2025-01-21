    <!-- Modal Editar Rifa -->
    <div id="modal_editar_rifa" class="modal fade">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('update', ['id' => $rifa->id]) }}" method="POST" enctype="multipart/form-data">
                <div class="modal-content">
                    @method('PUT')
                    {{ csrf_field() }}

                    <div class="modal-body">

                        <div class="container mt-3">
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                            <h2>Edita Rifa</h2>

                            <div class="row">
                                <div class="col-12">
                                    <nav>
                                        <ul class="nav nav-tabs" id="myTab" role="tablist" style="font-size: 12px;">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="geral-tab" data-toggle="tab"
                                                    href="#geral{{ $rifa->id }}" role="tab"
                                                    aria-controls="geral" aria-selected="true">Geral</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="premios-tab" data-toggle="tab"
                                                    href="#premios{{ $rifa->id }}" role="tab"
                                                    aria-controls="premios" aria-selected="true">Prêmios</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="ajustes-tab" data-toggle="tab"
                                                    href="#ajustes{{ $rifa->id }}" role="tab"
                                                    aria-controls="ajustes" aria-selected="false">Ajustes</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="promocao-tab" data-toggle="tab"
                                                    href="#promocao{{ $rifa->id }}" role="tab"
                                                    aria-controls="promocao" aria-selected="false">Promoção</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="fotos-tab" data-toggle="tab"
                                                    href="#fotos{{ $rifa->id }}" role="tab"
                                                    aria-controls="fotos" aria-selected="false">Fotos</a>
                                            </li>
                                        </ul>
                                    </nav>

                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active"
                                            id="geral{{ $rifa->id }}" role="tabpanel"
                                            aria-labelledby="geral-tab">
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <input type="hidden" name="product_id"
                                                        value="{{ $rifa->id }}">
                                                    <div class="form-group">
                                                        <label
                                                            for="exampleInputEmail1">Nome</label>
                                                        <input type="text" class="form-control"
                                                            name="name"
                                                            value="{{ $rifa->name }}">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <label for="exampleInputEmail1">Valor</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span
                                                                class="input-group-text">R$:</span>
                                                        </div>
                                                        <input type="text" class="form-control"
                                                            name="price"
                                                            value="{{ $rifa->price }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label
                                                            for="exampleInputEmail1">Sub Titulo</label>
                                                        <input type="text" class="form-control"
                                                            name="subname"
                                                            value="{{ $rifa->subname }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Qtd mínima de
                                                            compra</label>
                                                        <input type="number" class="form-control"
                                                            min="1" max="999999"
                                                            name="minimo"
                                                            value="{{ $rifa->minimo }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Qtd máxima de
                                                        compra</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control"
                                                            name="maximo"
                                                            value="{{ $rifa->maximo }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Tempo de expiração
                                                        (min)
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control"
                                                            name="expiracao" min="0"
                                                            value="{{ $rifa->expiracao }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row justify-content-center">
                                                <div class="col-md-6">
                                                    <label for="">Mostar Ranking de
                                                        compradores (Qtd)</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control"
                                                            name="qtd_ranking"
                                                            value="{{ $rifa->qtd_ranking }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label>Mostrar Parcial (%)</label>
                                                    <select name="parcial"class="form-control">
                                                        <option value="1"
                                                            {{ $rifa->parcial == 1 ? 'selected' : '' }}>
                                                            Sim</option>
                                                        <option value="0"
                                                            {{ $rifa->parcial == 0 ? 'selected' : '' }}>
                                                            Não</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mt-4">
                                                <div class="col-md-6">
                                                    <label>Gateway de Pagamento</label>
                                                    <select name="gateway"class="form-control">
                                                        <option value="mp" {{ $rifa->gateway == 'mp' ? 'selected' : '' }}>Mercado Pago</option>
                                                        <option value="paggue" {{ $rifa->gateway == 'paggue' ? 'selected' : '' }}>Paggue</option>
                                                        <option value="asaas" {{ $rifa->gateway == 'asaas' ? 'selected' : '' }}>ASAAS</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label>% de Ganho do Afiliado</label>
                                                    <input type="number" class="form-control" name="ganho_afiliado" value="{{ $rifa->ganho_afiliado }}">
                                                </div>
                                            </div>

                                            <div class="row mt-4">
                                                <div class="col-md-12">
                                                    <label>Descrição</label>
                                                    <textarea class="form-control summernote" name="description" id="desc-{{ $rifa->id }}" rows="10"
                                                        style="min-height: 200px;" required>{!! $rifa->descricao() !!}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade show"
                                            id="premios{{ $rifa->id }}" role="tabpanel"
                                            aria-labelledby="geral-tab">
                                            <div class="row">
                                                @foreach ($rifa->premios() as $premio)
                                                    <div class="col-md-6 mt-2">
                                                        <label>{{ $premio->ordem }}º Prêmio</label>
                                                        <input type="text" class="form-control" name="descPremio[{{ $premio->ordem }}]" value="{{ $premio->descricao }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="tab-pane fade"
                                            id="ajustes{{ $rifa->id }}" role="tabpanel"
                                            aria-labelledby="ajustes-tab">
                                            <div class="row mt-3">
                                                <div class="col-5">
                                                    <div class="form-group">
                                                        <label for="status_sorteio">Status
                                                            Sorteio</label>
                                                        <select class="form-control"
                                                            name="status" id="status">
                                                            <option value="Inativo"
                                                                {{ $rifa->status == 'Inativo' ? "selected='selected'" : '' }}>
                                                                Inativo</option>
                                                            <option value="Ativo"
                                                                {{ $rifa->status == 'Ativo' ? "selected='selected'" : '' }}>
                                                                Ativo</option>
                                                            <option value="Finalizado"
                                                                {{ $rifa->status == 'Finalizado' ? "selected='selected'" : '' }}>
                                                                Finalizado</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <form action="{{ route('drawDate') }}"
                                                    method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="product_id"
                                                        value="{{ $rifa->id }}">
                                                    <div class="col-12 col-md-7">
                                                        <div class="form-group">
                                                            <label for="data_sorteio">Data
                                                                Sorteio</label>
                                                            <input type="datetime-local"
                                                                class="form-control"
                                                                name="data_sorteio"
                                                                id="data_sorteio"
                                                                value="{{ $rifa->draw_date ? date('Y-m-d H:i:s', strtotime($rifa->draw_date)) : ''}}">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-sm">
                                                    <div class="form-group">
                                                        <label
                                                            for="cadastrar_ganhador">Ganhador</label>
                                                        <input type="text" class="form-control"
                                                            name="cadastrar_ganhador"
                                                            id="cadastrar_ganhador"
                                                            value="{{ $rifa->winner }}">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="visible_rifa">Mostrar na Página
                                                            Inicial?</label>
                                                        <select class="form-control"
                                                            name="visible" id="visible">
                                                            <option value="0">Não</option>
                                                            <option value="1"
                                                                {{ $rifa->visible == 1 ? "selected='selected'" : '' }}>
                                                                Sim</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>URL amigável</label>
                                                    <input type="text" name="slug" value="{{ $rifa->slug }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="favoritar_rifa">Favoritar
                                                            Rifa</label>
                                                        <select class="form-control"
                                                            name="favoritar_rifa"
                                                            id="favoritar_rifa">
                                                            <option value="0">Não</option>
                                                            <option value="1"
                                                                {{ $rifa->favoritar == 1 ? "selected='selected'" : '' }}>
                                                                Sim</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="tipo_reserva">Tipo de
                                                            Reserva?</label>
                                                        <select class="form-control"
                                                            name="tipo_reserva" id="tipo_reserva">
                                                            <option value="manual"
                                                                {{ $rifa->type_raffles == 'manual' ? "selected='selected'" : '' }}>
                                                                Manual</option>
                                                            <option value="automatico"
                                                                {{ $rifa->type_raffles == 'automatico' ? "selected='selected'" : '' }}>
                                                                Automático</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-1 d-flex justify-content-center">
                                                <p>Tipo de Rifa</p>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="rifa_numero">Rifa de Números ou
                                                            Fazendinha</label>
                                                        <select class="form-control"
                                                            name="rifa_numero" id="rifa_numero" disabled>
                                                            <option value="numeros"
                                                                {{ $rifa->modo_de_jogo == 'numeros' ? "selected='selected'" : '' }}>
                                                                Números</option>
                                                            <option value="fazendinha-completa"
                                                                {{ $rifa->modo_de_jogo == 'fazendinha-completa' ? "selected='selected'" : '' }}>
                                                                Fazendinha - Grupo Completo</option>
                                                            <option value="fazendinha-meio"
                                                                {{ $rifa->modo_de_jogo == 'fazendinha-meio' ? "selected='selected'" : '' }}>
                                                                Fazendinha - Meio Grupo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="tab-pane fade"
                                            id="promocao{{ $rifa->id }}" role="tabpanel"
                                            aria-labelledby="promocao-tab">

                                            @foreach ($rifa->promocoes() as $promo)
                                                <div class="row text-center mt-2 promo">
                                                    <h5>Promoção {{ $promo->ordem }}</h5>
                                                    <div class="col-md-6">
                                                        <label>Qtd de números</label>
                                                        <input type="number" min="0"
                                                            name="numPromocao[{{ $promo->ordem }}]"
                                                            max="10000"
                                                            class="form-control text-center"
                                                            value="{{ $promo->qtdNumeros }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label
                                                            for="exampleInputEmail1">% de Desconto</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span
                                                                    class="input-group-text">%</span>
                                                            </div>
                                                            <input type="text"
                                                                class="form-control text-center"
                                                                name="valPromocao[{{ $promo->ordem }}]"
                                                                value="{{ $promo->desconto }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="tab-pane fade" id="fotos{{ $rifa->id }}"
                                            role="tabpanel" aria-labelledby="promocao-tab">
                                            <center><button type="button"
                                                    class="btn btn-sm btn-info"
                                                    data-id="{{ $rifa->id }}"
                                                    onclick="addFoto(this)">+ Foto(s)</button>
                                            </center>
                                            <div class="row d-flex justify-content-center mt-4">
                                                @if ($rifa->fotos()->count() > 0)
                                                    @foreach ($rifa->fotos() as $key => $foto)
                                                        <div class="col-md-4 text-center"
                                                            id="foto-{{ $foto->id }}">
                                                            <img src="/products/{{ $foto->name }}"
                                                                width="200"
                                                                style="border-radius: 10px;">
                                                                @if($key >= 0)
                                                                <a data-qtd="{{ $rifa->fotos()->count() }}" href="javascript:void(0)"
                                                                    class="delete btn btn-danger"
                                                                    onclick="excluirFoto(this)"
                                                                    data-id="{{ $foto->id }}"><i
                                                                        class="bi bi-trash3"></i></a>
                                                                @endif
                                                                
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>

                                        </div>
                                    </div>

                                    {{-- <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="geral{{ $rifa->id }}"
                                            role="tabpanel" aria-labelledby="geral-tab">
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <input type="hidden" name="product_id" value="{{ $rifa->id }}">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Nome</label>
                                                        <input type="text" class="form-control" name="name"
                                                            value="{{ $rifa->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="exampleInputEmail1">Valor</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">R$:</span>
                                                        </div>
                                                        <input type="text" class="form-control" name="price"
                                                            value="{{ $rifa->price }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Qtd mínima de
                                                            compra</label>
                                                        <input type="number" class="form-control" min="1"
                                                            max="999999" name="minimo" value="{{ $rifa->minimo }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Qtd máxima de
                                                        compra</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" name="maximo"
                                                            value="{{ $rifa->maximo }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Tempo de expiração
                                                        (min)
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" name="expiracao"
                                                            min="0" value="{{ $rifa->expiracao }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row justify-content-center">
                                                <div class="col-md-6">
                                                    <label for="">Mostar Ranking de
                                                        compradores (Qtd)</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" name="qtd_ranking"
                                                            value="{{ $rifa->qtd_ranking }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label>Mostrar Parcial (%)</label>
                                                    <select name="parcial"class="form-control">
                                                        <option value="1"
                                                            {{ $rifa->parcial == 1 ? 'selected' : '' }}>
                                                            Sim</option>
                                                        <option value="0"
                                                            {{ $rifa->parcial == 0 ? 'selected' : '' }}>
                                                            Não</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mt-4">
                                                <div class="col-md-12">
                                                    <label>Descrição</label>
                                                    <textarea class="form-control summernote" name="description" id="desc-{{ $rifa->id }}" rows="10"
                                                        style="min-height: 200px;" required>{!! $rifa->descricao() !!}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade show" id="premios{{ $rifa->id }}"
                                            role="tabpanel" aria-labelledby="geral-tab">
                                            <div class="row">
                                                @foreach ($rifa->premios() as $premio)
                                                    <div class="col-md-6 mt-2">
                                                        <label>{{ $premio->ordem }}º Prêmio</label>
                                                        <input type="text" class="form-control"
                                                            name="descPremio[{{ $premio->ordem }}]"
                                                            value="{{ $premio->descricao }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="ajustes{{ $rifa->id }}" role="tabpanel"
                                            aria-labelledby="ajustes-tab">
                                            <div class="row mt-3">
                                                <div class="col-5">
                                                    <div class="form-group">
                                                        <label for="status_sorteio">Status
                                                            Sorteio</label>
                                                        <select class="form-control" name="status" id="status">
                                                            <option value="Inativo"
                                                                {{ $rifa->status == 'Inativo' ? "selected='selected'" : '' }}>
                                                                Inativo</option>
                                                            <option value="Ativo"
                                                                {{ $rifa->status == 'Ativo' ? "selected='selected'" : '' }}>
                                                                Ativo</option>
                                                            <option value="Finalizado"
                                                                {{ $rifa->status == 'Finalizado' ? "selected='selected'" : '' }}>
                                                                Finalizado</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <form action="{{ route('drawDate') }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="product_id"
                                                        value="{{ $rifa->id }}">
                                                    <div class="col-12 col-md-7">
                                                        <div class="form-group">
                                                            <label for="data_sorteio">Data
                                                                Sorteio</label>
                                                            <input type="datetime-local" class="form-control"
                                                                name="data_sorteio" id="data_sorteio"
                                                                value="{{ date('Y-m-d H:i:s', strtotime($rifa->draw_date)) }}">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-sm">
                                                    <div class="form-group">
                                                        <label for="cadastrar_ganhador">Ganhador</label>
                                                        <input type="text" class="form-control"
                                                            name="cadastrar_ganhador" id="cadastrar_ganhador"
                                                            value="{{ $rifa->winner }}">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="visible_rifa">Mostrar na Página
                                                            Inicial?</label>
                                                        <select class="form-control" name="visible" id="visible">
                                                            <option value="0">Não</option>
                                                            <option value="1"
                                                                {{ $rifa->visible == 1 ? "selected='selected'" : '' }}>
                                                                Sim</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>URL amigável</label>
                                                    <input type="text" name="slug" value="{{ $rifa->slug }}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="favoritar_rifa">Favoritar
                                                            Rifa</label>
                                                        <select class="form-control" name="favoritar_rifa"
                                                            id="favoritar_rifa">
                                                            <option value="0">Não</option>
                                                            <option value="1"
                                                                {{ $rifa->favoritar == 1 ? "selected='selected'" : '' }}>
                                                                Sim</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <div class="form-group">
                                                        <label for="previsao_sorteio">Previsão
                                                            Sorteio</label>
                                                        <input type="datetime-local" class="form-control"
                                                            name="previsao_sorteio"
                                                            value="{{ date('Y-m-d H:i:s', strtotime($rifa->draw_prediction)) }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="tipo_reserva">Tipo de
                                                            Reserva?</label>
                                                        <select class="form-control" name="tipo_reserva"
                                                            id="tipo_reserva">
                                                            <option value="manual"
                                                                {{ $rifa->type_raffles == 'manual' ? "selected='selected'" : '' }}>
                                                                Manual</option>
                                                            <option value="automatico"
                                                                {{ $rifa->type_raffles == 'automatico' ? "selected='selected'" : '' }}>
                                                                Automático</option>
                                                            <option value="mesclado"
                                                                {{ $rifa->type_raffles == 'mesclado' ? "selected='selected'" : '' }}>
                                                                Automático & Manual</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-1 d-flex justify-content-center">
                                                <p>Tipo de Rifa</p>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="rifa_numero">Rifa de Números ou
                                                            Fazendinha</label>
                                                        <select class="form-control" name="rifa_numero"
                                                            id="rifa_numero" disabled>
                                                            <option value="numeros"
                                                                {{ $rifa->modo_de_jogo == 'numeros' ? "selected='selected'" : '' }}>
                                                                Números</option>
                                                            <option value="fazendinha"
                                                                {{ $rifa->modo_de_jogo == 'fazendinha' ? "selected='selected'" : '' }}>
                                                                Fazendinha</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="tab-pane fade" id="promocao{{ $rifa->id }}" role="tabpanel"
                                            aria-labelledby="promocao-tab">

                                            @foreach ($rifa->promocoes() as $promo)
                                                <div class="row text-center mt-2 promo">
                                                    <h5>Promoção {{ $promo->ordem }}</h5>
                                                    <div class="col-md-6">
                                                        <label>Qtd de números</label>
                                                        <input type="number" min="0"
                                                            name="numPromocao[{{ $promo->ordem }}]" max="10000"
                                                            class="form-control text-center"
                                                            value="{{ $promo->qtdNumeros }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="exampleInputEmail1">Valor</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">R$:</span>
                                                            </div>
                                                            <input type="text" class="form-control text-center"
                                                                name="valPromocao[{{ $promo->ordem }}]"
                                                                value="{{ number_format($promo->valor, 2, ',', '.') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="tab-pane fade" id="fotos{{ $rifa->id }}" role="tabpanel"
                                            aria-labelledby="promocao-tab">
                                            <center><button type="button" class="btn btn-sm btn-info"
                                                    data-id="{{ $rifa->id }}" onclick="addFoto(this)">+
                                                    Foto(s)</button>
                                            </center>
                                            <div class="row d-flex justify-content-center mt-4">
                                                @if ($rifa->fotos()->count() > 0)
                                                    @foreach ($rifa->fotos() as $key => $foto)
                                                        <div class="col-md-4 text-center"
                                                            id="foto-{{ $foto->id }}">
                                                            <img src="/products/{{ $foto->name }}" width="200"
                                                                style="border-radius: 10px;">
                                                            <a data-qtd="{{ $rifa->fotos()->count() }}"
                                                                href="javascript:void(0)"
                                                                class="delete btn btn-danger"
                                                                onclick="excluirFoto(this)"
                                                                data-id="{{ $foto->id }}"><i
                                                                    class="bi bi-trash3"></i></a>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>

                                        </div>
                                    </div> --}}
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancelar">
                        <input type="submit" class="btn btn-success" value="Salvar">
                    </div>
                </div>
            </form>
        </div>
    </div>
