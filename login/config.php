<?php if(!defined('CHECAR_INCLUDE')) die('Voc� n�o tem permiss�o para executar esse arquivo diretamente');


/* Configura��es do MySQL */

$db_host		= 'localhost';
$db_user		= 'root';
$db_pass		= 'joselito';
$db_database	= 'sae'; 

/* Fim das configura��es */



$link = mysql_connect($db_host,$db_user,$db_pass) or die('N�o foi poss�vel estabelecer uma conex�o com o DB');

mysql_select_db($db_database,$link);
mysql_query("SET names UTF8");

?>