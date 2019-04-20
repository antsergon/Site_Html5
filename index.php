<?php include_once("admin/funcoes/conexao.php"); ?>


<?php
if(isset($_POST['btn_enviar'])) {
   
	/* Valores recebidos do formulário  */
	$arquivo = $_FILES['arquivo'];
	$nome = $_POST['username'];
	$mensagem_form = $_POST['message'];
	$login = $_POST['login'];
	$email = $_POST['email'];
	$assunto="Comprovante de Pagamento ORIGINAL CS";
	
	if($nome=="") {
		echo "<script>window.alert('Campo NOME deve ser preenchido!');history.back(-1);</script>";
		exit;
	}
	if($email=="") {
		echo "<script>window.alert('Campo EMAIL deve ser preenchido!');history.back(-1);</script>";
		exit;
	}
	if($login=="") {
		echo "<script>window.alert('Campo LOGIN deve ser preenchido!');history.back(-1);</script>";
		exit;
	}
	
	/* Destinatário e remetente - EDITAR SOMENTE ESTE BLOCO DO CÓDIGO */
	$to = "originalcs.com@hotmail.com";
	$remetente = "comprovantes@originalcs.com.br"; // Deve ser um email válido do domínio
	 
	/* Cabeçalho da mensagem  */
	$boundary = "XYZ-" . date("dmYis") . "-ZYX";
	$headers = "MIME-Version: 1.0\n";
	$headers.= "From: $remetente\n";
	$headers.= "Reply-To: $replyto\n";
	$headers.= "Content-type: multipart/mixed; boundary=\"$boundary\"\r\n";  
	$headers.= "$boundary\n"; 
	 
	/* Layout da mensagem  */
	$corpo_mensagem = " 
	<br><h3>Comprovante de Pagamento ORIGINAL CS</h3>
	<br>----------------------------------------------------------------<br>
	<br><strong>Nome:</strong> $nome <br>
	<br><strong>Email:</strong> $email <br>
	<br><strong>Login:</strong> $login <br>
	<br>----------------------------------------------------------------
	";
	 
	/* Função que codifica o anexo para poder ser enviado na mensagem  */
	if(file_exists($arquivo["tmp_name"]) and !empty($arquivo)){
		
		$fp = fopen($_FILES["arquivo"]["tmp_name"],"rb"); // Abri o arquivo enviado.
		$anexo = fread($fp,filesize($_FILES["arquivo"]["tmp_name"])); // Le o arquivo aberto na linha anterior
		$anexo = base64_encode($anexo); // Codifica os dados com MIME para o e-mail 
		fclose($fp); // Fecha o arquivo aberto anteriormente
		$anexo = chunk_split($anexo); // Divide a variável do arquivo em pequenos pedaços para poder enviar
		$mensagem = "--$boundary\n"; // Nas linhas abaixo possuem os parâmetros de formatação e codificação, juntamente com a inclusão do arquivo anexado no corpo da mensagem
		$mensagem.= "Content-Transfer-Encoding: 8bits\n"; 
		$mensagem.= "Content-Type: text/html; charset=\"utf-8\"\n\n";
		$mensagem.= "$corpo_mensagem\n"; 
		$mensagem.= "--$boundary\n"; 
		$mensagem.= "Content-Type: ".$arquivo["type"]."\n";  
		$mensagem.= "Content-Disposition: attachment; filename=\"".$arquivo["name"]."\"\n";  
		$mensagem.= "Content-Transfer-Encoding: base64\n\n";  
		$mensagem.= "$anexo\n";  
		$mensagem.= "--$boundary--\r\n"; 
	}
		else // Caso não tenha anexo
		{
			echo "<script>window.alert('Nao foi possivel carregar seu comprovante!');history.back(-1);</script>";
			exit;
	}
	 
	/* Função que envia a mensagem  */
	if(mail($to, $assunto, $mensagem, $headers))
		{
			echo "<script>window.alert('Comprovante enviado com sucesso!');history.back(-1);</script>";
		} 
			else
		{
			echo "<script>window.alert('Nao foi possivel carregar seu comprovante!');history.back(-1);</script>";
		}
}
?>

