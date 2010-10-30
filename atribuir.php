<?
include "sessme.php";

include "escola.class.php";
include "usuarios.class.php";
include "professor.class.php";
include "classes.class.php";




$user=new Usuario; // novo usuário
$user->setId($_SESSION["id"]); // seleciona o id de quem está logado
$user->getUser(); // pega os dados dele

$escola=new Escola; // novaescola
$escola->setId($user->getEscolaId()); // pega a escola que o user representa 
$escola->getEscola(); // pega os dados da escola que ele representa
if($user->getTipo()>1){ // só visualiza caso seja admin em alguma escola

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="jquery/jquery-1.4.2.min.js"></script>

<title>Atribuição de salas</title>
</head>

<body>
<?
$id_pro=isset($_GET["cod"]) ? $_GET["cod"] : false;
if($id_pro){
	$prof=new Professor;
	$prof->setId($id_pro);
	$prof->getProf(); // pega o professor selecionado
	$array_escolas=$prof->getEscolas();
	if(in_array($escola->getId(),$array_escolas, true)){
		?>
		<table width="250" border="1">
		<tr>
		<td colspan="2">Salas para o professor <? echo $prof->getNome()." ".$prof->getSobreNome(); ?></td>
		</tr>
		<?
		$class=new Classes;
		$obj_classes=$class->getClassesProf($id_pro,$escola->getId());
		if($obj_classes!=false){
			foreach($obj_classes as $obj_c){
				?>
				<tr>
				<td><?
				echo $obj_c->getNome().",";
				?>
				</td>
				</tr>
				<?
			}
		} else {
			?>
			<tr>
			<td><?
			echo "Nenhuma sala atribuída <a href='atribuir.php?cod=".$id_pro."'>atribuir agora.</a>";	
			?>
			</td>
			</tr>
			<?
		}
	} else {
	echo "Este professor não pertence a esta escola";
	exit;
	}
	?>
    	</table>
<br />
<br />
<table border="1">
<tr>
<td>Classes atualmente na sua escola</td>
</tr>
<?
$class=new Classes;
$class->setEscola($escola->getId());
$class->getStatus(1);
$obj_classes=$class->getSQLClasse();
if($obj_classes!=false){
	?>
    <select name="classes[]">
	<?
	foreach($obj_classes as $obj_c){
		?>
		<option value="<? echo $obj_c->getId(); ?>"><? echo $obj_c->getNome(); ?></option>
		</td>
		</tr>
		<?
	}?>
    </select>
    <?
} else {
	?>
	<tr>
	<td><?
	echo "Nenhuma classe cadastrada <a href='classe.php'>cadastrar agora.</a>";	
	?>
	</td>
	</tr>
	<?
}
?>
</table>
<br />
<br />
<?
} else {
	echo "Nenhum professor selecionado";
	exit;
}
?>

</body>
</html>
<? } else {
	echo "Não Autorizado";
}?>