<?php if(!defined('CHECAR_INCLUDE')) die('Você não tem permissão para executar esse arquivo diretamente');

function checarEmail($str)
{
	return preg_match("/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $str);
}


function enviarEmail($from,$to,$subject,$body)
{
	require_once('../PHPMailer_v5.1/class.phpmailer.php');
	
	$Email = new PHPMailer();
	$Email->SetLanguage("br");
	$Email->IsHTML(true); // envio como HTML se 'true'
	$Email->CharSet = "UTF-8";
	$Email->From = $from;
	$Email->FromName = "SAE";
	if(is_array($to)){
		for($i=0;$i<count($to);$i++){
			$Email->AddAddress($to[$i]);
		}
	} else {
		$Email->AddAddress($to);			
	}
//	$Email->AddBcc($email_c);			
	
	$Email->Subject = $subject;
	$Email->Body = $body;
/*	$headers = '';
	$headers .= "From: $from\n";
	$headers .= "Reply-to: $from\n";
	$headers .= "Return-Path: $from\n";
	$headers .= "Message-ID: <" . md5(uniqid(time())) . "@" . $_SERVER['SERVER_NAME'] . ">\n";
	$headers .= "MIME-Version: 1.0\n";
	$headers .= "Date: " . date('r', time()) . "\n";*/
	
	if(!$Email->Send()) {
	  echo "Mailer Error: " . $Email->ErrorInfo;
	} else {
	  return $Email->Send();
	}
	
}
?>