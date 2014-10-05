<?php

	// $destinatario = 'fernandamontanher@yahoo.com.br';
	$destinatario = 'oliveira.douglas@outlook.com';

	$nomeDestinatario = 'Pronto Concursos';

	$usuario = 'contato@novadelicia.com.br';

	$senha = 'ct159357';

	// abaixo as veriaveis principais, que devem conter em seu formulario
	$nome           = $_POST['nome'];
	$emailRemetente = $_POST['email'];
	$telefone       = $_POST['tel'];
	$msg            = $_POST['msg'];
	$assunto        = "Email de contato!";
	$_POST['msg']   = nl2br('Nome: '. $nome ."\r\n". 'E-mail de retorno: '. $emailRemetente ."\r\n". 'Telefone: '. $telefone ."\r\n". 'Assunto: '. $_POST['msg']);

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

		$filename = 'teste.pdf';
		$downloaddir = '../tmp/';
		$safedir = '../downloads/';
		$downloadURL = 'http://localhost:8080/trampos/pronto_concursos/app/tmp/';

		$letters = 'abcdefghijklmnopqrstuvwxyz';
		srand((double) microtime() * 1000000);
		$string = '';
		for ($i = 1; $i <= rand(4,12); $i++) {
		   $q = rand(1,24);
		   $string = $string . $letters[$q];
		}
		$handle = opendir($downloaddir);
		while ($dir = readdir($handle)) {
		   if (is_dir($downloaddir . $dir)){
		      if ($dir != "." && $dir != ".."){
		         @unlink($downloaddir . $dir . "/" . $filename);
		         @rmdir($downloaddir . $dir);
		      }
		   }
		}
		closedir($handle);
		mkdir($downloaddir . $string, 0777);
		var_dump($safedir . $filename, $downloaddir . $string . "/" . $filename);
		symlink($safedir . $filename, $downloaddir . $string . "/" . $filename);
		// Header("Location: " . $downloadURL . $string . "/" . $filename);
	}

?>