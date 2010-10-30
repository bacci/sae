<?
include "add_user.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistema de Login bonito e funcional em PHP + MySql e jQuery</title>
    
    <script type="text/javascript" src="../jquery/jquery-1.4.2.min.js"></script>
    <script src="painel_login/js/slide.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="demo.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="painel_login/css/slide.css" media="screen" />
	<!-- Correção do PNG FIX para IE6 -->
    <!-- http://24ways.org/2007/supersleight-transparent-png-in-ie6 -->
    <!--[if lte IE 6]>
        <script type="text/javascript" src="painel_login/js/pngfix/supersleight-min.js"></script>
    <![endif]-->
    
    <?php echo $script; ?>
</head>

<body>
<?
include "painel.php";
?>

<div class="pageContent">
    <div id="principal">
      <div class="conteudo">
        <h1>Sistema de Login bonito e funcional</h1>
        <h2>Gerenciamento de cadastros fácil com PHP, MySql e jQuery</h2>
        </div>
        
        <div class="conteudo">
        
          <p>Este é um simples exemplo de site demonstrando o
		  <a href="#">Sistema de Login com PHP + jQuery + MySQL</a> no And After. 
		  Você pode começar clicando no botão <strong>Logar | Cadastrar</strong> acima.  
		  Após o cadastro, um email será enviado para você com sua nova senha.</p>
          <p><a href="registrado.php" target="_blank">Veja uma página de teste</a>, 
		  acessível somente a <strong>usuários registrados</strong>.</p>
          <p>O painel jQuery deslizante, usado neste exemplo, foi criado por  <a href="http://web-kreation.com/index.php/tutorials/nice-clean-sliding-login-panel-built-with-jquery" title="Go to site">Web-Kreation</a>.</p>
          <p>Você é livre para construir em cima deste código e usá-lo em seus 
		  próprios sites. </p>
          <div class="clear"></div>
        </div>
        
      <div class="conteudo tutorial-info">
      	  Isto é uma demonstração. Veja o <a href="http://www.andafter.org/publicacoes/login-em-php-e-mysql-com-jquery-_1461.html" target="_blank">artigo original</a>, ou baixe o <a href="demo.zip">código fonte</a>.</div>
    </div>
</div>

</body>
</html>
