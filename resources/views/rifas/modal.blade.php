<!-- Modal FINALIZAR RESERVA (CHECKOUT) -->
{{-- <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 999999999;">
    <div class="modal-dialog">
        <form action="{{ route('bookProductManualy') }}" method="POST">
            {{ csrf_field() }}
            <div class="modal-content" style="border: none;">
                <div class="modal-header" style="background-color: #939393;color: #fff;">
                    <h5 class="modal-title" id="staticBackdropLabel">FINALIZAR RESERVA</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body" style="background: #efefef;color: #939393;">
                    <div class="form-group">
                        <input type="hidden" name="tokenAfiliado" value="{{ $tokenAfiliado }}">
                        @if ($type_raffles == 'manual')
                            <label>Pagamento referente à participação na ação entre amigos
                                <b>{{ $product[0]->product }}</b> com os números:</label>
                        @else
                            <label>Pagamento referente à participação na ação entre amigos
                                <b>{{ $product[0]->product }}.</b></label>
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <div class="numberSelected" id="numberSelectedModal"
                                    style="overflow-y: auto;width: 190px;"></div>
                            </div>
                        </div>
                        @if (str_starts_with($productModel->modo_de_jogo, 'fazendinha'))
                            <input type="hidden" class="form-control" name="" id="qtdNumbers">
                        @else
                            @if ($type_raffles == 'manual')
                                <input type="hidden" class="form-control" name="qtdNumbers" id="qtdNumbers"
                                    value="">
                                <input type="hidden" class="form-control" name="rifaManual" id="qtdNumbers"
                                    value="1">
                            @else
                                <input type="hidden" class="form-control" name="qtdNumbers" id="qtdNumbers">
                            @endif
                        @endif

                        <input type="hidden" class="form-control" name="productName" value="{{ $product[0]->name }}">
                        <input type="hidden" class="form-control" name="productID" value="{{ $product[0]->id }}">
                        <input type="hidden" class="form-control" name="numberSelected" id="numberSelectedInput">
                        @if ($type_raffles == 'manual')
                            <small class="form-text" style="color: green;"><b>Valor a pagar: <small
                                        style="font-size: 15px;" id="numberSelectedTotalModal"></small></b></small>
                        @else
                            <small class="form-text" style="color: green;"><b>Valor a pagar: <small
                                        style="font-size: 15px;" id="numberSelectedTotalModal"></small></b></small>
                        @endif
                    </div>
                    <!--<legend>Por favor, preencha os dados abaixo:</legend>-->
                    <div class="form-group">
                        <label>NOME COMPLETO</label>
                        <input type="text" class="form-control"
                            style="background-color: #fff;border: none;color: #333;" name="name"
                            placeholder="Informe seu nome completo" required>
                    </div>
                    @if (!env('HIDE_EMAIL'))
                        <div class="form-group">
                            <label>E-mail (opcional)</label>
                            <input type="email" class="form-control"
                                style="background-color: #fff;border: none;color: #333;" name="email" id="email"
                                placeholder="Informe o seu e-mail" maxlength="50" required>
                        </div>
                    @endif
                    <div class="form-group {{ $productModel->gateway == 'asaas' ? '' : 'd-none' }}">
                        <label>CPF (somente números)</label>
                        <input type="number" class="form-control"
                            style="background-color: #fff;border: none;color: #333;" name="cpf" id="cpf"
                            placeholder="Informe o seu CPF" maxlength="50" required>
                    </div>
                    <div class="form-group">
                        <label>CELULAR (Whatsapp)</label>
                        <input type="text" class="form-control numbermask"
                            style="background-color: #fff;border: none;color: #333;" name="telephone" id="telephone1"
                            placeholder="Informe seu telefone com DDD" maxlength="15" required>
                    </div>
                    <input type="hidden" id="promo" name="promo">
                    <!--<small class="form-text text-muted">Reservando seu(s) número(s), você declara que leu e concorda com nossos <a href="{{ url('terms-of-use') }}">Termos de Uso</a>.</small>-->
                </div>
                <div class="modal-footer" style="background: #939393;color: #fff;">
                    <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>-->
                    <button type="submit" onClick="this.form.submit(); this.disabled=true; this.innerHTML='PROCESSANDO...'; "
                        class="btn btn-success"
                        style="width: 100%;min-height: 60px;border: none;color: #fff;font-weight: bold;width: 100%;background-color: green">PROSSEGUIR</button>
                </div>
            </div>
        </form>
    </div>
</div> --}}

