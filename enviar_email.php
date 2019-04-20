<?php

$nome =  $_POST['txtNome'];
$email =  $_POST['txtEmail'];
$telefone = $_POST['txtTelefone'];
$mensagem_form =  $_POST['txtMensagem'];

if($nome==""){
	echo "<script>window.alert('Campo nome não pode estar em branco');</script>";
	echo "<script>history.back();</script>";
	exit;	
}

if($telefone==""){
	echo "<script>window.alert('Campo telefone não pode estar em branco');</script>";
	echo "<script>history.back();</script>";
	exit;	
}

/* Destinatário e remetente - EDITAR SOMENTE ESTE BLOCO DO CÓDIGO */
	$to = "marcelo_galvao@hotmail.com";
	$remetente = "contato@aulasenac.esy.es"; // Deve ser um email válido do domínio
    $assunto = "Contato pelo site";
	
    /* Cabeçalho da mensagem  */
    $email_headers = implode ( "\n",array ( "From: $remetente", "Reply-To: $email", "Return-Path: $email","MIME-Version: 1.0","X-Priority: 3","Content-Type: text/html; charset=UTF-8" ) );


    /* Layout da mensagem  */
    $corpo_mensagem = " 
    <br><h3>Solicitação Contato</h3>
    <br>----------------------------------------------------------------<br>
    <br><strong>Nome:</strong> $nome <br>
    <br><strong>Email:</strong> $email <br>
    <br><strong>Telefone:</strong> $telefone <br>
    <br><strong>Mensagem:</strong> $mensagem_form <br>
    <br>----------------------------------------------------------------
    ";

    /* Função que envia a mensagem  */
    if(mail($to, $assunto, $corpo_mensagem, $email_headers))
        {

            echo "<script>
						  window.alert('Solicitação enviada com sucesso!');
						  history.back(-1);
				  </script>";
        } 
            else
        {
            echo "<script>window.alert('Nao foi possivel enviar sua solicitação!');history.back(-1);</script>";
        }
?>