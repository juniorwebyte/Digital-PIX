@extends('layouts.app')

<style>
    body {
        background-color: #132439 !important;
    }
</style>

@section('title', 'Page Title')

@section('sidebar')

@stop

@section('content')
<div class="container" style="margin-bottom: 100px;">
    <div class="title">
        <h3 style="color: #fff;"><i class="bi bi-clock-history" style="color: #fff;"></i> TERMOS DE USO</h3>
    </div>
    <!--<div class="sub-title" style="color: #fff;">Vários participantes já tiveram seu sonho realizado, você pode ser o próximo!</div>-->

    <div class="row" style="color: #fff;">
        <div class="col-md-12">
            Regras de utilização<br>
            Ao utilizar os serviços do site {{ env('APP_URL') }}, você aceita as regras e termos abaixo:<br><br>

            Objetivo<br>
            O site {{ env('APP_URL') }}, inscrito sob o CNPJ: 00.000.000/0001-00, visa facilitar a reserva de números nas ações entre amigos de seus clientes, bem como facilitar o gerencimento da mesma através de seus administradores.<br><br>

            Responsabilidades<br>
            O site {{ env('APP_URL') }} não faz o intermédio de pagamentos dos números reservados. Todo o gerenciamento das ações são de responsabilidade ÚNICA E EXCLUSIVA DE SEUS ADMINISTRADORES, sendo assim, o site {{ env('APP_URL') }} NÃO se responsabiliza pela criação de ações, garantia dos prêmios, entregas dos prêmios e pagamentos feitos às ações.<br><br>

            Todas as dúvidas e eventuais problemas devem ser tratados diretamente com o administrador da ação. Cada administrador possui suas regras de sorteio, reservas, pagamentos, entre outros.<br><br>

            Caso o eventual problema seja relacionado ao site {{ env('APP_URL') }} por favor entre em contato conosco.<br><br>

            O site {{ env('APP_URL') }} irá remover sem aviso prévio qualquer conteúdo ou banir a conta de qualquer administrador/participante caso estes infrinjam qualquer regra descrita abaixo.<br><br>

            Criadores de ações entre amigos<br>
            Qualquer pessoa pode utilizar a ferramenta para a criação de uma ação entre seus amigos mediante cadastro no sistema e com consulta do CPF informado para confirmação do titular.<br>
            É proibida a utilização de quaisquer termos inadequados ou de caráter discriminatório em qualquer área do site {{ env('APP_URL') }}, sob risco de ter a ação removida e usuário banido em definitivo do site.<br>
            É proibida a utilização de imagens/videos de cunho sexual, violento, maltratos etc, sendo a ação removida de imediato após a verificação do conteúdo.<br>
            É proibida a oferta de determinadas premiações, tais como: Qualquer tipo de armas(de fogo, brancas, réplicas), bem como qualquer prêmio relacionado a entorpecentes, artigos sexuais e serviços sexuais.<br>
            O administrador da ação se compromete a realizar o sorteio no prazo estipulado por ele, seja ele com data prefixada na ação ou após o pagamento de todas as reservas. A não realização do sorteio ou a não existência do prêmio ocasionará o banimento de sua conta do site {{ env('APP_URL') }}.<br>
            O site {{ env('APP_URL') }} NÃO é responsável pelas reservas dos números e também não garante o pagamento do(s) número(s) reservado(s). O site somente informa os dados inseridos pelo próprio participante para permitir que as pessoas possam efetuar o pagamento diretamente aos administradores das ações.<br>
            As ações entre amigos ficam disponíveis pelo prazo máximo de 1 ano contados a partir da data de início da ação, caso o administrador queira prorrogar o prazo, o valor da taxa deverá ser paga novamente.<br><br>
            Participantes<br>
            A entrega/envio do prêmio é acordada com o administrador da ação, portanto leia as regras da ação que esta participando e verifique se o administrador faz o envio do prêmio ou será de sua responsabilidade a retirada do mesmo. A entrega/envio NÃO é de responsabilidade do site {{ env('APP_URL') }}.<br>
            Para participar de uma ação entre amigos o participante seleciona os números desejados e confirma a reserva inserindo Nome Completo e Telefone com DDD. Feita a reserva dos números escolhidos, será exibido ao participante as contas para realizar o pagamento, o envio do comprovante pode ser feito através do sistema (caso o administrador da ação permita) ou através da forma descrita nas regras da ação, assim o administrador poderá confirmar o pagamento. A confirmação não é automática e depende da verificação do administrador.<br>
            A quantidade de números escolhidos pelo participante fica limitada a regra configurada por cada administrador, podendo ou não ter limites estabelecidos no momento da criação da ação entre amigos.<br>
            O site {{ env('APP_URL') }} não faz o intermédio de nenhum pagamento, com isso não é de nossa responsabilidade eventuais problemas entre as partes decorrentes de pagamentos feitos ou não feitos.<br>
            O sorteio é um processo realizado pelo próprio criador da ação, após o término do período de reserva de números no site. Após realizado o sorteio, o administrador da ação irá inserir o número sorteado bem como a data do sorteio no sistema, sendo assim, o sistema irá exibir qual o número foi sorteado. A entrega do prêmio é de responsabilidade do dono da ação.<br>
            Sem aviso prévio, estas regras e termos de uso podem ser alteradas a qualquer momento.
        </div>
    </div>
</div>
@stop