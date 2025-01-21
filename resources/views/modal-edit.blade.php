<!-- Edit Modal HTML -->
<div id="modal_editar_rifa{{$product->id}}" class="modal fade">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="{{url('edit-product/'. $product->id)}}" method="POST" enctype="multipart/form-data">
                            @method('PUT')

                                            {{ csrf_field() }}
                                <div class="container mt-3">
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h2>Editar Rifas</h2>
                                    <div class="row">
                                        <div class="col">
                                            <nav>
                                                <ul class="nav nav-tabs" id="myTab" role="tablist" style="font-size: 12px;">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="geral-tab" data-toggle="tab" href="#geral" role="tab" aria-controls="geral" aria-selected="true">Geral</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="ajustes-tab" data-toggle="tab" href="#ajustes" role="tab" aria-controls="ajustes" aria-selected="false">Ajustes</a>
                                                    </li>
                                                </ul>
                                            </nav>
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active" id="geral" role="tabpanel" aria-labelledby="geral-tab">
                                                        <div class="row mt-3">
                                                            <div class="col-md-6">
                                                            <input type="hidden" name="product_id" value="{{$product->id}}">
                                                                <div class="form-group">
                                                                    <label for="exampleInputEmail1">Nome</label>
                                                                    <input type="text" class="form-control"  name="name" value="{{$product->name}}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="exampleFormControlFile1">Imagem</label>
                                                                    <input type="file" class="form-control-file" name="images[]"
                                                                        accept="image/*" multiple required>
                                                                    <img src="/products/{{$product->image}}" class="mt-1" alt="..." style="max-width:100px;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="exampleInputEmail1">Valor</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">R$:</span>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="price"
                                                                        value="{{ $product->price }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Quantidade de números</label>
                                                            <input type="number" class="form-control" name="numbers" min="1"
                                                                max="99999" value="{{$product->total_number}}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleFormControlTextarea1">Descrição do Sorteio</label>
                                                            <textarea class="form-control" id="summernote" name="description" rows="3" value="">{{$product->description}}</textarea>
                                                        </div>
                                                </div>
                                                <div class="tab-pane fade" id="ajustes" role="tabpanel" aria-labelledby="ajustes-tab">
                                                        <div class="row mt-3">
                                                            <div class="col-5">
                                                                    <div class="form-group">
                                                                        <label for="status_sorteio">Status Sorteio</label>
                                                                        <select class="form-control" id="status_sorteio">
                                                                        <option value="Inativo">Inativo</option>
                                                                        <option value="Ativo" {{$product->status == "Ativo" ? "selected='selected'" : ''}}>Ativo</option>
                                                                        </select>
                                                                    </div>
                                                            </div>
                                                            <div class="col-7">
                                                                    <div class="form-group">
                                                                        <label for="data_sorteio">Data Sorteio</label>
                                                                        <input type="date" class="form-control" id="data_sorteio" value="{{ \Carbon\Carbon::parse($product->draw_date)->format('Y-m-d')}}">
                                                                    </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-sm">
                                                                    <div class="form-group">
                                                                        <label for="cadastrar_ganhador">Ganhador</label>
                                                                        <input type="text" class="form-control" id="cadastrar_ganhador" value="{{$product->winner}}">
                                                                    </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label for="favoritar_rifa">Mostrar na Página Inicial?</label>
                                                                    <select class="form-control" id="mostrar_pagina_icicial">
                                                                        <option value="0">Não</option>
                                                                        <option value="1" {{$product->visible == 1 ? "selected='selected'" : ''}}>Sim</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label for="favoritar_rifa">Favoritar Rifa</label>
                                                                    <select class="form-control" id="favoritar_rifa">
                                                                        <option value="0">Não</option>
                                                                        <option value="1" {{$product->favoritar == 1 ? "selected='selected'" : ''}}>Sim</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                    <div class="form-group">
                                                                        <label for="previsao_sorteio">Previsão Sorteio</label>
                                                                        <input type="date" class="form-control" id="previsao_sorteio" value="{{ \Carbon\Carbon::parse($product->draw_prediction)->format('Y-m-d')}}">
                                                                    </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label for="tipo_reserva">Tipo de Reserva?</label>
                                                                    <select class="form-control" id="tipo_reserva">
                                                                        <option value="manual" {{$product->type_raffles == "manual" ? "selected='selected'" : ''}}>Manual</option>
                                                                        <option value="automatico" {{$product->type_raffles == "automatico" ? "selected='selected'" : ''}}>Automático</option>
                                                                        <option value="mesclado" {{$product->type_raffles == "mesclado" ? "selected='selected'" : ''}}>Automático & Manual</option>
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
                                                                    <label for="rifa_numero">Rifa de Números ou Fazendinha</label>
                                                                    <select class="form-control" id="rifa_numero">
                                                                        <option value="numero" {{$product->type_raffles == "numero" ? "selected='selected'" : ''}}>Números</option>
                                                                        <option value="fazendinha" {{$product->type_raffles == "fazendinha" ? "selected='selected'" : ''}}>Fazendinha</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                            </form>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                            <input type="submit" class="btn btn-info" value="Salvar">
                        </div>                       
                    </div>
                </div>