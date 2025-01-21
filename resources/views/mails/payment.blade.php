<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
	<meta charset="utf-8" />
	<!-- utf-8 works for most cases -->
	<meta name="viewport" content="width=device-width" />
	<!-- Forcing initial-scale shouldn't be necessary -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<!-- Use the latest (edge) version of IE rendering engine -->
	<meta name="x-apple-disable-message-reformatting" />
	<!-- Disable auto-scale in iOS 10 Mail entirely -->
	<title></title>
	<!-- The title tag shows in email notifications, like Android 4.4. -->

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet" />

	<!-- Progressive Enhancements : BEGIN -->
	<style>
		/*BUTTON*/
		.btn {
			padding: 10px 15px;
			display: inline-block;
		}

		.btn.btn-primary {
			border-radius: 5px;
			background: #2600ff;
			color: #ffffff;
			text-decoration: none;
		}

		.btn.btn-white {
			border-radius: 5px;
			background: #ffffff;
			color: #000000;
		}

		.btn.btn-white-outline {
			border-radius: 5px;
			background: transparent;
			border: 1px solid #fff;
			color: #fff;
		}

		.btn.btn-black-outline {
			border-radius: 0px;
			background: transparent;
			border: 2px solid #000;
			color: #000;
			font-weight: 700;
		}

		h1,
		h2,
		h3,
		h4,
		h5,
		h6 {
			font-family: "Lato", sans-serif;
			color: #000000;
			margin-top: 0;
			font-weight: 400;
		}

		body {
			font-family: "Lato", sans-serif;
			font-weight: 400;
			font-size: 15px;
			line-height: 1.8;
			color: rgba(0, 0, 0, 0.4);
		}

		a {
			color: #2600ff;
		}

		.logo h1 a {
			text-decoration: none;
		}
	</style>
</head>

<body width="100%" style="
      margin: 0;
      padding: 0 !important;
      mso-line-height-rule: exactly;
      background-color: #f1f1f1;
    ">
	<center style="width: 100%; background-color: #f1f1f1">
		<div style="
          display: none;
          font-size: 1px;
          max-height: 0px;
          max-width: 0px;
          opacity: 0;
          overflow: hidden;
          mso-hide: all;
          font-family: sans-serif;
        "></div>
		<div style="max-width: 600px; margin: 0 auto" class="email-container">
			<!-- BEGIN BODY -->
			<table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto; background-color: #e6e9ff">
				<tr>
					<td valign="top" class="bg_white" style="padding: 1em 2.5em 0 2.5em">
						<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td class="logo" style="text-align: center">
									<h1><a href="#">{{ $dados['environment'] }}</a></h1>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<!-- end tr -->
				<tr>
					<td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0">
						<table>
							<tr>
								<td>
									<div class="text" style="padding: 0 2.5em">
										Olá {{ $dados['name'] }},
										<br /><br />

										Você acabou de comprar a(s) cota(s) <b>{{ $dados['raffles']
                      }}</b> do sorteio <b>{{ $dados['productID'] }} - {{
                      $dados['product'] }}</b><br /><br />

										Obrigado por participar e boa sorte!!!<br /><br />

										Ver todos os meus números do sorteio {{
                      $dados['productID'] }} - {{ $dados['product'] }}<br /><br />
										<a href="{{ $dados['searchMyRaffles'] }}" class="btn btn-primary">Ver meus números</a><br /><br />

										Siga-nos nas redes sociais e acompanhe os resultados<br /><br />

										<a href="https://instagram.com/{{ $dados['instagram'] }}">Instagram :)</a><br />
										<a href="https://facebook.com/{{ $dados['facebook'] }}">Facebook :)</a><br /><br />

										Qualquer dúvida estamos a disposição.
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<!-- end tr -->
				<!-- 1 Column Text + Button : END -->
			</table>
		</div>
	</center>
</body>

</html>