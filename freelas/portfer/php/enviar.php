<?php

	// $destinatario = 'fernandamontanher@yahoo.com.br';
	$destinatario = 'oliveira.douglas@outlook.com';

	$nomeDestinatario = 'Fernanda Montanher';

	$usuario = 'contato@novadelicia.com.br';

	$senha = 'ct159357';

	// abaixo as veriaveis principais, que devem conter em seu formulario
	$nome           = $_POST['nome'];
	$emailRemetente = $_POST['email'];
	$msg            = $_POST['msg'];
	$assunto        = "Email de contato!";
	$_POST['msg']   = nl2br('Nome: '. $nome ."\r\n". 'E-mail de retorno: '. $emailRemetente ."\r\n". 'Assunto: '. $_POST['msg']);

	// *********************************** A PARTIR DAQUI NAO ALTERAR ***********************************

	include_once("phpmailer/class.phpmailer.php");

	$To = $destinatario;
	$Subject = $assunto;
	$Message = $_POST['msg'];

	$Host     = 'smtp.'.substr(strstr($usuario, '@'), 1);
	$Port     = "587";
	$Username = $usuario;
	$Password = $senha;

	$mail = new PHPMailer();
	$body = $Message;
	$mail->CharSet   = 'UTF-8';
	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->Host      = $Host; // SMTP server
	$mail->SMTPDebug = 0; // enables SMTP debug information (for testing)
	$mail->SMTPAuth  = true; // enable SMTP authentication
	$mail->Port      = $Port; // set the SMTP port for the service server
	$mail->Username  = $Username; // account username
	$mail->Password  = $Password; // account password
	$mail->SetFrom($usuario, $nomeDestinatario);
	$mail->Subject   = $Subject;
	$mail->MsgHTML($body);
	$mail->AddAddress($To, "");

	if(!$mail->Send()) {
		$mensagemRetorno = 'Erro ao enviar e-mail: '. print($mail->ErrorInfo);
	} else {
		$mensagemRetorno = 'E-mail enviado com sucesso!';
	}

?>