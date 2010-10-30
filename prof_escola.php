<?
include "sessme.php";

include "escola.class.php";
include "usuarios.class.php";
include "professor.class.php";




$user=new Usuario;
$user->setId($_SESSION["id"]);
$user->getUser();

$escola=new Escola;
$escola->setId($user->getEscolaId());
$escola->getEscola();
if($user->getTipo()>1){ // só visualiza caso seja admin em alguma escola

$aut=isset($_GET["aut"]) ? $_GET["aut"] : false;
$unaut=isset($_GET["unaut"]) ? $_GET["unaut"] : false;
$pend=isset($_GET["pend"]) ? $_GET["pend"] : false;

if($aut){
	$escola->setProfessores($aut,2);
}

if($unaut){
	$escola->setProfessores($unaut,0);
}

if($pend){
	$escola->setProfessores($pend,1);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="jquery/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="jquery/jquery.tablesorter.js"></script>
<script type="text/javascript">
	$(document).ready(function() 
		{ 
			$("#tabela_escola").tablesorter( {sortList: [[0,0], [1,0]]} ); 
		} 
	);
</script>
<style>
table.tablesorter {
	font-family:arial;
	background-color: #CDCDCD;
	margin:10px 0pt 15px;
	font-size: 8pt;
	width: 100%;
	text-align: left;
}
table.tablesorter thead tr th, table.tablesorter tfoot tr th {
	background-color: #e6EEEE;
	border: 1px solid #FFF;
	font-size: 8pt;
	padding: 4px;
}
table.tablesorter thead tr .header {
	background-image: url(bg.gif);
	background-repeat: no-repeat;
	background-position: center right;
	cursor: pointer;
}
table.tablesorter tbody td {
	color: #3D3D3D;
	padding: 4px;
	background-color: #FFF;
	vertical-align: top;
}
table.tablesorter tbody tr.odd td {
	background-color:#F0F0F6;
}
table.tablesorter thead tr .headerSortUp {
	background-image: url(asc.gif);
}
table.tablesorter thead tr .headerSortDown {
	background-image: url(desc.gif);
}
table.tablesorter thead tr .headerSortDown, table.tablesorter thead tr .headerSortUp {
background-color: #8dbdd8;
}

#swfupload-control p{ margin:10px 5px; font-size:0.9em; }  
#log{ margin:0; padding:0; width:500px;}  
#log li{ list-style-position:inside; margin:2px; border:1px solid #ccc; padding:10px; font-size:12px;  
    font-family:Arial, Helvetica, sans-serif; color:#333; background:#fff; position:relative;}  
#log li .progressbar{ border:1px solid #333; height:5px; background:#fff; }  
#log li .progress{ background:#999; width:0%; height:5px; }  
#log li p{ margin:0; line-height:18px; }  
#log li.success{ border:1px solid #339933; background:#ccf9b9; }  
#log li span.cancel{ position:absolute; top:5px; rightright:5px; width:20px; height:20px;  
    background:url('../js/swfupload/images/cancel.png') no-repeat; cursor:pointer; }
</style>
<title>Professores</title>
</head>

<body>
<?
$esc=new Escola;
$esc->setId($user->getEscolaId());
$obj_prof=$esc->getProfessores(2); // professores atualmente na escola


	?>
    <table width="250" border="1">
    <tr>
    <td colspan="2">Professores Atualmente na escola <? echo $escola->getNome(); ?></td>
    </tr>
    <?
	if($obj_prof!=false){
		foreach($obj_prof as $obj){
			?>
			<tr>
			<td><? echo $obj->getNome()." ".$obj->getSobreNome(); ?></td>
			<td><a href="?unaut=<? echo $obj->getId(); ?>">Retirar acesso</a></td>
			</tr>
			<?
		}
	} else { ?>
			<tr>
			<td colspan="2">Nenhum</td>
			</tr>
	<? } ?>
    </table>
<br />
<br />
<?
$esc=new Escola;
$esc->setId($user->getEscolaId());
$obj_prof=$esc->getProfessores(1); // professores pendentes na escola
	?>
    <table width="250" border="1">
    <tr>
    <td colspan="2">Professores solicitando entrada na escola <? echo $escola->getNome(); ?></td>
    </tr>
    <?
	if($obj_prof!=false){
		foreach($obj_prof as $obj){
			?>
			<tr>
			<td><? echo $obj->getNome()." ".$obj->getSobreNome(); ?></td>
			<td><a href="?aut=<? echo $obj->getId(); ?>">Autorizar acesso</a></td>
			</tr>
			<?
		}
	} else { ?>
			<tr>
			<td colspan="2">Nenhum</td>
			</tr>
	<? } ?>
    </table>

<br />
<br />
<?
$esc=new Escola;
$esc->setId($user->getEscolaId());
$obj_prof=$esc->getProfessores("0"); // professores bloqueados na escola
	?>
    <table width="250" border="1">
    <tr>
    <td colspan="2">Professores recusados na escola <? echo $escola->getNome(); ?></td>
    </tr>
    <?
	if($obj_prof!=false){
		foreach($obj_prof as $obj){
			?>
			<tr>
			<td><? echo $obj->getNome()." ".$obj->getSobreNome(); ?></td>
			<td><a href="?pend=<? echo $obj->getId(); ?>">Deixar pendente</a></td>
			</tr>
			<?
		}
	} else { ?>
			<tr>
			<td colspan="2">Nenhum</td>
			</tr>
	<? } ?>
    </table>

<br />
<br />

</body>
</html>
<? } else {
	echo "Não Autorizado";
}?>