<? 
include "add_user.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Somente usuários registrados!</title>
	<script type="text/javascript" src="jquery/jquery-1.4.2.min.js"></script>
    <script src="painel_login/js/slide.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="demo.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="painel_login/css/slide.css" media="screen" />
</head>

<body>
<?
include "painel.php";


function enum_select( $table , $field ){
	$host="localhost";
	$user="root";
	$pass="joselito";
	$banco="sae";
	include "adodb5/adodb.inc.php";
	$cdb = &ADONewConnection('mysql');
	$cdb->PConnect($host, $user, $pass, $banco);
	
	global $cdb;

	$query = " SHOW COLUMNS FROM `tb_telefones` LIKE 'tel_tipo' ";
	/*$result = mysql_query( $query ) or die( 'error getting enum field ' . mysql_error() );
	$row = mysql_fetch_array( $result , MYSQL_NUM );*/
	$result=$GLOBALS["cdb"]->Execute($query);
	
	#extract the values
	#the values are enclosed in single quotes
	#and separated by commas
	$regex = "/'(.*?)'/";
	preg_match_all( $regex , $result->fields[1], $enum_array );
	$enum_fields = $enum_array[1];
	return( $enum_fields );
} 

?>
<div id="principal">
  <div class="conteudo">
    <h1>Somente usuários registrados!</h1>
    <h2>Você deve estar logado para ver o conteúdo!</h2>
    </div>
    
    <div class="conteudo">
	<?
	$campos=enum_select("tb_telefones","tel_tipo");
	print_r($campos);
	?>    
    <?php
	if($_SESSION['id'])
	echo '<h1>Olá, '.$_SESSION['usr'].'! Você está registrado e logado!</h1>';
	else echo '<h1>Por favor, <a href="demo.php">loge-se</a> e volte novamente!</h1>';
    ?>
    </div>
    
  <div class="conteudo tutorial-info">
Isto é uma demonstração. Veja o <a href="http://www.andafter.org/publicacoes/login-em-php-e-mysql-com-jquery-_1461.html" target="_blank">artigo original</a>, ou baixe o <a href="demo.zip">código fonte</a>.    </div>
</div>


</body>
</html>