<?php

define('CHECAR_INCLUDE',true);

require 'config.php';
require 'funcoes.php';
// Este dois arquivos só podem ser incluidos se a variável CHECAR_INCLUDE estiver definida

session_name('aaLogin');
// Iniciando a sessão

session_set_cookie_params(2*7*24*60*60);
// Definindo o validade do cookie por 2 semanas

session_start();	

if($_SESSION['id'] && !isset($_COOKIE['aaLembrar']) && !$_SESSION['lembrarMe'])
{
	// Se você está logado, mas não tem o cookie aaLembrar (restart do navegador)
	// e você não marcou o checkbox lembrarMe (continuar conectado):

	$_SESSION = array();
	session_destroy();
	
	// Destrói a sessão
}


if(isset($_GET['logoff']))
{
	$_SESSION = array();
	session_destroy();
	
	header("Location: demo.php");
	exit;
}

if($_POST['submit']=='Login')
{
	// Checando se o formulário Login form foi enviado
	
	$err = array();
	// Outros erros
	
	
	if(!$_POST['usuario'] || !$_POST['senha'])
		$err[] = 'Todos os campos devem ser preenchidos!';
	
	if(!count($err))
	{
		$_POST['usuario'] = mysql_real_escape_string($_POST['usuario']);
		$_POST['senha'] = mysql_real_escape_string($_POST['senha']);
		$_POST['lembrarMe'] = (int)$_POST['lembrarMe'];
		
		// Limpando possíveis códigos maliciosos

		$row = mysql_fetch_assoc(mysql_query("SELECT id,usr FROM aa_membros WHERE usr='{$_POST['usuario']}' AND pass='".md5($_POST['senha'])."'"));

		if($row['usr'])
		{
			// Se tudo está OK, login
			
			$_SESSION['usr']=$row['usr'];
			$_SESSION['id'] = $row['id'];
			$_SESSION['lembrarMe'] = $_POST['lembrarMe'];
			
			// Armazena algum dado na sessão
			
			setcookie('aaLembrar',$_POST['lembrarMe']);
		}
		else $err[]='Usuário e/ou senha incorretos!';
	}
	
	if($err)
	$_SESSION['msg']['login-err'] = implode('<br />',$err);
	// Salva a mensagem de erro na sessão

	header("Location: demo.php");
	exit;
}
else if($_POST['submit']=='Cadastrar')
{
	// Se o formulário de Cadastro foi enviado
	
	$err = array();
	
	if(strlen($_POST['usuario'])<4 || strlen($_POST['usuario'])>32)
	{
		$err[]='Seu usuário deve ter no mínimo 3 a 32 caracteres!';
	}
	
	if(preg_match('/[^a-z0-9\-\_\.]+/i',$_POST['usuario']))
	{
		$err[]='Seu usuário contém caracteres inválidos!';
	}
	
	if(!checarEmail($_POST['email']))
	{
		$err[]='Seu email não é válido!';
	}
	
	if(!count($err))
	{
		// Se não ha erros
		
		$pass = substr(md5($_SERVER['REMOTE_ADDR'].microtime().rand(1,100000)),0,6);
		// Gera um senha aleatória
		
		$_POST['email'] = mysql_real_escape_string($_POST['email']);
		$_POST['usuario'] = mysql_real_escape_string($_POST['usuario']);
		// Limpando possíveis códigos maliciosos
		
		
		mysql_query("	INSERT INTO aa_membros(usr,pass,email,regIP,dt)
						VALUES(
						
							'".$_POST['usuario']."',
							'".md5($pass)."',
							'".$_POST['email']."',
							'".$_SERVER['REMOTE_ADDR']."',
							NOW()
							
						)");
		
		if(mysql_affected_rows($link)==1)
		{
			enviarEmail(	'bacci666@gmail.com',
							$_POST['email'],
							'Sistema de Cadastro - Sua Nova Senha',
							'Sua senha: '.$pass);

			$_SESSION['msg']['reg-success']='Enviamos um email para você com sua nova senha!';
		}
		else $err[]='Este usuário já existe!';
	}

	if(count($err))
	{
		$_SESSION['msg']['reg-err'] = implode('<br />',$err);
	}	
	
	header("Location: demo.php");
	exit;
}

$script = '';

if($_SESSION['msg'])
{
	// Este script abaixo abre o painel deslizante ao carregar a página
	
	$script = '
	<script type="text/javascript">
	
		$(function(){
		
			$("div#panel").show();
			$("#toggle a").toggle();
		});
	
	</script>';
	
} 
?>