<?php

if(isset($_POST['btn_solicitar'])) {
   
	 /* Valores recebidos do formulário  */
    $nome = $_POST['txtNome'];
    $mensagem_form = $_POST['txtMensagem'];
    $email = $_POST['txtEmail'];
    $tipo = $_POST['txtTipo'];
    $assunto="Solicitação IPTV : Original CS";

    /* Destinatário e remetente - EDITAR SOMENTE ESTE BLOCO DO CÓDIGO */
	$to = "originalcs.com@hotmail.com";
	$remetente = "comprovantes@originalcs.com.br"; // Deve ser um email válido do domínio
    
    /* Cabeçalho da mensagem  */
    $email_headers = implode ( "\n",array ( "From: $remetente", "Reply-To: $email", "Return-Path: $email","MIME-Version: 1.0","X-Priority: 3","Content-Type: text/html; charset=UTF-8" ) );


    /* Layout da mensagem  */
    $corpo_mensagem = " 
    <br><h3>Solicitação IPTV : Original CS</h3>
    <br>----------------------------------------------------------------<br>
    <br><strong>Nome:</strong> $nome <br>
    <br><strong>Email:</strong> $email <br>
    <br><strong>Solitado:</strong> $tipo <br>
    <br><strong>Mensagem:</strong> $mensagem_form <br>
    <br>----------------------------------------------------------------
    ";

    /* Função que envia a mensagem  */
    if(mail($to, $assunto, $corpo_mensagem, $email_headers))
        {

            echo "<script>window.alert('Solicitação enviada com sucesso!');history.back(-1);</script>";
        } 
            else
        {
            echo "<script>window.alert('Nao foi possivel enviar sua solicitação!');history.back(-1);</script>";
        }
}
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Original CS :: Servidor CS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"> 

    <!-- Loading Bootstrap -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet"> 
    <link href="css/responsive.css" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="js/rs-plugin/css/settings.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox.css" media="screen" />

    <link rel="stylesheet" href="css/skins/default.css" data-name="skins">
    <link rel="stylesheet" type="text/css" href="css/switcher.css" media="screen" />


    <!-- Loading Flat UI -->
    <link href="css/flat-ui.css" rel="stylesheet">

    <!--<link rel="shortcut icon" href="images/favicon.ico">-->
	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
	
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
    <![endif]-->
</head>

