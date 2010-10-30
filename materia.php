<?
include "sessme.php";

include "escola.class.php";
include "usuarios.class.php";
include "materia.class.php";




$user=new Usuario; // novo usu�rio
$user->setId($_SESSION["id"]); // seleciona o id de quem est� logado
$user->getUser(); // pega os dados dele

$escola=new Escola; // novaescola
$escola->setId($user->getEscolaId()); // pega a escola que o user representa 
$escola->getEscola(); // pega os dados da escola que ele representa
if($user->getTipo()>1){ // s� visualiza caso seja admin em alguma escola

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="jquery/jquery-1.4.2.min.js"></script>

<title>Nova Matéria</title>
</head>

<body>
<?
$nova_materia=new Materias; // cria nova materia

$id_mat=isset($_GET["mat"]) ? $_GET["mat"] : false; // pega se está editando alguma matéria
if($id_mat){
	$nova_materia->setId($id_mat);
	$materia=$nova_materia->getSQLMateria(); // pega a matéria selecionada
	$nova_materia->setMateria($materia[0]->getMateria());
	$nova_materia->setAbrev($materia[0]->getAbrev());
	$nova_materia->setGrupo($materia[0]->getGrupo());
	$nova_materia->setStatus($materia[0]->getStatus());
} else {
	
}

if($_GET["action"]=="gravar"){
	if(isset($_POST["materia_id"])){
		$nova_materia->setId($_POST["materia_id"]);
	}
	$nova_materia->setMateria($_POST["materia"]);
	$nova_materia->setAbrev($_POST["abrev"]);
	if($_POST["novo_grupo"]){
		$grupo=new GrupoMateria;
		$grupo->setEscola($escola->getId());
		$grupo->setNomeGrupo($_POST["novo_grupo"]);
		$grupo->setStatus(1);
		$id_grupo=$grupo->salvar();
		$nova_materia->setGrupo($id_grupo);
	} else {
		$nova_materia->setGrupo($_POST["grupo_materia"]);
	}
	$nova_materia->setStatus(1);
	$id_materia=$nova_materia->salvar();
	$sucesso=true;
}
?>
<form action="materia.php?action=gravar" method="post">
<?
if($sucesso){
echo "Matéria inserida / Editada com sucesso!<br /><a href='materia.php'>Adicionar mais</a><br />
<a href='materia.php?mat=".$id_materia."'>Alterar esta matéria</a>";
exit;
}

if(isset($id_mat)){ ?>
<input type="hidden" value="<? echo $nova_materia->getId(); ?>" name="materia_id" />	
<?
}
?>
<table border="1">
<tr>
<td colspan="3">Formulário para criação de matérias</td>
</tr>
<tr>
<td>Nome da matéria:</td>
<td width="10"></td>
<td>Abreviatura (máx. 6 caracteres)</td>
</tr>
<tr>
<td><input type="text" name="materia" value="<? echo $nova_materia->getMateria(); ?>" /></td>
<td width="10"></td>
<td><input type="text" name="abrev" value="<? echo $nova_materia->getAbrev(); ?>" /></td>
</tr>
</tr>
<tr>
<td>Grupo da matéria:</td>
<td width="10"></td>
<td>Outro grupo: (Cria um novo)</td>
</tr>
<tr>
<td>
<?
$grupo=new GrupoMateria;
echo $grupo->getSelectGrupoMateria($nova_materia->getGrupo(),0);
?>
</td>
<td width="10"></td>
<td><input type="text" name="novo_grupo" value="<? echo $_POST["novo_grupo"]; ?>" /></td>
</tr>
<tr>
<td colspan="3"><input type="submit" value="Criar Matéria" /></td>
</tr>
</table>
</form>

</body>
</html>
<? } else {
	echo "Não Autorizado";
}?>