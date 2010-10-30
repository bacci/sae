<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sem título</title>
</head>

<body>
<?
include "usuarios.class.php";

$user=new Usuario;

if(isset($_GET["user"])){
	$user->setId($_GET["user"]);
	$user->getUser();
}

if($_GET["action"]=="gravar"){

	$user=new Usuario;
	if($_POST["id"]>0){
		$user->setId($_POST["id"]);
	}
	$user->setNome($_POST["nome"]);
	$user->setUsuario($_POST["usuario"]);
	$user->setEmail($_POST["email"]);
	if($_POST["senha"]!=""){
		$user->setSenha($_POST["senha"]);
	}
	$user->setDataCad(date("Y-m-d ii:mm:ss"));
	$user->setLastIp($_SERVER['REMOTE_ADDR']);
	$user->setTipo(1);
	$user->setStatus(1);
	
	if($user->salvar()){
		echo "Sucesso!";
	}
	
}

		$uso=new Usuario;
		$uso->setUsuario("bacci");
		$uso->setSenha("vanesa");
		if($uso->checkUser()){
			echo "wins";
		}

?>
<form action="?action=gravar" method="post">
<input type="hidden" name="id" value="<? echo $user->getId(); ?>" />
<table>
<tr>
<td colspan="3">Criar Usuário</td>
</tr>
<tr>
<td>Nome:</td>
<td width="15"></td>
<td>Login:</td>
</tr>
<tr>
<td><input type="text" name="nome" value="<? echo $user->getNome(); ?>" /></td>
<td></td>
<td><input type="text" name="usuario" value="<? echo $user->getUsuario(); ?>" /></td>
</tr>
<tr height="5">
<td colspan="3"></td>
</tr>
<tr>
<td>Senha:</td>
<td width="15"></td>
<td>Email:</td>
</tr>
<tr>
<td><input type="password" name="senha" value="" /></td>
<td></td>
<td><input type="text" name="email" value="<? echo $user->getEmail(); ?>" /></td>
</tr>
<tr height="5">
<td colspan="3"></td>
</tr>
<tr>
<td colspan="3"><input type="submit" value="Cadastrar" /></td>
</tr>
</table>
</form>

</body>
</html>