<body>

	<header id ="top" class="mTop">
		<div class="topHead">
			<div class="container">
				<div class="row">

				</div>
			</div>
		</div>
		<div class="headContent">
			<div class="container">
				<div class="row">
					<div class="span4">
						<div class="brand">
							<a href="#top"><img src="images/logo.png" alt="Logo"></a>
						</div>
					</div>
					<div class="span8">
						<div class="menu" id="steak">
							<nav>
								<ul class="navMenu inline-list" id="nav" style="margin-left:-30px"> 
									<!--<li class="current"><a href="#top">Home</a></li>-->
									<li class="current"><a href="#about">Quem Somos</a></li>
									<li><a href="#iptv"><span style="color:red; font-style:bolder">* </span>IPTV<span style="color:red; font-style:bolder"> *</span></a></li>
									<li><a href="#team">Planos</a></li>
                                    <li><a href="#service">Contas</a></li>
                                    <li><a href="#teste">Testes</a></li>
									<li><a href="#portfolio">Tutoriais</a></li>
									<li><a href="#blog">Trailers</a></li>
                                    
									<li><a href="#contact">Comprovante</a></li>
								</ul>
								<div class="clearfix"></div>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	
	<!--Slider-->
	<section class="revSlider">
		<!-- START REVOLUTION SLIDER 2.3.91 -->
			<div class="fullwidthbanner-container">
                <div class="fullwidthbanner">
                    <ul>
                        <?php
                            $sql = mysql_query("SELECT * FROM galeria_home");
                            while ($linha = mysql_fetch_assoc($sql)) {
                                $image = $linha['file_galeria'];
                        ?>
                        <!-- SLIDEUP -->
                        <li data-transition="slide-Up" data-slotamount="7" data-thumb="img/revslider/transparent.png">
                            <?php echo '<img src="admin/files/'.$linha["file_galeria"].'" title="'.$linha["titulo_galeria"].'" alt"'.$linha["alt_galeria"].'" />'; ?>
                            
                            <div class="tp-caption plasma_def lft" data-x="300" data-y="130" data-speed="700" data-start="1200" data-easing="easeOutExpo">
                                ORIGINAL CS :: Servidor CS
                            </div>

                            <div class="tp-caption plasma_inverse lfl" data-x="325" data-y="192" data-speed="600" data-start="1900" data-easing="easeOutBack">
                                Servidor Fibra Optica
                            </div>
                            
                            <div class="tp-caption plasma_white lfb" data-x="400" data-y="254" data-speed="500" data-start="2700" data-easing="easeOutBack">
                                Full Duplex
                            </div>
                        
                        </li>
                        <?php } ?> 
                    </ul>
                    
                </div>
            </div>
	</section>
	
	<!--Quem Somos-->
	<section id="about" class="about grey">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="titleHead">
						<h3>Original CS :: Servidor CS</h3>
						<p>Servidor Fibra Óptica Full Duplex <br/>Net HD / Claro / Sky / Oi</p>
					</div>
					<!--DIVIDER-->
					<!--<div class="divider">
						<div class="divLine"></div>
						<div class="divImg">
							<i class="icon fui-user"></i>
						</div>
						<div class="divLine"></div>
					</div>-->
				</div>
			</div>
			
			<div class="row">	
				<div class="span12" style="text-align:justify; line-height:20px">
                    <?php
						$sql = mysql_query("SELECT * FROM quem");
						while ($linha = mysql_fetch_assoc($sql)) {
					?>
                    
					<p style="text-align:justify"><?php echo $linha['texto_quem'];?></p>
                    
                    <?php } ?>
					<div class="mrg-30"></div>
					<div class="clearfix"></div>
				</div>
			</div> 
		</div>
	</section>

	<!--About-->
	<section id="iptv" class="about white">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="titleHead">
						<h3>IPTV</h3>
						<p>Chegou o que faltava!</p>
					</div>
					<!--DIVIDER-->
					<div class="divider">
						<div class="divLine"></div>
						<div class="divImg">
							<i class="icon fui-user"></i>
						</div>
						<div class="divLine"></div>
					</div>
				</div>
			</div>
			
			<div class="row">	
				<div class="span12">
					<div class="flex-container"><!-- flex slider starts-->
						<div class="flexslider">
							<ul class="slides round">
								<li style="margin-top:-20px"><img src="images/iptv.jpg" alt=""/></li>
							</ul>
						</div>
					</div><!-- flex slider ends-->
					
				</div>

				<div class="span6">
					<div class="titleContent">
						<h6><span>Sobre IPTV</span></h6>
					</div>
					<div class="description">
						<p style="text-align:justify"><span class="dropcap colDefault">IPTV </span>É um método de transmissão de canais de TV através do protocolo da internet (IP), ou seja, ao invés de receber o sinal da TV através de antenas basta uma simples conexão com a web (preferencialmente conexões acima de 10MB) para receber os sinais de TV.</p>
						
					<p style="text-align:justify">
                        <span class="colDefault">Na transmissão IPTV</span> o conteúdo é enviado apenas em streaming, porém com garantia de qualidade na entrega. O <strong>receptor pode ser o computador, SMARTVs ou até videogames como o Xbox e o PlayStation, sendo mais comum o uso tablets e smartphones</strong> <span class="highlight black">ANDROID e IPHONE.</span> Quando você está assistindo um programa ou filme por IPTV, você não está fazendo o download do filme, você está fazendo o download de uma parte do arquivo, assistindo e enquanto isso fazendo o download da próxima parte. Entretanto nenhuma parte esta sendo armazenada por muito tempo.<br><br>
                        Agora também, disponibilizamos as maiores bilheterias que acabaram de sair do cinema... <span class="highlight black">Filmes ONDEMAND</span> em alta resolução... a qualquer hora... em qualquer lugar!<br><br>
                        <span class="highlight black">FILMES ADULTOS</span> em HD de alta qualidade. 
					</p>
					<p>
						<span class="colDefault">Venha fazer parte da nossa família!</span> <br><br>Obtenha acesso grátis por <strong>4 horas</strong> e comprove nossos serviços. 
					</p>
					</div>
				</div>
				
				<div class="contact_info span6" style="margin-top:-0px">
					<div class="titleContent">
						<h6><span>Sobre IPTV</span></h6>
					</div>
				<!-- #contact-form -->
					<form id="contact-form" name="contact-form" method="post" action="index.php">
						<div class="row-fluid">
							<p class="span6"><input id="txtNome" name="txtNome" type="text" tabindex="1" value="" placeholder="Nome (obrigatorio)"></p>
							<p class="span6"><input id="txtEmail" name="txtEmail" type="text" tabindex="2" value="" placeholder="E-mail (obrigatorio)"></p>
                            <p class="span6">
                                <select style="height:50px; width:300px; margin: 10px 0px 20px -9px; color:#ccc; font-size:15px; border:2px solid #ccc" id="txtTipo" name="txtTipo" tabindex="3" >
                                    <option value="SD">Selecione</option>
                                    <option value="SD+ONDEMAND">ONDEMAND</option>
                                </select>
                            </p>
						</div>
						<div class="row">
							<p class="span6"><textarea id="txtMensagem" name="txtMensagem" tabindex="4" rows="6" placeholder="Mensagem"></textarea></p>
						</div>
						<div class="row">
							<div class="span2">
                            	<input type="submit" name="btn_solicitar" value="Solicitar Teste Grátis" id="btn_solicitar" class="btn btn-embossed btn-large btn-primary" style="width:200px" />
								<!--<button id="sending" type="submit" class="btn btn-embossed btn-large btn-primary" data-send="Enviando...">Enviar</button>-->
							</div>
						</div>
					</form>

					<!-- /#contact-form -->
				</div>

			</div> <!--./row-->

			
		</div>
	</section>


