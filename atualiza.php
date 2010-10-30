<?
include "sessme.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Atualizaçãoo dos dados</title>
</head>

<body>
<?
include "usuarios.class.php";
include "professor.class.php";

$user=new Usuario;

if(isset($_SESSION['id'])){
	$user->setId($_SESSION['id']);
	$user->getUser();

	$prof=new Professor;
	$prof->setId($user->getProfId());
	$prof->getProf();
	
	$cat=new Categoria;
	
} else {
	exit;
}

if($_GET["action"]=="gravar"){
	$nome=isset($_POST["nome"]) ? $_POST["nome"] : NULL ;
	$sobrenome=isset($_POST["sobrenome"]) ? $_POST["sobrenome"] : NULL ;
	$rs=isset($_POST["rs"]) ? $_POST["rs"] : NULL ;
	$categoria=isset($_POST["categoria"]) ? $_POST["categoria"] : NULL ;
	$telefone=isset($_POST["telefone"]) ? $_POST["telefone"] : NULL ;
	$email=isset($_POST["email"]) ? $_POST["email"] : NULL ;
	$usuario=isset($_POST["usuario"]) ? $_POST["usuario"] : NULL ;
	
	
	$prof->setNome($nome);
	$prof->setSobreNome($sobrenome);
	$prof->setRs($rs);
	$prof->setCategoria($categoria);
	$prof->setTelefone($telefone);
	$prof->setEmail($email);
	$prof->setStatus(1);
	

	//$newuser=new Usuario;
	$user->setNome($_POST["nome"]);
	$user->setDataCad(date("Y-m-d H:i:s"));
	$user->setId($_SESSION['id']);
	$user->setTipo($user->getTipo());
	$user->setProfId($prof->salvar());
	$user->setAtualiza("0");
	
	if($user->salvar()){
		$sucesso="Seus dados foram atualizados com sucesso!";
	}
}

echo $sucesso;
?>

<form action="?action=gravar" method="post">
<input type="hidden" name="id" value="<? echo $prof->getId(); ?>" />
<table>
<tr>
<td colspan="3">Antes de continuar, por favor preencha os campos restantes de seu cadastro.</td>
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
<td><? echo $cat->getSelectCategoria($prof->getCategoria(),0); ?></td>
</tr>
<tr height="5">
<td colspan="3"></td>
</tr>
</tr>
<tr>
<td>Telefone:</td>
<td width="15"></td>
<td></td>
</tr>
<tr>
<td><input type="text" name="telefone" value="<? echo $prof->getTelefone(); ?>" /></td>
<td></td>
<td></td>
</tr>
<tr height="5">
<td colspan="3"><hr /></td>
</tr>
<tr>
<td>Email:</td>
<td width="15"></td>
<td>Usuario:</td>
</tr>
<tr>
<td><input type="text" name="email" readonly="readonly" value="<? echo $user->getEmail(); ?>" /></td>
<td></td>
<td><input type="text" readonly="readonly" name="usuario" value="<? echo $user->getUsuario(); ?>" /></td>
</tr>
<tr height="5">
<td colspan="3"><hr /></td>
</tr>
<tr>
<td colspan="3"><input type="submit" value="Cadastrar" /></td>
</tr>
</table>
</form>
</body>
</html>