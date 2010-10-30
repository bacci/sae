<?php

define('CHECAR_INCLUDE',true);

require 'config.php';
require 'funcoes.php';
require 'usuarios.class.php';
require $class_dir.'professor.class.php';
// Este dois arquivos s� podem ser incluidos se a vari�vel CHECAR_INCLUDE estiver definida

session_name('aaLogin');
// Iniciando a sess�o

session_set_cookie_params(2*7*24*60*60);
// Definindo o validade do cookie por 2 semanas

session_start();

if($_SESSION['id'] && !isset($_COOKIE['aaLembrar']) && !$_SESSION['lembrarMe'])
{
	// Se voc� est� logado, mas n�o tem o cookie aaLembrar (restart do navegador)
	// e voc� n�o marcou o checkbox lembrarMe (continuar conectado):

	$_SESSION = array();
	session_destroy();
	
	// Destr�i a sess�o
}


if(isset($_GET['logoff']))
{
	$_SESSION = array();
	session_destroy();
	
	header("Location: index.php");
	exit;
}

if($_POST['submit']=='Login')
{
	// Checando se o formul�rio Login form foi enviado
	
	$err = array();
	// Outros erros
	
	
	if(!$_POST['usuario'] || !$_POST['senha'])
		$err[] = 'Todos os campos devem ser preenchidos!';
	
	if(!count($err))
	{
		$_POST['usuario'] = mysql_real_escape_string($_POST['usuario']);
		$_POST['senha'] = mysql_real_escape_string($_POST['senha']);
		$_POST['lembrarMe'] = (int)$_POST['lembrarMe'];
		
		// Limpando poss�veis c�digos maliciosos
		
		$user=new Usuario;
		$user->setUsuario($_POST['usuario']);
		$user->setSenha($_POST['senha']);
		//$row = mysql_fetch_assoc(mysql_query("SELECT id, nome1, usuario FROM tb_usuarios WHERE usuario='{$_POST['usuario']}' AND senha='".md5($_POST['senha'])."'"));

		if($user->checkUser())
		{
			// Se tudo est� OK, login
			
			$_SESSION['usr']=$user->getUsuario();
			$_SESSION['nome']=$user->getNome();
			$_SESSION['escola']=$user->getEscolaId();
			$_SESSION['atualiza']=$user->getAtualiza();
			$_SESSION['id'] = $user->getId();
			$_SESSION['lembrarMe'] = $_POST['lembrarMe'];
			
			// Armazena algum dado na sess�o
			
			setcookie('aaLembrar',$_POST['lembrarMe']);
		}
		else $err[]='Usu�rio e/ou senha incorretos!';
	}
	
	if($err)
	$_SESSION['msg']['login-err'] = implode('<br />',$err);
	// Salva a mensagem de erro na sess�o

	header("Location: index.php");
	exit;
}
else if($_POST['submit']=='Cadastrar')
{
	// Se o formul�rio de Cadastro foi enviado
	
	$err = array();
	
	if(strlen($_POST['usuario'])<4 || strlen($_POST['usuario'])>32)
	{
		$err[]='Seu usu�rio deve ter no m�nimo 3 a 32 caracteres!';
	}
	
	if(preg_match('/[^a-z0-9\-\_\.]+/i',$_POST['usuario']))
	{
		$err[]='Seu usu�rio cont�m caracteres inv�lidos!';
	}
	
	if(!checarEmail($_POST['email']))
	{
		$err[]='Seu email n�o � v�lido!';
	}
	
	if(!count($err))
	{
		// Se n�o ha erros
		
		$pass = substr(md5($_SERVER['REMOTE_ADDR'].microtime().rand(1,100000)),0,6);
		// Gera um senha aleat�ria
		
		$_POST['email'] = mysql_real_escape_string($_POST['email']);
		$_POST['usuario'] = mysql_real_escape_string($_POST['usuario']);
		// Limpando poss�veis c�digos maliciosos
		
		$user=new Usuario;
		$user->setUsuario($_POST['usuario']);
		$user->setSenha($pass);
		$user->setTipo(0);
		$user->setEmail($_POST['email']);
		$user->setLastIp($_SERVER['REMOTE_ADDR']);
		$user->setDataCad(date("Y-m-d H:i:s"));
		$user->setAtualiza(1);
		$user->setStatus(1);
		if(!$user->isDuplicated($_POST['usuario']))
		{
			if($user->salvar()){
				if(enviarEmail(	'bacci666@gmail.com',
				$_POST['email'],
				'Sistema de Cadastro - Sua Nova Senha',
				'Sua senha: '.$pass)){
					$_SESSION['msg']['reg-success']='Enviamos um email para voc� com sua nova senha!';
				} else {
					$_SESSION['msg']['reg-success']='Seu login foi criado, por�m n�o conseguimos envi�-lo um email com sua senha que � ($pass)!';
				}
			}
		}
		else $err[]='Este usu�rio j� existe!';
	}

	if(count($err))
	{
		$_SESSION['msg']['reg-err'] = implode('<br />',$err);
	}	
	
	header("Location: index.php");
	exit;
}

$script = '';

if($_SESSION['msg'])
{
	// Este script abaixo abre o painel deslizante ao carregar a p�gina
	
	$script = '
	<script type="text/javascript">
	
		$(function(){
			$("div#panel").show();
			$("#toggle a").toggle();
		});
	
	</script>';
	
} 
?>