<div class="modal fade" id="staticBackdrop" data-backdrop="MODA" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 999999;">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('bookProductManualy') }}" id="form-checkout" method="POST">
            {{ csrf_field() }}
            <div class="modal-content" style="border: none;">
                <div class="modal-header" style="background-color: #939393;color: #fff;">
                    <h5 class="modal-title" id="staticBackdropLabel">FINALIZAR RESERVA</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background: #efefef;color: #939393;">
                    @if ($type_raffles == 'manual')
                        <small class="form-text d-none" style="color: green;"><b>Valor a pagar: <small
                                    style="font-size: 15px;" id="numberSelectedTotalModal"></small></b></small>
                    @else
                        <small class="form-text d-none" style="color: green;"><b>Valor a pagar: <small
                                    style="font-size: 15px;" id="numberSelectedTotalModal"></small></b></small>
                    @endif

                    <div class="form-group">
                        <input type="hidden" name="tokenAfiliado" value="{{ $tokenAfiliado }}">
                        <div class="row">
                            <div class="col-md-12 d-none">
                                <div class="numberSelected" id="numberSelectedModal"
                                    style="overflow-y: auto;width: 190px;"></div>
                            </div>
                        </div>
                        @if (str_starts_with($productModel->modo_de_jogo, 'fazendinha'))
                            <input type="hidden" class="form-control" name="" id="qtdNumbers">
                        @else
                            @if ($type_raffles == 'manual')
                                <input type="hidden" class="form-control" name="qtdNumbers" id="qtdNumbers"
                                    value="">
                                <input type="hidden" class="form-control" name="rifaManual" id="qtdNumbers"
                                    value="1">
                            @else
                                <input type="hidden" class="form-control" name="qtdNumbers" id="qtdNumbers">
                            @endif
                        @endif

                        <input type="hidden" id="qtdManual">
                        <input type="hidden" class="form-control" name="productName" value="{{ $product[0]->name }}">
                        <input type="hidden" class="form-control" name="productID" value="{{ $product[0]->id }}">
                        <input type="hidden" class="form-control" name="numberSelected" id="numberSelectedInput">
                    </div>

                    <div class="form-group"
                        style="background-color: #cff4fc;padding: 10px;border-radius: 10px;color: #055160;">
                        <span>Você está adquirindo <strong id="qtd-checkout">33</strong> cota(s) da ação entre amigos
                            <strong id="rifa-checkout">20 MIL NA CONTA</strong> , seu(s) número(s)
                            sera(ão) gerado(s) assim que concluir a compra.</span>
                    </div>

                    <div class="form-group d-flex d-none" id="div-customer">
                        <div>
                            <img src="{{ asset('images/default-user.jpg') }}"
                                style="width: 70px; height: 70px;border-radius: 10px;">
                        </div>

                        <div class="ml-2" style="color: #000">
                            <h4 id="customer-name">Mario Souza</h4>
                            <h5 id="customer-phone">(15) 99770-6933</h5>
                        </div>
                    </div>

                    <div class="form-group" id="div-telefone">
                        <label style="color: #000"><strong>Informe seu telefone</strong></label>
                        <input type="text" class="form-control numbermask keydown"
                            style="background-color: #fff;border: none;color: #333;" name="telephone" id="telephone1"
                            placeholder="(00) 90000-0000" maxlength="15" required>
                        <input type="hidden" name="telephone" id="phone-cliente">
                        <input type="hidden" id="customer" name="customer">
                    </div>

                    <div class="form-group d-none" id="div-nome">
                        <label style="color: #000"><strong>Nome Completo</strong></label>
                        <input type="text" class="form-control"
                            style="background-color: #fff;border: none;color: #333;" name="name" id="name"
                            required>
                    </div>

                    <div class="form-group" id="div-info"
                        style="background-color: #fff3cd;padding: 10px;border-radius: 10px;color: #664d03;">
                        <span><i class="fas fa-info-circle"></i>&nbsp;<span id="info-footer">Informe seu telefone para
                                continuar.</span></span>
                    </div>

                    <button class="btn btn-block btn-primary" id="btn-checkout-action" onclick="checkCustomer()"
                        type="button"><strong id="btn-checkout">Continuar</strong></button>

                    <center>
                        <button class="btn btn-sm btn-outline-secondary mt-2 d-none" id="btn-alterar"
                            onclick="clearModal()">Alterar Telefone</button>
                    </center>
                    <input type="hidden" id="promo" name="promo">
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $('#staticBackdrop').on('hide.bs.modal', function() {
        clearModal()
    })

    $('input.keydown').on('keydown', function(e) {
        var code = e.which || e.keyCode;

        if (code == 13) {
            event.preventDefault();
            checkCustomer()
        }
    });



    function checkCustomer() {
        var phone = $('#telephone1').val()
        if (phone == null || phone == '') {
            alert('Informe o telefone para continuar!');
            $('#telephone1').focus();
            return;
        } else if (phone.length < 15) {
            alert('Informe um telefone válido!');
            $('#telephone1').select();
            return;
        }

        loading()
        $.ajax({
            url: "{{ route('getCustomer') }}",
            type: 'POST',
            dataType: 'json',
            data: {
                "phone": phone
            },
            success: function(response) {
                loading()
                if (response.customer == null) {
                    novoCliente(phone);
                } else {
                    findCustomer(response.customer)
                }
            },
            error: function(error) {
                Swal.fire(
                    'Erro Desconhecido!',
                    '',
                    'error'
                )
            }
        })
    }

    function finalizarCompra() {
        $('#form-checkout').submit();
    }

    function findCustomer(customer) {
        document.getElementById('customer-name').innerHTML = customer.nome;
        document.getElementById('customer-phone').innerHTML = customer.telephone;
        document.getElementById('name').value = customer.nome;
        document.getElementById('phone-cliente').value = customer.telephone;

        document.getElementById('customer').value = customer.id;
        document.getElementById('div-customer').classList.toggle('d-none');
        document.getElementById('btn-checkout').innerHTML = 'Concluir reserva';
        document.getElementById('btn-checkout-action').setAttribute("onclick", "loading()")
        document.getElementById('btn-checkout-action').type = 'submit'
        document.getElementById('btn-alterar').innerHTML = 'Alterar Conta';
        document.getElementById('btn-alterar').classList.remove('d-none');
        document.getElementById('div-info').classList.add('d-none');
        document.getElementById('div-telefone').classList.add('d-none');
    }

    function clearModal() {
        document.getElementById('telephone1').value = '';
        document.getElementById('telephone1').disabled = false;
        document.getElementById('div-nome').classList.add('d-none');
        document.getElementById('info-footer').innerHTML = 'Informe seu telefone para continuar.';
        document.getElementById('btn-checkout').innerHTML = 'Continuar';
        document.getElementById('btn-checkout-action').setAttribute("onclick", "checkCustomer()")
        document.getElementById('btn-alterar').classList.add('d-none');
        document.getElementById('btn-checkout-action').type = 'button'
        document.getElementById('phone-cliente').value = ''
        document.getElementById('customer').value = 0;
        document.getElementById('div-customer').classList.add('d-none');
        document.getElementById('div-info').classList.remove('d-none');
        document.getElementById('div-telefone').classList.remove('d-none');
    }

    function novoCliente(phone) {
        document.getElementById('telephone1').disabled = true;
        document.getElementById('div-nome').classList.toggle('d-none');
        document.getElementById('info-footer').innerHTML = 'Informe os dados corretos para recebimento das premiações.';
        document.getElementById('btn-checkout').innerHTML = 'Concluir cadastro e pagar';
        document.getElementById('btn-checkout-action').setAttribute("onclick", "loading()")
        document.getElementById('btn-checkout-action').type = 'submit'
        document.getElementById('btn-alterar').classList.innerHTML = 'Alterar Telefone';
        document.getElementById('btn-alterar').classList.toggle('d-none');
        document.getElementById('phone-cliente').value = phone
        document.getElementById('customer').value = 0;
    }
