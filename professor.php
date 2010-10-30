<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sem título</title>
</head>

<body>
<?
include "usuarios.class.php";
include "professor.class.php";

$prof=new Professor;

if(isset($_GET["prof"])){
	$prof->setId($_GET["prof"]);
	$prof->getProf();
}

if($_GET["action"]=="gravar"){

	$prof=new Professor;
	if($_POST["id"]>0){
		$prof->setId($_POST["id"]);
	}
	$prof->setNome($_POST["nome"]);
	$prof->setSobreNome($_POST["sobrenome"]);
	$prof->setRs($_POST["rs"]);
	$prof->setCategoria($_POST["categoria"]);
	$prof->setEscola($_POST["escola"]);
	$prof->setTurma($_POST["turma"]);
	$prof->setTurno($_POST["turno"]);
	$prof->setTelefone($_POST["telefone"]);
	$prof->setEmail($_POST["email"]);
	$prof->setUsuario($_POST["usuarios"]);
	$prof->setStatus(1);
	
	if($prof->salvar()){
		echo "Sucesso!";
	}
	
}

$user=new Usuario;
?>

<form action="?action=gravar" method="post">
<input type="hidden" name="id" value="<? echo $prof->getId(); ?>" />
<table>
<tr>
<td colspan="3">Criar Professor</td>
</tr>
<tr>
<td>Nome:</td>
<td width="15"></td>
<td>Sobrenome:</td>
</tr>
<tr>
<td><input type="text" name="nome" value="<? echo $prof->getNome(); ?>" /></td>
<td></td>
<td><input type="text" name="sobrenome" value="<? echo $prof->getSobreNome(); ?>" /></td>
</tr>
<tr height="5">
<td colspan="3"></td>
</tr>
<tr>
<td>Rs:</td>
<td width="15"></td>
<td>Categoria:</td>
</tr>
<tr>
<td><input type="text" name="rs" value="<? echo $prof->getRs(); ?>" /></td>
<td></td>
<td><input type="text" name="categoria" value="<? echo $prof->getCategoria(); ?>" /></td>
</tr>
<tr height="5">
<td colspan="3"></td>
</tr>
<tr>
<td>Escola:</td>
<td width="15"></td>
<td>Turma:</td>
</tr>
<tr>
<td><input type="text" name="escola" value="<? echo $prof->getEscola(); ?>" /></td>
<td></td>
<td><input type="text" name="turma" value="<? echo $prof->getTurma(); ?>" /></td>
</tr>
<tr height="5">
<td colspan="3"></td>
</tr>
<tr>
<td>Turno:</td>
<td width="15"></td>
<td>Telefone:</td>
</tr>
<tr>
<td><input type="text" name="turno" value="<? echo $prof->getTurno(); ?>" /></td>
<td></td>
<td><input type="text" name="telefone" value="<? echo $prof->getTelefone(); ?>" /></td>
</tr>
<tr height="5">
<td colspan="3"></td>
</tr>
<tr>
<td>Email:</td>
<td width="15"></td>
<td>Usuario:</td>
</tr>
<tr>
<td><input type="text" name="email" value="<? echo $prof->getEmail(); ?>" /></td>
<td></td>
<td><? echo $user->getSelectUser($prof->getUsuario(),"3",false); ?></td>
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