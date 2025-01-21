@extends('afiliados.layout.menuAfiliados')

@section('content')
    <div class="container">
        <div class="col-md-12 text-center">
            <h3>Rifas</h3>
        </div>

        <div class="row">
            <div class="col-md-12">
                <label>Legenda</label><br>
                <label class="badge bg-success">&nbsp;</label> <span>Afiliado</span> <br>
                <label class="badge bg-secondary">&nbsp;</label> <span>Disponível</span>
            </div>
        </div>

        <div class="container mt-3" style="max-width:100%;min-height:100%;">
            <div class="table-wrapper ">
                <div class="table-title">
                    <table class="table table-bordered table-responsive-md table-hover align=center" id="table_rifas">
                        <thead>
                            <tr>
                                <th>Miniatura</th>
                                <th>Rifa</th>
                                <th>Sorteio</th>
                                <th>Valor da Cota</th>
                                <th>% Afiliado</th>
                                <th>Acões</th>
                                <div id="copy-link"></div>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($rifas->count() == 0)
                                <tr class="text-center">
                                    <td colspan="6">Nenhuma rifa encontrada!</td>
                                </tr>
                            @endif
                            @foreach ($rifas as $key => $product)
                                <tr class="{{ $product->checkAfiliado() ? 'bg-success' : 'bg-secondary' }}">
                                    <td style="width: 50px;" class="text-center"><img style="border-radius: 5px;"
                                            src="/products/{{ $product->imagem() ? $product->imagem()->name : '' }}"
                                            width="50" alt=""></td>
                                    <td>{{ $product->status }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->ganho_afiliado }}</td>
                                    <td style="width: 20%">
                                        <a class="btn btn-sm btn-primary {{ $product->checkAfiliado() ? 'disabled' : '' }}"
                                            href="{{ route('afiliado.afiliarSe', $product->id) }}">Afiliar-se</a>
                                        <button class="btn btn-sm btn-info"
                                            data-url="{{ route('product', $product->slug) }}"
                                            data-token="{{ $product->getAfiliadoToken() }}"
                                            onclick="getLinkAfiliado(this)">Link</button>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-link" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Link de Afiliado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 text-center">
                        <p> Divulge o link abaixo e ganhe a cada compra com o seu link!</p>
                    </div>

                    <div class="col-md-12 mt-4">
                        <input type="text" id="link-afiliado" class="form-control text-center">
                    </div>
                    <div class="row d-flex justify-content-center mt-4">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-sm btn-info" style="color: #fff;" onclick="copiarLink()">Copiar</button>
                            <a class="btn btn-primary" id="link-facebook" style="background-color: #2760AE;border: none;font-size: 20px;"
                                href="" target="_blank"
                                rel="noreferrer noopener" role="button"><i class="bi bi-facebook"></i></a>
                            <!-- Telegram -->
                            <a class="btn btn-primary" id="link-telegram" style="background-color: #2F9DDF;border: none;"
                                href="" target="_blank"
                                rel="noreferrer noopener" role="button"><i class="bi bi-telegram"
                                    style="font-size: 20px;"></i></a>
                            <!-- Whatsapp -->
                            <a class="btn btn-primary" id="link-wpp" style="background-color: #25d366;border: none;"
                                href="" target="_blank"
                                rel="noreferrer noopener" role="button"><i class="bi bi-whatsapp"
                                    style="font-size: 20px;"></i></a>
                            <!-- Twitter -->
                            <a class="btn btn-primary" id="link-twitter" style="background-color: #34B3F7;border: none;"
                                href=""
                                target="_blank" rel="noreferrer noopener" role="button"><i class="bi bi-twitter"
                                    style="font-size: 20px;"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function getLinkAfiliado(el) {
            var url = el.dataset.url;
            var token = el.dataset.token;
            var link = `${url}/${token}`;

            $('#link-afiliado').val(link);
            $('#link-facebook').attr('href', `https://www.facebook.com/sharer/sharer.php?u=${link}`);
            $('#link-telegram').attr('href', `https://telegram.me/share/url?url=${link}`)
            $('#link-wpp').attr('href', `https://api.whatsapp.com/send?text=${link}`)
            $('#link-twitter').attr('href', `https://twitter.com/intent/tweet?text=Vc%20pode%20ser%20o%20Próximo%20Ganhador%20${link}`)
            $('#modal-link').modal('show');
        }

        function copiarLink() {
            var copyText = document.getElementById("link-afiliado");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");

            alert("Link copiado com sucesso.");

        }

        function closeModal() {
            $('#modal-link').modal('hide')
        }
    </script>
@endsection
