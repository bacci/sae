<?php if(!defined('CHECAR_INCLUDE')) die('Você não tem permissão para executar esse arquivo diretamente');


/* Configurações do MySQL */

$db_host		= 'localhost';
$db_user		= 'root';
$db_pass		= 'joselito';
$db_database	= 'sae'; 

/* Fim das configurações */



$link = mysql_connect($db_host,$db_user,$db_pass) or die('Não foi possível estabelecer uma conexão com o DB');

mysql_select_db($db_database,$link);
mysql_query("SET names UTF8");

?>