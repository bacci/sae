<? require "add_user.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mudar Senha</title>
	<script type="text/javascript" src="jquery/jquery-1.4.2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="demo.css" media="screen" />
</head>

<body>
<?
if($_GET["changepass"]=="ok"){
	if($_POST["pass_new1"]==$_POST["pass_new2"]){
		$user=$_SESSION["usr"];
		$old=$_POST["pass_now"];
		mysql_query("UPDATE tb_usuarios SET
			senha='".md5($_POST["pass_new1"])."'
			WHERE
			usuario='$user' AND senha='".md5($old)."'
			");
		
		if(mysql_affected_rows($link)==1)
		{
			echo "Senha alterada com sucesso!";
		}
	} else {
		echo "Senhas novas não conferem";
	}
}
?>
<div id="principal">
  <div class="conteudo">
    <h1>Alteração de senha</h1>
    </div>
    
    <div class="conteudo">
    
    <?php
	if($_SESSION['id']){
		?>
        <form action="?changepass=ok" method="post">
        <table>
        <tr>
        <td colspan="2">Trocar senha</td>
        </tr>
        <tr>
        <td>Senha Atual:</td>
        <td><input type="password" name="pass_now" /></td>
        </tr>
        <tr>
        <td>Nova Senha:</td>
        <td><input type="password" name="pass_new1" /></td>
        </tr>
        <tr>
        <td>Repita a nova senha:</td>
        <td><input type="password" name="pass_new2" /></td>
        </tr>
        <tr>
        <td colspan="2"><input type="submit" value="Mudar senha" /></td>
        </tr>
        </table>
        </form>
        <?
	} else { 
		exit;
	}
    ?>
    </div>

</div>


</body>
</html>