<!--Team-->
	<section id="team" class="team grey">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="titleHead">
						<h3>Planos</h3>
						<p>Selecione um de nossos planos e nos envie cópia do comprovante por email.</p>
					</div>
					
					<!--DIVIDER-->
					<!--<div class="divider">
						<div class="divLine"></div>
						<div class="divImg">
							<i class="icon fui-myspace"></i>
						</div>
						<div class="divLine"></div>
					</div>-->
				</div>
			
			<!-- myTeam Widget -->
			<div class="myTeam">
				<div class="profile">
					<div class="span3 profPeople">
						<div class="photoTeam">
							<img src="images/logo-net.png" alt="">
						</div>
						<div class="info">
								<span class="name">NET HD</span>
								<span class="job" style="font-weight:bolder;font-size:15px;">R$ 20,00 / mensais</span>
							<p>
                            	<ul style="list-style-type:none;text-align:left; margin-left:10px; font-size:13px">
                            		<li>Mensal: R$ 20,00 - R$ 0,66/dia</li>
                                    <li>Bimestral: R$ 30,00 - R$ 0,50/dia</li>
                                    <li>Trimestral: R$ 40,00 - R$ 0,44/dia</li>
                                    <li>Semestral: R$ 70,00 - R$ 0,38/dia</li>
                                    <li>Grade completa de canais</li>
                                    <br>
                            		<a style="margin-left:20%;" class="btn btn-small btn-primary btn-embossed" href="http://controle2.noip.us/originalcs2/login_cadastro/?i=VQXGZSFG&i2=VQBiZSBiZ1BYVWFaVgN7DkBsV5FGZuB/VQNGH9JeHSvOZMFaVgN7ZSrCV5FqZuJsVQFYZSBiZ1Be" target="_blank">Teste Gratis 24hs</a>
                            	</ul>
                            </p>
						</div>
					</div>

					<div class="span3 profPeople">
						<div class="photoTeam">
							<img src="images/logo-tri.png" alt="">
						</div>
						<div class="info">
								<span class="name">Sat Simples</span>
								<span class="job">Login para 1 receptor e 1 operadora</span>
							<p>
                            	<ul style="list-style-type:none;text-align:left; margin-left:10px; font-size:13px">
                            		<li>Mensal: R$ 15,00 - R$ 0,50/dia</li>
                                    <li>Bimestral: R$ 28,00 - R$ 0,46/dia</li>
                                    <li>Trimestral: R$ 40,00 - R$ 0,44/dia</li>
                                    <li>Semestral: R$ 70,00 - R$ 0,38/dia</li>
                                    <li>Anual: R$ 120,00 - R$ 0,32/dia</li>
                                    <br>
                            		<a style="margin-left:20%;" class="btn btn-small btn-primary btn-embossed" href="http://controle2.noip.us/originalcs2/login_cadastro/?i=VQXG&i2=VQJwZSBiZ1zGVWJsVgN7DkBsV5X/ZuB/VQNGH9BqHSvOZMB/VgN7ZSrCV5B7ZuFaVQFYZSBiZ1zG" target="_blank">Teste Gratis 24hs</a>
                            	</ul>
                            </p>
						</div>
					</div>
						
					<div class="span3 profPeople">
						<div class="photoTeam">
							<img src="images/logo-tri.png" alt="">
						</div>
						<div class="info">
								<span class="name">Sat Duplo</span>
								<span class="job">Login para 1 receptor e 2 operadoras</span>
							<p>
                            	<ul style="list-style-type:none;text-align:left; margin-left:10px; font-size:13px">
                            		<li>Mensal: R$ 20,00 - R$ 0,66/dia</li>
                                    <li>Bimestral: R$ 37,00 - R$ 0,61/dia</li>
                                    <li>Trimestral: R$ 50,00 - R$ 0,55/dia</li>
                                    <li>Semestral: R$ 90,00 - R$ 0,50/dia</li>
                                    <li>Anual: R$ 150,00 - R$ 0,41/dia</li>
                                    <br>
                            		<a style="margin-left:20%;" class="btn btn-small btn-primary btn-embossed" href="http://controle2.noip.us/originalcs2/login_cadastro/?i=VQXG&i2=VQJwZSBiZ1zGVWJsVgN7DkBsV5X/ZuB/VQNGH9BqHSvOZMB/VgN7ZSrCV5B7ZuFaVQFYZSBiZ1zG" target="_blank">Teste Gratis 24hs</a>
                            	</ul>
                            </p>
						</div>
					</div>
						
					<div class="span3 profPeople">
						<div class="photoTeam">
							<img src="images/logo-tri.png" alt="">
						</div>
						<div class="info">
								<span class="name">Sat Triplo</span>
								<span class="job">Login para 1 receptor e 3 operadoras</span>
							<p>
                            	<ul style="list-style-type:none;text-align:left; margin-left:10px; font-size:13px;">
                            		<li>Mensal: R$ 25,00 - R$ 0,83/dia</li>
                                    <li>Bimestral: R$ 45,00 - R$ 0,75/dia</li>
                                    <li>Trimestral: R$ 60,00 - R$ 0,66/dia</li>
                                    <li>Semestral: R$ 100,00 - R$ 0,55/dia</li>
                                    <li>Anual: R$ 170,00 - R$ 0,46/dia</li>
                                    <br>
                            		<a style="margin-left:20%" class="btn btn-small btn-primary btn-embossed" href="http://controle2.noip.us/originalcs2/login_cadastro/?i=VQXG&i2=VQJwZSBiZ1zGVWJsVgN7DkBsV5X/ZuB/VQNGH9BqHSvOZMB/VgN7ZSrCV5B7ZuFaVQFYZSBiZ1zG" target="_blank">Teste Gratis 24hs</a>
                                </ul>
                            </p>
						</div>
					</div>
					
					</div>
				</div> <!--end row-->
			</div>
		</div>
	</section>
    
    <!--SEPARATOR-->
	<!--<section class="separator default">
		<div class="container">
			<div class="row">
				<div class="span12 text-center">
					<h5 style="color:#fff">Solicite teste NET HD</h5>
                   <iframe style="background-color:#FF0004" src="http://controle2.noip.us/originalcs2/login_cadastro/?i=VQXGZSFG&i2=VQBiZSBiZ1BYVWFaVgN7DkBsV5FGZuB/VQNGH9JeHSvOZMFaVgN7ZSrCV5FqZuJsVQFYZSBiZ1Be" width="100%" height="330" scrolling="no" frameborder="0" align="middle"></iframe>
				</div>
			</div>
		</div>
	</section>-->



	<!--SERVICES-->
	<section id="service" class="services">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="titleHead">
						<h3>Contas Bancárias</h3>
						<p>Selecione uma de nossas contas bancárias para depósito/transferência e nos envie o comprovante por email.</p>
					</div>
				</div>
			</div>

			<div class="row">
					<div class="span4 servContent">
						<div class="ico">
							<img src="images/logo-itau.png" alt="Banco Itau">
						</div>
						<div class="servDetil">
                            <h4>Banco Itau</h4>
                            <p>Conta Poupança</p>
                            <ul>
                                <li>Agencia 0158</li>
                                <li>C/P 58315-3</li>
                                <li>Operação 500</li>
                                <li>Camila C. dos S. Ferretti</li>
                            </ul>
						</div>
					</div>

					<div class="span4 servContent">
						<div class="ico">
							<img src="images/logo-bradesco.png" alt="Banco Bradesco">
						</div>
						<div class="servDetil">
						 	<h4>Banco Bradesco</h4>
                            <p>Conta Corrente</p>
                            <ul>
                                <li>Agencia 1273-4</li>
                                <li>C/C 0023104-5</li>
                                <li>Rafael Ferretti</li>
                            </ul>
						</div>
					</div>

					<div class="span4 servContent">
						<div class="ico">
							<img src="images/logo-bb.png" alt="Banco do Brasil">
						</div>
						<div class="servDetil">
							<h4>Banco do Brasil</h4>
                            <p>Conta Poupança</p>
                            <ul>
                                <li>Agencia 6518-8</li>
                                <li>C/P 15769-4</li>
                                <li>Variação 51</li>
                                <li>Camila C. dos S. Ferretti</li>
                            </ul>
						</div>
					</div>

					<div class="span4 servContent">
						<div class="ico">
							<img src="images/logo-cef.png" alt="Caixa Economica Federal">
						</div>
						<div class="servDetil">
							<h4>CEF</h4>
                            <p>Conta Poupança</p>
                            <ul>
                                <li>Agencia 0798</li>
                                <li>C/P 0004105-1</li>
                                <li>Operação 013</li>
                                <li>Rafael Ferretti</li>
                            </ul>
                        </div>
					</div>

					<div class="span4 servContent">
						<div class="ico">
							<img src="images/logo-cef.png" alt="Caixa Economica Federal">
						</div>
						<div class="servDetil">
							<h4>CEF</h4>
                            <p>Conta Corrente</p>
                            <ul>
                                <li>Agencia 0360</li>
                                <li>C/C 00024847-5</li>
                                <li>Operação 001</li>
                                <li>Camila C. dos S. Ferretti</li>
                            </ul>
						</div>
					</div>

					<div class="span4 servContent">
						<div class="ico">
							<img src="images/logo-cef.png" alt="Caixa Economica Federal">
						</div>
						<div class="servDetil">
							<h4>CEF</h4>
                            <p>Conta Poupança</p>
                            <ul>
                                <li>Agencia 0360</li>
                                <li>C/P 00013277-2</li>
                                <li>Operação 013</li>
                                <li>Camila C. dos S. Ferretti</li>
                            </ul>
						</div>
					</div>
			</div>
		</div>
	</section>

	

	<!--SEPARATOR-->
	<section id="teste" class="separator default">
		<div class="container">
			<div class="row">
				<div class="span12 text-center">
					<h5 style="color:#fff">Solicite teste NET HD 24hs Gratis</h5>
                    <br>
                    <a href="cidades.php" target="_blank">Veja aqui as cidades atendidas pelos nossos servidores.</a>
                    <br><br>
                    <!--<a href="http://controle2.noip.us/originalcs2/login_cadastro/?i=VQXGZSFG&i2=VQBiZSBiZ1BYVWFaVgN7DkBsV5FGZuB/VQNGH9JeHSvOZMFaVgN7ZSrCV5FqZuJsVQFYZSBiZ1Be" target="_blank"
