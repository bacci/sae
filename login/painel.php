<!-- Painel -->
<div id="toppanel">
	<div id="panel">
		<div class="content clearfix">
			<div class="left">
				<h1>O Painel jQuery Deslizante</h1>
				<h2>Solução para login/cadastro</h2>		
				<p class="grey">Você é livre para usar este sistema de login e cadastro em seus próprios sites. </p>
				<h2>Um Grande Agradecimento</h2>
				<p class="grey">Este tutorial foi criado com base no Painel jQuery Deslizante.</p>
			</div>
            
            
            <?php
			
			if(!$_SESSION['id']):
			
			?>
            
			<div class="left">
				<!-- Formulário de Login -->
				<form class="clearfix" action="" method="post">
					<h1>Login de Membros</h1>
                    
                    <?php
						
						if($_SESSION['msg']['login-err'])
						{
							echo '<div class="err">'.$_SESSION['msg']['login-err'].'</div>';
							unset($_SESSION['msg']['login-err']);
						}
					?>
					
					<label class="grey" for="usuario">Usuário:</label>
					<input class="field" type="text" name="usuario" id="username" value="" size="23" />
					<label class="grey" for="password">Senha:</label>
					<input class="field" type="password" name="senha" id="password" size="23" />
	            	<label><input name="lembrarMe" id="rememberMe" type="checkbox" checked="checked" value="1" /> &nbsp;Continuar conectado</label>
        			<div class="clear"></div>
					<input type="submit" name="submit" value="Login" class="bt_login" />
				</form>
			</div>
			<div class="left right">			
				<!-- Formulário de Cadastro -->
				<form action="" method="post">
					<h1>Não é um membro? Cadastre-se agora!</h1>		
                    
                    <?php
						
						if($_SESSION['msg']['reg-err'])
						{
							echo '<div class="err">'.$_SESSION['msg']['reg-err'].'</div>';
							unset($_SESSION['msg']['reg-err']);
						}
						
						if($_SESSION['msg']['reg-success'])
						{
							echo '<div class="successo">'.$_SESSION['msg']['reg-success'].'</div>';
							unset($_SESSION['msg']['reg-success']);
						}
					?>
                    		
					<label class="grey" for="username">Usuário:</label>
					<input class="field" type="text" name="usuario" id="username" value="" size="23" />
					<label class="grey" for="email">Email:</label>
					<input class="field" type="text" name="email" id="email" size="23" />
					<label>A senha será enviada para seu email.</label>
					<input type="submit" name="submit" value="Cadastrar" class="bt_register" />
				</form>
			</div>
            
            <?php

			else:
			?>
            <div class="left">
            
            <h1>Painel de Membros</h1>
            
            <p>Você pode colocar os dados do membro aqui</p>
            <a href="registrado.php">Veja uma página de membros especial</a>
            <p>- ou -</p>
            <a href="?logoff">Sair</a>
            </div>
            
            <div class="left right">
            </div>
            <?php
			endif;
			?>
		</div>
	</div> <!-- /login -->	

    <!-- A aba no top -->	
	<div class="tab">
		<ul class="login">
	    	<li class="left">&nbsp;</li>
	        <li>Olá <?php echo $_SESSION['usr'] ? $_SESSION['usr'] : 'Visitante';?>!</li>
			<li class="sep">|</li>
			<li id="toggle">
				<a id="open" class="open" href="#"><?php echo $_SESSION['id']?'Abrir Painel':'Logar | Cadastrar';?></a>
				<a id="close" style="display: none;" class="close" href="#">Fechar Painel</a>			
			</li>
	    	<li class="right">&nbsp;</li>
		</ul> 
	</div> <!-- / top -->
	
</div> <!--painel -->