</script>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    style="z-index: 9999999;">
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
                        <form action="{{ route('consultingReservation') }}" method="POST" style="display: flex;">
                            {{ csrf_field() }}
                            <input type="hidden" name="productID" value="{{ $product[0]->id }}">
                            <input type="text" id="telephone3" name="telephone"
                                style="background-color: #fff;border: none;color: #000;margin-right:5px;"
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
<!-- Modal -->
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border: none;">
            <div class="modal-header" style="background-color: #020f1e;">
                <h5 class="modal-title" id="exampleModalLabel" style="color: #fff;">DÚVIDAS FREQUENTES</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    style="color: #fff;background-color: red!important;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="background-color: #020f1e;color: #ffffff;">
                <b style="text-transform: uppercase;">- É confiável?</b><br>
                <span style="color: #999999;">R: Sim, sorteio pela milhar da loteria federal.</span><br>
                <b style="text-transform: uppercase;">- Que dia é o sorteio?</b><br>
                <span style="color: #999999;">R: Após a venda de todas as cotas, no site você pode acompanhar as
                    vendas!</span><br>
                <b style="text-transform: uppercase;">- Como participar da nossa rifa?</b><br>
                <span style="color: #999999;">R: Existe duas formas compra automática e compra manual.</span><br>
                <b style="text-transform: uppercase;">- Forma de pagamento</b><br>
                <span style="color: #999999;">R: Somente PIX Copia e Cola ou CNPJ</span><br>
                <b style="text-transform: uppercase;">- Se eu escolher o veículo</b><br>
                <span style="color: #999999;">R: Vamos entregar na sua garagem o prêmio.</span>
            </div>
            <div class="modal-footer" style="background-color: #020f1e;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Premios --}}
