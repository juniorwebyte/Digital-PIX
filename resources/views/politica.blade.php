@extends('layouts.app')

<link rel="manifest" href="/manifest.json">
<script type="text/javascript" src="sw.js"></script>
<style>
    body {
        background: #000 !important;
    }
</style>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"
    integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script>
    function isIOS() {
        var ua = navigator.userAgent.toLowerCase();

        //Lista de dispositivos que acessar
        var iosArray = ['iphone', 'ipod'];

        var isApple = false;

        if (ua.includes('iphone') || ua.includes('ipod')) {
            isApple = true
        }

        return isApple;
    }
</script>


<style>
    @media only screen and (-webkit-min-device-pixel-ratio: 1) {

        ::i-block-chrome,
        .app-main {
            margin-top: 100px !important;
        }
    }

    .app-main {
        border-top-right-radius: 20px;
        border-top-left-radius: 20px;
        max-width: 600px;
        margin-top: 40px;
        margin-bottom: 50px;
        border-bottom-right-radius: 20px;
        border-bottom-left-radius: 20px;
    }

    .app-main a {
        text-decoration: none;
    }

    .app-main a:hover {
        text-decoration: none;
    }

    .app-title {
        display: flex;
        align-items: self-end;
        padding-bottom: 10px;
    }

    .app-title h1 {
        color: rgba(0, 0, 0, .9);
        padding-right: 5px;
        font-weight: 600;
        font-size: 1.3em;
        margin: 0;
        padding-top: 10px;
    }

    .app-title .app-title-desc {
        color: rgba(0, 0, 0, .5);
        padding-top: 6px;
        font-size: .9em;
    }


    /* *************************************************************** */
    /* Card Rifa em Destaque */
    /* *************************************************************** */
    .rifas {
        background: #e4e4e4;
        border-top-right-radius: 20px;
        border-top-left-radius: 20px;
        position: absolute;
        border-bottom-right-radius: 20px;
        border-bottom-left-radius: 20px;
        min-height: 100vh;
    }

    .rifa-dark {
        background-color: #383838;
    }

    .card-rifa-destaque .img-rifa-destaque img {
        width: 100%;
        height: 290px;
        border-top-right-radius: 20px;
        border-top-left-radius: 20px;
    }

    .card-rifa-destaque {
        border-top-right-radius: 20px;
        border-top-left-radius: 20px;
        padding-bottom: 10px;
        background: #fff;
        margin-bottom: 10px;
        border-bottom-right-radius: 20px;
        border-bottom-left-radius: 20px;
    }

    .title-rifa-destaque {
        padding-top: 5px;
        padding-left: 10px;
    }

    .title-rifa-destaque h1 {
        color: #202020;
        -webkit-line-clamp: 2 !important;
        margin-bottom: 1px;
        font-weight: 500;
        font-size: 1em;
    }

    .title-rifa-destaque p {
        color: rgba(0, 0, 0, .7);
        font-size: .75em;
        max-width: 96%;
        margin: 0;
    }

    /* *************************************************************** */


    /* *************************************************************** */
    /* Card Rifa Normal */
    /* *************************************************************** */
    .card-rifa img {
        width: 100px;
        height: 100px;
        border-radius: 10px;
    }

    .card-rifa {
        background: #fff;
        padding: 5px;
        margin-bottom: 10px;
        border-radius: 10px;
        display: flex
    }

    .title-rifa {
        margin-left: 15px;
        width: 100%;
    }

    .blink {
        margin-top: 5px;
        animation: animate 1.5s linear infinite;
    }



    @keyframes animate {
        0% {
            opacity: 0;
        }

        50% {
            opacity: 0.7;
        }

        100% {
            opacity: 0;
        }
    }
</style>


