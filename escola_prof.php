<?
include "sessme.php";

include "escola.class.php";
include "usuarios.class.php";
include "professor.class.php";

$esc=new Escola;
$user=new Usuario;
$user->setId($_SESSION["id"]);
$user->getUser();
//var_dump($user);
if($_GET["getEscola"]==true){ // sistema de busca de escola
	$esc=new Escola;
	if(isset($_POST['queryString'])) {
		$queryString = addslashes($_POST['queryString']);
		if(strlen($queryString) >0) {
			echo $esc->buscaEscola($queryString);
		}
		exit;
	}
}

if($_GET["action"]=="gravar"){
	if($esc->requestEscola($user->getProfId(),$_POST["escola_id"])){
		$text="Pedido de entrada na escola ".$_POST["escola"] ." do professor ".$user->getNome()." enviado com sucesso!";
	} else {
		$text="O pedido de entrada na escola ".$_POST["escola"] ." já tinha sido enviado!";
	}
	echo $text;
}

if($user->getProfId()<1){
	echo "Você precisa primeiro ser cadastrado como professor, ou atualizar seus dados, <a href='atualiza.php'>Clique aqui</a> para resolver este problema.";
	exit;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="jquery/jquery-1.4.2.min.js"></script>
<script type="text/javascript">
	function lookup(inputString) {
		if(inputString.length == 0) {
			// Hide the suggestion box.
			$('#suggestions').hide();
		} else {
			$.post("escola_prof.php?getEscola=true", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#suggestions').show();
					$('#autoSuggestionsList').html(data);
				}
			});
		}
	} // lookup
	
	function fill(thisValue) {
		$('#inputString').val(thisValue);
		setTimeout("$('#suggestions').hide();", 200);
	}
	
	function getCode(esc_id){
		document.getElementById('escola_id').value=esc_id;
	}
</script>
<style type="text/css">
	body {
		font-family: Helvetica;
		font-size: 11px;
		color: #000;
	}
	
	h3 {
		margin: 0px;
		padding: 0px;	
	}

	.suggestionsBox {
		position: relative;
		left: 30px;
		margin: 10px 0px 0px 0px;
		width: 200px;
		background-color: #212427;
		-moz-border-radius: 7px;
		-webkit-border-radius: 7px;
		border: 2px solid #000;	
		color: #fff;
	}
	
	.suggestionList {
		margin: 0px;
		padding: 0px;
	}
	
	.suggestionList li {
		
		margin: 0px 0px 3px 0px;
		padding: 3px;
		cursor: pointer;
	}
	
	.suggestionList li:hover {
		background-color: #659CD8;
	}
</style>
<title>Solicitação para a escola</title>
</head>

<body>
<?
$return=$esc->getRequestEscola($user->getProfId());
if($return!=false){
	?>
<table border="1">
<tr>
<td colspan="3">Escolas já solicitadas</td>
</tr>
<tr>
<td>Escola:</td>
<td>Data:</td>
<td>Status:</td>
</tr>

<?
	for($i=0;$i<count($return);$i++){
		?>
        <tr>
        <td><? echo $return[$i]["escola"]; ?></td>
        <td><? echo $return[$i]["desde"]; ?></td>
        <td><? 
		switch($return[$i]["status"]){
			case 0:
				echo "Negado";
			break;
			case 1:
			default:
				echo "Pendente";
			break;
			case 2:
				echo "Aceito";
			break;
		}
		 ?></td>
         </tr>
        <?
	}
?>
</table>
<? } ?>
<form action="?action=gravar" method="post">
<table>
<tr>
<td>Localizar Escola</td>
</tr>
<tr>
<td>Encontre a sua escola na lista abaixo. Será enviada uma confirmação para o responsável pela escola.</td>
</tr>
<tr>
<td>Nome da escola:</td>
</tr>
<tr>
<td><div>
    Digite o nome da escola:
    <br />
    <input type="text" size="30" value="" name="escola" id="inputString" onkeyup="lookup(this.value);" onclick="this.value=''; $('#suggestions').hide(); " onblur="fill();" />
    <input type="hidden" name="escola_id" id="escola_id" value="" />
</div>

<div class="suggestionsBox" id="suggestions" style="display: none;">
<img src="upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
<div class="suggestionList" id="autoSuggestionsList">
        &nbsp;
    </div>
</div></td>
</tr>
<tr height="5">
<td colspan="3">No pedido será enviado seus dados cadastrais para uma conferência da instituição.</td>
</tr>
<tr>
<td colspan="3"><input type="submit" value="Enviar pedido para a escola" /></td>
</tr>
</table>
</form>
</body>
</html>