<div class="modal fade" id="modal-premios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    style="z-index: 9999999;">
    <div class="modal-dialog">
        <div class="modal-content" style="border: none;">
            <div class="modal-header" style="background-color: #020f1e;">
                <h5 class="modal-title" id="exampleModalLabel" style="color: #fff;">PRÊMIOS</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                    style="color: #fff;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="">
                <div class="col-md-12 text-center">
                    Estes são os prêmios disponíveis no sorteio <strong>{{ $productModel->name }}</strong>
                </div>
                <hr>
                @foreach ($productModel->premios()->where('descricao', '!=', '') as $premio)
                    <div class="row mt-4">
                        <div class="col-md-12 text-center">
                            <label><strong>Prêmio {{ $premio->ordem }}: </strong>{{ $premio->descricao }}</label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Modal Ranking Compradores --}}
<div class="modal fade" id="modal-ranking" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    style="z-index: 9999999;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: none;">
            <div class="modal-header" style="background-color: #fff;">
                <h5 class="modal-title" id="exampleModalLabel" style="color: #000;"><img
                        src="{{ asset('images/treofeu.png') }}" alt=""> Top Compradores</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                    style="color: #000;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color: #000" >
                <div class="col-md-12 text-center" style="font-weight: 400">
                    Esses são os maiores compradores no sorteio <strong style="font-weight: 600">{{ $productModel->name }}</strong>
                </div>
                @foreach ($ranking as $key => $rk)
                    <div class="row mt-3" style="font-weight: 400">
                        <div class="col-1 text-center">
                            @if ($key == 0)
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#000"
                                    viewBox="0 0 16 16" style="width: 30px; height: auto; fill: rgb(255, 193, 7);">
                                    <path
                                        d="M2.5.5A.5.5 0 0 1 3 0h10a.5.5 0 0 1 .5.5c0 .538-.012 1.05-.034 1.536a3 3 0 1 1-1.133 5.89c-.79 1.865-1.878 2.777-2.833 3.011v2.173l1.425.356c.194.048.377.135.537.255L13.3 15.1a.5.5 0 0 1-.3.9H3a.5.5 0 0 1-.3-.9l1.838-1.379c.16-.12.343-.207.537-.255L6.5 13.11v-2.173c-.955-.234-2.043-1.146-2.833-3.012a3 3 0 1 1-1.132-5.89A33.076 33.076 0 0 1 2.5.5zm.099 2.54a2 2 0 0 0 .72 3.935c-.333-1.05-.588-2.346-.72-3.935zm10.083 3.935a2 2 0 0 0 .72-3.935c-.133 1.59-.388 2.885-.72 3.935zM3.504 1c.007.517.026 1.006.056 1.469.13 2.028.457 3.546.87 4.667C5.294 9.48 6.484 10 7 10a.5.5 0 0 1 .5.5v2.61a1 1 0 0 1-.757.97l-1.426.356a.5.5 0 0 0-.179.085L4.5 15h7l-.638-.479a.501.501 0 0 0-.18-.085l-1.425-.356a1 1 0 0 1-.757-.97V10.5A.5.5 0 0 1 9 10c.516 0 1.706-.52 2.57-2.864.413-1.12.74-2.64.87-4.667.03-.463.049-.952.056-1.469H3.504z">
                                    </path>
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#000"
                                    viewBox="0 0 16 16" style="width: 22px; height: auto; margin-left: 5px;">
                                    <path
                                        d="M2.5.5A.5.5 0 0 1 3 0h10a.5.5 0 0 1 .5.5c0 .538-.012 1.05-.034 1.536a3 3 0 1 1-1.133 5.89c-.79 1.865-1.878 2.777-2.833 3.011v2.173l1.425.356c.194.048.377.135.537.255L13.3 15.1a.5.5 0 0 1-.3.9H3a.5.5 0 0 1-.3-.9l1.838-1.379c.16-.12.343-.207.537-.255L6.5 13.11v-2.173c-.955-.234-2.043-1.146-2.833-3.012a3 3 0 1 1-1.132-5.89A33.076 33.076 0 0 1 2.5.5zm.099 2.54a2 2 0 0 0 .72 3.935c-.333-1.05-.588-2.346-.72-3.935zm10.083 3.935a2 2 0 0 0 .72-3.935c-.133 1.59-.388 2.885-.72 3.935zM3.504 1c.007.517.026 1.006.056 1.469.13 2.028.457 3.546.87 4.667C5.294 9.48 6.484 10 7 10a.5.5 0 0 1 .5.5v2.61a1 1 0 0 1-.757.97l-1.426.356a.5.5 0 0 0-.179.085L4.5 15h7l-.638-.479a.501.501 0 0 0-.18-.085l-1.425-.356a1 1 0 0 1-.757-.97V10.5A.5.5 0 0 1 9 10c.516 0 1.706-.52 2.57-2.864.413-1.12.74-2.64.87-4.667.03-.463.049-.952.056-1.469H3.504z">
                                    </path>
                                </svg>
                            @endif

                        </div>
                        <div class="col-6">
                            {{ $rk->name }}
                        </div>
                        <div class="col-5 text-end">
                            {{ $rk->totalReservas }} Números
                        </div>
                    </div>

                    {{-- <div class="btn-auto item-ranking">
                        {{ $key + 1 }}º {{ $productModel->medalhaRanking($key) }}<br>
                        <span style="font-size: 20px;font-weight: bold;">{{ $rk->name }}</span>
                        <br>
                        <span style="font-size: 12px;">Qtd. de Bilhetes
                            {{ $rk->totalReservas }}</span>
                    </div> --}}
                @endforeach
            </div>
        </div>
    </div>
</div>


<div class="blob green" id="messageIn"
    style="position: fixed;
bottom: 15px;
z-index: 99999;
color: #fff;
padding: 3px;
font-weight: bold;
font-size: 12px;
width: 180px;
text-align: center;
z-index: 99999;border-radius: 20px;left: 10px;">
</div>