@section('content')
    <style>
        .duvida {
            background-color: #ffffff5e;
            border-radius: 10px;
            height: 60px;
            align-items: center;
            justify-content: center;
            margin-top: 7px;
            cursor: pointer;
        }

        .icone-duvidas {
            width: 50px;
            justify-content: center;
            align-items: center;
            background-color: #b9b9b9;
            height: 35px;
            border-radius: 10px;
            text-align: center;
            font-size: 20px;
        }

        .text-duvidas {
            display: flex !important;
            flex-direction: column;
            justify-content: center
        }

        .f-15 {
            font-size: 15px;
        }

        .f-12 {
            font-size: 12px;
        }

        .data-sorteio {
            /* float: right; */
            padding-right: 10px;
            font-weight: thin;
            text-align: center;
            /* margin-top: 10px; */
            color: #000;
        }

        .rifas.dark {
            background: #383838;
        }

        .app-title.dark h1 {
            color: #fff;
        }

        .app-title-desc.dark {
            color: #fff;
        }

        .card-rifa-destaque.dark {
            background: #222222;
        }

        .title-rifa-destaque.dark h1 {
            color: #fff;
        }

        .title-rifa-destaque.dark p {
            color: #fff;
        }

        .card-rifa.dark {
            background: #222222;
        }

        .text-duvidas.dark h6 {
            color: #fff;
        }

        .text-duvidas.dark p {
            color: #fff !important;
        }

        .data-sorteio.dark {
            color: #fff !important;
        }

        .app-title.dark {
            color: #fff;
        }
    </style>

    <div class="container app-main" id="app-main">

        <div class="row justify-content-center">
            <div class="col-md-6 col-12 rifas">
                <div class="app-title">
                    <h1>📋 Política de Privacidade</h1>
                </div>
                <p class="text-center">
                    Este site é mantido e operado por <strong>{{ $config->name }}</strong>
                </p>
                <p class="text-center">
                    Nós coletamos e utilizamos alguns dados pessoais que pertencem àqueles que utilizam
                    nosso site. Ao fazê-lo, agimos na qualidade de controlador desses dados e estamos
                    sujeitos às disposições da Lei Federal n. 13.709/2018 (Lei Geral de Proteção de Dados
                    Pessoais - LGPD).
                    Nós cuidamos da proteção de seus dados pessoais e, por isso, disponibilizamos esta
                    política de privacidade, que contém informações importantes sobre:
                </p>
                <ul>
                    <li> Quem deve utilizar nosso site.</li>
                    <li>Quais dados coletamos e o que fazemos com eles.</li>
                    <li>Seus direitos em relação aos seus dados pessoais.</li>
                    <li>Como entrar em contato conosco.</li>
                </ul>
                <p>
                <h5>1. Quem deve utilizar nosso site:</h5>
                </p>
                <p class="text-center">
                    Nosso site só deve ser utilizado por pessoas com mais de dezoito anos de idade. Sendo
                    assim, crianças e adolescentes não devem utilizá-lo.
                </p>
                <p>
                <h5>2. Dados que coletamos e motivos da coleta:</h5>
                </p>
                <p class="text-center">
                    Nosso site coleta e utiliza alguns dados pessoais de nossos usuários, de acordo com o
                    disposto nesta seção.
                </p>
                <p>
                    <i>1. Dados pessoais fornecidos expressamente pelo usuário:</i>
                </p>
                <p>
                    Nós coletamos os seguintes dados pessoais que nossos usuários nos fornecem
                    expressamente ao utilizar nosso site:
                </p>
                <ul>
                    <li>Nome</li>
                    <li>Data de nascimento</li>
                    <li>E-mail</li>
                    <li>CPF</li>
                    <li>Telefone</li>
                    <li>Endereço</li>
                    <li>Dados de cartão de crédito ou débito</li>
                </ul>

                <p>
                    A coleta destes dados ocorre nos seguintes momentos:
                </p>

                <ul>
                    <li>Quando o usuário utiliza o formulário de contato</li>
                    <li>Quando o usuário faz seu cadastro no site</li>
                    <li>Quando o usuário faz uma compra</li>
                </ul>

                <p>
                    Os dados fornecidos por nossos usuários são coletados com as seguintes finalidades:
                </p>

                <ul>
                    <li>Para que o usuário possa adquirir nossos produtos e serviços</li>
                    <li>Para que o usuário possa entrar em contato com o nosso SAC</li>
                    <li>Para que nós possamos enviar nossos produtos aos usuários cadastrados</li>
                    <li>Para que possamos enviar ofertas a nossos usuários</li>
                </ul>

                <p>
                    <i>2. Dados pessoais obtidos de outras formas:</i>
                </p>

                <p>Nós coletamos os seguintes dados pessoais de nossos usuários:</p>

                <ul>
                    <li>Endereço IP</li>
                    <li>Dados geolocalização</li>
                    <li>Dados de transações feitas por meio do site</li>
                </ul>

                <p>A coleta destes dados ocorre nos seguintes momentos:</p>

                <ul>
                    <li>Quando o usuário faz login e logout no site</li>
                    <li>Quando o usuário realiza uma compra</li>
                    <li>Quando o usuário seleciona algum produto ou serviço</li>
                </ul>

                <p>Estes dados são coletados com as seguintes finalidades:</p>

                <ul>
                    <li>Garantir a segurança e a autenticidade das transações feitas no site</li>
                    <li>Cumprir determinação legal de armazenamento de registros de acesso a aplicações</li>
                    <li>Personalizar a experiência do usuário</li>
                </ul>

                <p>
                    <i>3. Dados sensíveis:</i>
                </p>

                <p>
                    <strong>Não</strong> serão coletados dados sensíveis de nossos usuários, assim entendidos aqueles
                    definidos nos arts. 11 e seguintes da Lei de Proteção de Dados Pessoais. Assim, não
                    haverá coleta de dados sobre origem racial ou étnica, convicção religiosa, opinião política,
                    filiação a sindicato ou a organização de caráter religioso, filosófico ou político, dado
                    referente à saúde ou à vida sexual, dado genético ou biométrico, quando vinculado a uma
                    pessoa natural.
                </p>

                <p>
                    <i>4. Cookies:</i>
                </p>

                <p>
                    Cookies são pequenos arquivos de texto baixados automaticamente em seu dispositivo
                    quando você acessa e navega por um site. Eles servem, basicamente, para seja possível
                    identificar dispositivos, atividades e preferências de usuários
                </p>

                <p>
                    Os cookies não permitem que qualquer arquivo ou informação sejam extraídos do disco
                    rígido do usuário, não sendo possível, ainda, que, por meio deles, se tenha acesso a
                    informações pessoais que não tenham partido do usuário ou da forma como utiliza os
                    recursos do site.
                </p>

                <p>
                    Os cookies do site são aqueles enviados ao computador ou dispositivo do usuário e
                    administrador exclusivamente pelo site.
                </p>

                <p>
                    As informações coletadas por meio destes cookies são utilizadas para melhorar e
                    personalizar a experiência do usuário, sendo que alguns cookies podem, por exemplo, ser
                    utilizados para lembrar as preferências e escolhas do usuário, bem como para o
                    oferecimento de conteúdo personalizado.
                </p>

                <p>
                    Alguns de nossos parceiros podem configurar cookies nos dispositivos dos usuários que
                    acessam nosso site.
                </p>

                <p>
                    Estes cookies, em geral, visam possibilitar que nossos parceiros possam oferecer seu
                    conteúdo e seus serviços ao usuário que acessa nosso site de forma personalizada, por
                    meio da obtenção de dados de navegação extraídos a partir de sua interação com o site.
                </p>

                <p>
                    O usuário poderá obter mais informações sobre os cookies de terceiro e sobre a forma como
                    os dados obtidos a partir dele são tratados, além de ter acesso à descrição dos cookies
                    utilizados e de suas características, acessando o seguinte link:
                </p>

                <p>
                    Google: <a href="https://www.google.com.br">https://www.google.com.br</a><br>
                    Facebook: <a href="https://pt-br.facebook.com">https://pt-br.facebook.com</a>
                </p>

                <p>
                    As entidades encarregadas da coleta dos cookies poderão ceder as informações obtidas a
                    terceiros.
                </p>

                <p>
                    O usuário poderá se opor ao registro de cookies pelo site, bastando que desative esta opção
                    no seu próprio navegador. Mais informações sobre como fazer isso em alguns dos principais
                    navegadores utilizados hoje podem ser acessadas a partir dos seguintes links:
                </p>

                <p>
                    Internet Explorer: <a
                        href="https://support.microsoft.com/pt-br/windows/excluir-e-gerenciar-cookies-168dab11-0753-043d-7c16-ede5947fc64d">https://support.microsoft.com/pt-br/windows/excluir-e-gerenciar-cookies</a><br><br>

                    Safari: <a
                        href="https://support.apple.com/pt-br/guide/safari/sfri11471/mac">https://support.apple.com/pt-br/guide/safari/sfri11471/mac</a><br><br>

                    Google Chrome: <a
                        href="https://support.google.com/chrome/answer/95647?hl=pt-BR&hlrm=pt">https://support.google.com/chrome/answer/95647?hl=pt-BR&hlrm=pt</a><br><br>

                    Mozila Firefox: <a
                        href="https://support.mozilla.org/pt-BR/kb/protecao-aprimorada-contra-rastreamento-firefox-desktop?redirectslug=ative-e-desative-os-cookies-que-os-sites-usam&redirectlocale=pt-BR">https://support.mozilla.org/pt-BR/kb/protecao-aprimorada-contra-rastreamento-firefox-desktop?redirectslug=ative-e-desative-os-cookies-que-os-sites-usam</a><br><br>

                    Opera: <a
                        href="https://help.opera.com/en/latest/web-preferences/">https://help.opera.com/en/latest/web-preferences/</a>
                </p>

                <p>
                    A desativação dos cookies, no entanto, pode afetar a disponibilidade de algumas
                    ferramentas e funcionalidades do site, comprometendo seu correto e esperado
                    funcionamento. Outra consequência possível é remoção das preferências do usuário que
                    eventualmente tiverem sido salvas, prejudicando sua experiência.
                </p>

                <p>
                    <i>5. Coleta de dados não previstos expressamente:</i>
                </p>

                <p>
                    Eventualmente, outros tipos de dados não previstos expressamente nesta Política de
                    Privacidade poderão ser coletados, desde que sejam fornecidos com o consentimento do
                    usuário, ou, ainda, que a coleta seja permitida com fundamento em outra base legal prevista
                    em lei.
                </p>

                <p>
                    Em qualquer caso, a coleta de dados e as atividades de tratamento dela decorrentes serão
                    informadas aos usuários do site.
                </p>

                <p>
                <h5>3. Compartilhamento de dados pessoais com terceiros:</h5>
                </p>

                <p>
                    Nós não compartilhamos seus dados pessoais com terceiros. Apesar disso, é possível que o
                    façamos para cumprir alguma determinação legal ou regulatória, ou, ainda, para cumprir
                    alguma ordem expedida por autoridade pública.
                </p>

                <p>
                <h5>4. Por quanto tempo seus dados pessoais são armazenados:</h5>
                </p>

                <p>
                    Os dados pessoais coletados pelo site são armazenados e utilizados por período de tempo
                    que corresponda ao necessário para atingir as finalidades elencadas neste documento e
                    que considere os direitos de seus titulares, os direitos do controlador do site e as
                    disposições legais ou regulatórias aplicáveis.
                </p>

                <p>
                    Uma vez expirados os períodos de armazenamento dos dados pessoais, eles são
                    removidos de nossas bases de dados ou anonimizados, salvo nos casos em que houver a
                    possibilidade ou a necessidade de armazenamento em virtude de disposição legal ou
                    regulatória.
                </p>

                <p>
                <h5>5. Bases legais para o tratamento de dados pessoais</h5>
                </p>

                <p>
                    Cada operação de tratamento de dados pessoais precisa ter um fundamento jurídico, ou
                    seja, uma base legal, que nada mais é que uma justificativa que a autorize, prevista na Lei
                    Geral de Proteção de Dados Pessoais.
                </p>

                <p>
                    Todas as Nossas atividades de tratamento de dados pessoais possuem uma base legal que
                    as fundamenta, dentre as permitidas pela legislação. Mais informações sobre as bases
                    legais que utilizamos para operações de tratamento de dados pessoais específicas podem
                    ser obtidas a partir de nossos canais de contato, informados ao final desta Política.
                </p>

                <p>
                <h5>6. Transferência Internacional de dados pessoais</h5>
                </p>

                <p>
                    Os Dados Pessoais do consumidor serão tratados no Brasil, armazenados em servidores
                    localizados no Brasil, na União Europeia ou nos EUA.
                </p>

                <p>
                    No caso de transferência de dados para países terceiros, a Hands On verificará se esses
                    terceiros operam em países onde a Autoridade Nacional de Proteção de Dados Pessoais
                    (ANPD) venha a reconhecer um nível de proteção adequado. Caso envolva a transferência
                    para países terceiros onde a ANPD não venha a reconhecer um nível adequado de
                    proteção, serão negociadas cláusulas adequadas de proteção de dados com esses
                    terceiros.
                </p>

                <p>
                    Caso o tratamento de seus Dados Pessoais envolva a transferência para países terceiros
                    onde a ANPD não venha a reconhecer um nível adequado de proteção ou outras medidas
                    adequadas de proteção de dados, seus Dados Pessoais serão tratados em seu interesse e
                    de acordo com seu próprio consentimento.
                </p>

                <p>
                    Lembre-se de que, apesar da Hands On emitir instruções operacionais comuns para todos
                    os países em que o grupo opera, a transferência de seus Dados Pessoais pode estar
                    exposta a alguns riscos relacionados à legislação local específica desses terceiros países
                    sobre tratamento de dados pessoais.
                </p>

                <p>
                <h5>7. Direitos do usuário</h5>
                </p>

                <p>
                    O usuário do site possui os seguintes direitos, conferidos pela Lei de Proteção de Dados
                    Pessoais:
                </p>

                <p>
                <ul>
                    <li>confirmação da existência de tratamento</li>
                    <li>acesso aos dados</li>
                    <li>correção de dados incompletos, inexatos ou desatualizados</li>
                    <li>
                        anonimização, bloqueio ou eliminação de dados desnecessários, excessivos ou
                        tratados em desconformidade com o disposto na lei
                    </li>
                    <li>
                        portabilidade dos dados a outro fornecedor de serviço ou produto, mediante requisição
                        expressa, de acordo com a regulamentação da autoridade nacional, observados os
                        segredos comercial e industrial
                    </li>
                    <li>
                        eliminação dos dados pessoais tratados com o consentimento do titular, exceto nos
                        casos previstos em lei
                    </li>
                    <li>
                        informação das entidades públicas e privadas com as quais o controlador realizou uso
                        compartilhado de dados
                    </li>
                    <li>
                        informação sobre a possibilidade de não fornecer consentimento e sobre as
                        consequências da negativa
                    </li>
                    <li>revogação do consentimento</li>
                </ul>
                </p>

                <p>
                    É importante destacar que, nos termos da LGPD, não existe um direito de eliminação de
                    dados tratados com fundamento em bases legais distintas do consentimento, a menos que
                    os dados sejam desnecessários, excessivos ou tratados em desconformidade com o
                    previsto na lei.
                </p>

                <p>
                    Para garantir que o usuário que pretende exercer seus direitos é, de fato, o titular dos dados
                    pessoais objeto da requisição, poderemos solicitar documentos ou outras informações que
                    possam auxiliar em sua correta identificação, a fim de resguardar nossos direitos e os
                    direitos de terceiros. Isto somente será feito, porém, se for absolutamente necessário, e o
                    requerente receberá todas as informações relacionadas.
                </p>

                <p>
                <h5>8. Medidas de segurança no tratamento de dados pessoais</h5>
                </p>

                <p>
                    Empregamos medidas técnicas e organizativas aptas a proteger os dados pessoais de
                    acessos não autorizados e de situações de destruição, perda, extravio ou alteração desses
                    dados.
                </p>

                <p>
                    As medidas que utilizamos levam em consideração a natureza dos dados, o contexto e a
                    finalidade do tratamento, os riscos que uma eventual violação geraria para os direitos e
                    liberdades do usuário, e os padrões atualmente empregados no mercado por empresas
                    semelhantes à nossa.
                </p>

                <p>
                    Entre as medidas de segurança adotadas por nós, destacamos as seguintes:
                </p>

                <ul>
                    <li>Senhas criptografadas em base 64</li>
                    <li>Controle de acessos ao banco de dados</li>
                    <li>Monitoramento de trafego de dados</li>
                    <li>Infraestrutura AWS</li>
                    <li>Conexões Secure Socket Layer</li>
                </ul>

                <p>
                    Ainda que adote tudo o que está ao seu alcance para evitar incidentes de segurança, é
                    possível que ocorra algum problema motivado exclusivamente por um terceiro - como em
                    caso de ataques de hackers ou crackers ou, ainda, em caso de culpa exclusiva do usuário,
                    que ocorre, por exemplo, quando ele mesmo transfere seus dados a terceiro. Assim, embora
                    sejamos, em geral, responsáveis pelos dados pessoais que tratamos, nos eximimos de
                    responsabilidade caso ocorra uma situação excepcional como essas, sobre as quais não
                    temos nenhum tipo de controle.
                </p>

                <p>
                    De qualquer forma, caso ocorra qualquer tipo de incidente de segurança que possa gerar
                    risco ou dano relevante para qualquer de nossos usuários, comunicaremos os afetados e a
                    Autoridade Nacional de Proteção de Dados acerca do ocorrido, em conformidade com o
                    disposto na Lei Geral de Proteção de Dados.
                </p>

                <p>
                <h5>9. Reclamação a uma autoridade de controle</h5>
                </p>

                <p>
                    Sem prejuízo de qualquer outra via de recurso administrativo ou judicial, os titulares de
                    dados pessoais que se sentirem, de qualquer forma, lesados, podem apresentar reclamação
                    à Autoridade Nacional de Proteção de Dados.
                </p>

                <p>
                <h5>10. Alterações nesta política</h5>
                </p>

                <p>
                    A presente versão desta Política de Privacidade foi atualizada pela última vez em:
                    21/11/2022.
                </p>

                <p>
                    Reservamo-nos o direito de modificar, a qualquer momento, as presentes normas,
                    especialmente para adaptá-las às eventuais alterações feitas em nosso site, seja pela
                    disponibilização de novas funcionalidades, seja pela supressão ou modificação daquelas já
                    existentes.
                </p>

                <p>
                    Sempre que houver uma modificação, nossos usuários serão notificados acerca da
                    mudança.
                </p>

                <p><h5>11. Como entrar em contato conosco</h5></p>

                <p>
                    Telefone: {{ $user->telephone }}
                </p>
                <p>
                    Email: {{ $user->email }}
                </p>
                @if (env('IS_TREVO_MINAS'))
                    <p>
                        AGENCY RAUEN <br>
                        00.000.000/0001-00
                    </p>
                @endif
            </div>
        </div>
        <br>
        @include('layouts.footer')
    </div>

    <br>
@endsection
