<?
include "sessme.php";
$_SESSION["id"]=1;
if($_SESSION["id"]){
include "escola.class.php";
include "usuarios.class.php";
include "professor.class.php";
	
	$user=new Usuario;
	$user->setId($_SESSION["id"]);
	$user->getUser();
	if($user->getTipo()<3){
		echo "Operação não autorizada!";
		exit;
	}
	
} else {
	echo "Operação não autorizada!";
	exit;
}

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Inserir Escola</title>
<script type="text/javascript" src="jquery/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="jquery/jquery.tablesorter.js"></script>
<script type="text/javascript" src="principal.js"></script>
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
</head>

<body>
<?


$esc=new Escola;

if(isset($_GET["esc"])){
	$esc->setId($_GET["esc"]);
	$esc->getProf();
}

if($_GET["action"]=="gravar"){

	$esc=new Escola;
	if($_POST["id"]>0){
		$esc->setId($_POST["id"]);
	}
	$esc->setNome($_POST["nome"]);
	$esc->setProfessores($_POST["professores"]);
	$esc->setTurma($_POST["turma"]);
	$esc->setUsuario($_POST["usuarios"]);
	$esc->setStatus(1);
	
	if($esc->salvar()>0){
		echo "Sucesso!";
	}
	
}

$prof=new Professor;

$page=isset($_GET["page"]) ? $_GET["page"]: $page=1;
$ppp=10;
$escolas=new Escola;
$escolas->setDE("SUZANO");
$teste=$escolas->listaEscola(($page*$ppp)-$ppp,$ppp);
$total_escolas=$escolas->listaEscola();
?>

<table id="tabela_escola" class="tablesorter">
<thead> 
<tr> 
    <th>Id</th> 
    <th>Nome</th> 
    <th>DE</th>
    <th>Telefone</th>
    <th>Status</th>
    <th>Opções</th> 
</tr> 
</thead> 
<tbody>
<?
if(count($teste)>0){
	foreach($teste as $obj){
		?>
		<tr>
		<td><? echo $obj->getId(); ?></td>
		<td><? echo utf8_encode($obj->getNome()); ?>
        <? 
		if($obj->getEnd()!=""){
			echo utf8_encode("<br />".$obj->getEnd().", ".$obj->getNumero()." ".$obj->getBairro()." - ".$obj->getCidade());
		}?>
        </td>
		<td><? echo $obj->getDE(); ?></td>
        <td><? echo $obj->getTelefone(); ?></td>
        <td><? echo $obj->getStatus(); ?></td>
		<td><a href="#<? echo $obj->getId(); ?>">Usar</a></td>
		</tr>
		<?
	}
} else {
?>
	<tr><td colspan="5" align="center">Nenhum resultado</td></tr>
<? } ?>
</tbody>
<tr>
<td colspan="5" align="right">
<? 
foreach($total_escolas as $la){
	$tt_esc=$la->getTotal();
	break;
}

if((round($tt_esc/$ppp)>1) AND ($page!=1)){
	?>
    <a href="?page=<? echo $page-1; ?>">Anterior</a>
    <?
} else{?>
	Anterior
<? }

if((round($tt_esc/$ppp)!=$page) AND (round($tt_esc/$ppp)>1)){
	?>
    <a href="?page=<? echo $page+1; ?>">Próxima</a>
    <?
} else{?>
	Próxima
<? } ?>
</td>
</tr>
</table>
<form action="?action=gravar" method="post">
<table>
<tr>
	<td>Nome da Escola:</td>
    <td></td>
    <td>Fone:</td>
</tr>
<tr>
	<td><input type="text" name="nome" value="" /></td>
    <td></td>
    <td><input type="text" name="telefone" value="" /></td>
</tr>
<tr height="15">
	<td colspan="3">&nbsp;</td>
</tr>
<tr>
	<td>D.E.:</td>
    <td></td>
    <td>Usuario Responsavel:</td>
</tr>
<tr>
	<td><input type="text" name="de" value="" /></td>
    <td></td>
    <td><input type="text" name="usuario" value="" /></td>
</tr>
<tr height="15">
	<td colspan="3">&nbsp;</td>
</tr>
<tr>
	<td>Tipo:</td>
    <td></td>
    <td>Status:</td>
</tr>
<tr>
	<td><input type="text" name="tipo" value="" /></td>
    <td></td>
    <td><input type="text" name="status" value="" /></td>
</tr>
<tr height="15">
	<td colspan="3">&nbsp;</td>
</tr>
</table>

<fieldset>
	    <legend>Localização:</legend>
		<table align="center" class="legenda" width="100%">
		<tr>
			<td align="right" valign="middle" width="20">Cep:&nbsp;</td>
			<td align="left" valign="middle" colspan="2"><input type="text" class="form_txt" value="<? echo $cep; ?>" name="cep" id="cep" size="8" maxlength="8" />
            &nbsp;<input type="button" class="form_submit" value="Consultar CEP" onclick="javascript: funcaowebservicecep();" title="Completa os campos de endereço caso encontre o CEP." />&nbsp;<input type="button" id="bt_map" value="Veja no mapa" class="form_submit" style="display:none" onclick="javascript: buscaMapa('embed');" /></td>
</tr>
		<tr height="25">
        	<td align="left" valign="bottom" colspan="2">Endereço:</td>
            <td align="left" valign="bottom">Número</td>
        </tr>
        <tr>
			<td align="left" valign="top" colspan="2">
            <input type="text" class="form_txt" value="<? echo $logradouro; ?>" name="logradouro" id="logradouro" size="12" />
            <input type="text" class="form_txt" value="<? echo $endereco; ?>" name="endereco" id="endereco" size="70" />
            </td>
            <td align="left" valign="top">
            <input type="text" class="form_txt" value="<? echo $endereco_no; ?>" name="endereco_no" id="endereco_no" size="8" />
            </td>
		</tr>
        <tr height="25">
        	<td align="left" valign="bottom">Complemento:</td>
            <td align="left" valign="bottom">Bairro:</td>
            <td align="left" valign="bottom">Cidade/Estado</td>
        </tr>
        <tr>
        	<td align="left" valign="middle">
            <input type="text" class="form_txt" value="<? echo $compl; ?>" name="compl" id="compl" size="20" />
            </td>
            <td align="left" valign="middle">
            <input type="text" class="form_txt" value="<? echo $bairro; ?>" name="bairro" id="bairro" size="30" />
            </td>
            <td align="left" valign="middle">
            <input type="text" class="form_txt" value="<? echo $cidade; ?>" name="cidade" id="cidade" size="30" />
            <input type="text" class="form_txt" value="<? echo $estado; ?>" name="estado" id="estado" size="2" />
            </td>
        </tr>
		</table>
</fieldset>
<center>
<input type="submit" value="Cadastrar Escola" />
</center>
</form>
</body>
</html>