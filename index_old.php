<?
include "add_user.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistema de Apoio a Escola</title>
    
    <script type="text/javascript" src="jquery/jquery-1.4.2.min.js"></script>
    <script src="painel_login/js/slide.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="demo.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="painel_login/css/slide.css" media="screen" />
    <!-- Corre��o do PNG FIX para IE6 -->
    <!-- http://24ways.org/2007/supersleight-transparent-png-in-ie6 -->
    <!--[if lte IE 6]>
        <script type="text/javascript" src="painel_login/js/pngfix/supersleight-min.js"></script>
    <![endif]-->
    
    <?php echo $script; ?>
	</head>

<body>
<br />
<?
include "painel.php";
if($_SESSION['atualiza']==1){
	$start="atualiza.php";
} else {
	$start="demo.php";
}
?>
<div align="center">
<iframe name="corpo_principal" width="99%" height="580" frameborder="0" marginheight="0" marginwidth="0" src="<? echo $start; ?>"></iframe>
</div>
</body>
</html>