>                    <h5>Clique aqui e solicite um teste gratis por 24hs</h5>
                    <h5> NET HD </h5>
                    </a>-->
                   <iframe src="http://controle2.noip.us/originalcs2/login_cadastro/?i=VQXGZSFG&i2=VQBiZSBiZ1BYVWFaVgN7DkBsV5FGZuB/VQNGH9JeHSvOZMFaVgN7ZSrCV5FqZuJsVQFYZSBiZ1Be" width="100%" height="330" scrolling="no" frameborder="0" align="middle"></iframe>
				</div>
			</div>
            <br>
            <br>
            <div class="row">
				<div class="span12 text-center">
					<h5 style="color:#fff">Solicite teste Satelite (Sky/Claro/Oi) 24hs Gratis</h5>
                    <a href="http://controle2.noip.us/originalcs2/login_cadastro/?i=VQXG&i2=VQJwZSBiZ1zGVWJsVgN7DkBsV5X/ZuB/VQNGH9BqHSvOZMB/VgN7ZSrCV5B7ZuFaVQFYZSBiZ1zG" target="_blank"
>                    <h5>Clique aqui e solicite um teste gratis por 24hs</h5>
                    <h5> Selecione Sky/Claro/Oi </h5>
                    </a>
                   <!--<iframe src="http://controle2.noip.us/originalcs2/login_cadastro/?i=VQXG&i2=VQJwZSBiZ1zGVWJsVgN7DkBsV5X/ZuB/VQNGH9BqHSvOZMB/VgN7ZSrCV5B7ZuFaVQFYZSBiZ1zG" width="100%" height="330" scrolling="no" frameborder="0" align="middle"></iframe>-->
				</div>
			</div>
		</div>
	</section>

	<!--Portfolio-->
	<section id="portfolio" class="portfolio">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="titleHead">
						<h3>Tutoriais</h3>
						<p>Confira nossos tutoriais para configuração de seu decoder.</p>
					</div>
				</div>
			</div>

			<div class="row">
	            <div class="isotope">
	                <ul id="list" class="portfolio_list">
						<?php
                            $resgata = mysql_query ("SELECT * FROM tutoriais ORDER BY id_tutoriais DESC LIMIT 15");	
                            while ($linha = mysql_fetch_array($resgata)){
                            $video_trailers	= $linha['video_tutoriais'];	
                        ?>
	                    <li class="list_item span4 responsive">
	                        <div class="view view-first">
	                            <a href="images/photos/project_1.jpg" class="fancybox" data-rel="gallery1" title="Tolpis barbata (mariluzpicado)">
	                                <?php echo $video_trailers;?>
	                            </a>
	                        </div>
	                    </li>
                        <?php } ?>
	                </ul>	                
	            </div>
			</div>
		</div>	
	</section>

	<!--Blog-->
	<section id="blog" class="blog grey">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="titleHead">
						<h3>Trailers</h3>
						<p>Ultimos lançamentos do cinema direto na sua TV.</p>
					</div>
				</div>
			</div>

			<div class="row">
	            <div class="isotope">
	                <ul id="list" class="portfolio_list">
                    	<?php
                            $resgata = mysql_query ("SELECT * FROM trailers ORDER BY id_trailers DESC LIMIT 15");	
                            while ($linha = mysql_fetch_array($resgata)){
                            $video_trailers	= $linha['video_trailers'];	
                        ?>
	                    <li class="list_item span4 responsive">
	                        <div class="view view-first">
	                            <a href="images/photos/project_1.jpg" class="fancybox" data-rel="gallery1" title="Tolpis barbata (mariluzpicado)">
	                                <?php echo $video_trailers ?>
	                            </a>
	                        </div>
	                    </li>
                        <?php } ?>
	                </ul>	                
	            </div>
			</div>
		</div>	
	</section>

	<!--Contact-->
	<section id="contact" class="contact">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="titleHead">
						<h3>Contatos</h3>
					</div>
				</div>
			</div>	


			<!-- Contact Form -->
			<div class="row">
		
				<div class="span12">
					<div style="height:1px;" id="map"></div> 
				</div>
				
				<div class="contact_info span6">
					<h6><span>Comprovante</span></h6>
					<div class="row">
						<address class="adr span6">
							<span class="web">
								<em class="icon-skype"></em>
								<a href="#" title="skype" alt="skype">originalcs.com@hotmail.com</a>
							</span>
							<br/>
							<span class="web">
								<em class="icon-mail-forward"></em>
								<a href="mailto:originalcs.com@hotmail.com" title="email" alt="email"> originalcs.com@hotmail.com</a>
							</span>
							<br/>
						</address>
					</div>
					<!-- End Contact Form -->
				</div>
				
				
				<div class="contact_info span5">
					<h6><span>Envie seu Comprovante</span></h6>
				<!-- #contact-form -->
					<form id="contact-form" name="contact-form" method="post" action="index.php" enctype="multipart/form-data">
						<div class="row-fluid">
							<p class="span6"><input id="username" name="username" type="text" tabindex="1" value="" placeholder="Nome (obrigatorio)"></p>
							<p class="span6"><input id="email" name="email" type="text" tabindex="2" value="" placeholder="E-mail (obrigatorio)"></p>
						</div>
                        <div class="row-fluid">
                            <p class="span6"><input id="email" name="login" type="text" tabindex="3" value="" placeholder="Login (obrigatorio)"></p>
						</div>
                        <div class="row">
							 <p class="span6">Comprovante:</p>
                             <p class="span6"><input type="file" id="arquivo" name="arquivo" tabindex="4" /></p>
						</div>
						<div class="row">
							<p class="span6"><textarea id="message" name="message" tabindex="4" rows="6" placeholder="Mensagem"></textarea></p>
						</div>
						<div class="row">
							<div class="span2">
                            	<input type="submit" name="btn_enviar" value="Enviar" class="btn btn-embossed btn-large btn-primary" />
								<!--<button id="sending" type="submit" class="btn btn-embossed btn-large btn-primary" data-send="Enviando...">Enviar</button>-->
							</div>
						</div>
					</form>

					<!-- /#contact-form -->
				</div>
			</div>
		</div>
	</section>

	<!--Footer-->
	<footer class="footer grey">
		<div class="container">
			<div class="row">
				<div class="span6">
					<div class="copyright">
						<p>OriginalCS :: Servidor CS &copy; 2016. Todos os direitos reservados. </p>
					</div>
				</div>
			</div>
		</div>
	</footer>

	<!-- Load JS here for greater good =============================-->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&language=en"></script>
	<script type="text/javascript" src="js/jquery.cookie.js"></script>
	<script type="text/javascript" src="js/styleswitch.js"></script>
	<script type="text/javascript" src="js/jquery.nav.js"></script>
	<script type="text/javascript" src="js/jquery.sticky.js"></script>
	<script type="text/javascript" src="js/jquery.parallax-1.1.3.js"></script>
	<script type="text/javascript" src="js/jquery.lavalamp-1.4.js"></script>
	<script type="text/javascript" src="js/jquery.scrollTo.js"></script>

	<script type="text/javascript" src="js/rs-plugin/js/jquery.themepunch.plugins.min.js"></script>
	<script type="text/javascript" src="js/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
	<script type="text/javascript" src="js/jquery.carouFredSel-6.1.0-packed.js"></script> 
	<script type="text/javascript" src="js/jquery.bxslider.min.js"></script>
	<script type="text/javascript" src="js/jquery.colorbox.js"></script>    
	<script type="text/javascript" src="js/jquery.isotope.min.js"></script>
	<script type="text/javascript" src="js/fancybox/jquery.fancybox.pack.js"></script>
	<script type="text/javascript" src="js/jquery.gmap.js"></script>
	<script type="text/javascript" src="js/flex-slider.min.js"></script>
    <script type="text/javascript" src="js/jquery.placeholder.js"></script>
    <script type="text/javascript" src="js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="js/jquery.tweet.js"></script>

	<script type="text/javascript" src="js/main.js" charset="utf-8"></script>

</body>
</html>
