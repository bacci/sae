<?
include "telefones.class.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sem título</title>
<link rel="stylesheet" href="css/thickbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="jquery/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="jquery/thickbox.js"></script>

<script>


function add_Linha_Contato(tabela_id,contador_id){		
	
	tbl = document.getElementById(tabela_id) // define ao tbl o objeto tabela
	hid = document.getElementById(contador_id) // define ao hid o input hidden contador
	totals=hid.value;

	var novaLinha = tbl.insertRow(-1); // Adiciona uma nova linha (TR) no final da tabela
	var novaCelula;
	novaLinha.height = "25";
	
	////*************** CELULA VAZIA ***************////
	
	novaCelula = novaLinha.insertCell(0); // insere no obejeto novaLinha 1.a celula
	novaCelula.align = "right";
	texto="<input type='hidden' class='form_txt' name='id_filho[" + hid.value + "]' size='45' />&nbsp;";
	novaCelula.innerHTML = texto; // atribui o conteudo da celula
	
	////*************** CELULA 1 ***************////
	
	novaCelula = novaLinha.insertCell(1); // insere no obejeto novaLinha 1.a celula
	novaCelula.align = "right";
	novaCelula.colspan = "2";

	// Conteudo da 1.a celula
	texto  = "Nome do Filho:&nbsp;<input type='text' class='form_txt' name='filho[" + hid.value + "]' size='45' />";		
	novaCelula.innerHTML = texto; // atribui o conteudo da celula

	////*************** CELULA 2 ***************////
	
	novaCelula = novaLinha.insertCell(2); // insere no obejeto novaLinha 1.a celula
	novaCelula.align = "left";

	// Conteudo da 2.a celula
	texto  = "Nascimento:&nbsp;<input type='text' class='form_txt' name='nascto_filho[" + hid.value + "]' size='12' maxlength='10' onkeyup='FormataData(this,event)' />";		
	novaCelula.innerHTML = texto; // atribui o conteudo da celula
	
	// GAMBIARRA PARA CONTADOR		
	numer = hid.value; // Atribui valor do elemento hidden a uma variaver
	numer++; // aumenta em 1  		
	hid.value = numer;  // retorna valor da variavel ao elemento hidden
}
	
function del_Linha(tabela_id,contador_id){
	tbl = document.getElementById(tabela_id) // atribui obejeto tabela ao tbl
	cont = document.getElementById(contador_id) // atribui obejeto tabela ao tbl		
	
	// caso nao exista uma nova linha
	if (cont.value < 1){
		alert("Nenhuma NOVA LINHA a ser apagada !");
	}else{
	
		if (confirm ("Deseja realmente APAGAR a ultima linha ?")){
			tbl.deleteRow(-1); // Deleta ultima linha da tabela
			temp = cont.value;
			temp--;
			cont.value = temp;
			totals--;
		}
	}
}
function verifica_data(strdata) {
    if (strdata.length != 10){
        alert('Formato da data não é válido. Formato correto: - dd/mm/aaaa.');
            return false;
    }
        //Verifica máscara da data
    if ("/" != strdata.substr(2,1) || "/" != strdata.substr(5,1)){
            alert("Formato da data não é válido. Formato correto:- dd/mm/aaaa.");
            return false;
    }
    return true;
}
</script>
</head>
<? echo str_replace('-','',str_pad('08450-600', 8, '0', STR_PAD_LEFT)); ?>
<body id="principal">
    <form method="post" action=""><input type="text" id="txtdata" name="txtdata" /><input type="button" onclick="verifica_data(this.form.txtdata.value)" value="verifica Data" /></form>
<table id="tb_familia">
<tr><td>
<input type="hidden" value="0" id="cont" name="cont" />
<input class="form_submit" type='button' id='incluir' value='Incluir Nome do filho' onclick='add_Linha_Contato("tb_familia","cont")'> 
                <input class="form_submit" type='button' id='deleta' value='Excluir última linha' onclick='del_Linha("tb_familia","cont")'>
</td>
</tr>
<tr>
<td><div id="flash" align="left"  ></div></td>
</tr>
<tr>
<td id="update"></td>
</tr>
</table>

<a href="atualiza.php?keepThis=true&TB_iframe=true&height=250&width=400" title="Atualizar dados" class="thickbox">Atualizar dados.</a>  
<a href="atualiza.php?keepThis=true&TB_iframe=true&height=300&width=500" title="add a caption to title attribute / or leave blank" class="thickbox">Example 2</a>
<a href="escola.php?placeValuesBeforeTB_=savedValues&TB_iframe=true&height=200&width=300&modal=true" title="add a caption to title attribute / or leave blank" class="thickbox">Open iFrame Modal</a>
<a href="../hopi_banner_grande_SF.gif" title="hopi hari" class="thickbox">
<img src="../hopi_banner_grande_SF.gif" title="hopi hari" width="100" class="thickbox" border="0" /></a>
<br />
<br />
<?
$teste=new Telefone;
//$teste->setProfId(1);
//$var=$teste->getSQLFone();
$teste->setDDD(11);
$teste->setFone("25523914");
$teste->setProfId(2);
$var=$teste->salvar();
if($var){
	echo "sucesso ".$var;
}
?>
</body>
</html>