<!-- Painel -->
<div id="toppanel">
	<div id="panel">
		<div class="content clearfix">
			<div class="left">
				<h1>Sistema de Apoio a Escola</h1>
				<h2>Este painel é deslizante</h2>		
				<p class="grey">Você fica livre para navegar na página desejada a qualquer momento sem fechar este menu.</p>
				<h2>O Criador</h2>
				<p class="grey">Criado por Giancarlo Bacci.</p>
			</div>
            
            
            <?php
			
			if(!$_SESSION['id']){
			
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

			} else {
				
				require_once("escola.class.php");
				
				$user=new Usuario;
				$user->setId($_SESSION["id"]);
				$user->getUser();
				$prof=new Professor;
				$prof->setId($user->getProfId());
				$prof->getProf();
				
				switch($user->getTipo()){
					case 1:
					$painel_nome="professor";
					if($prof->getSexo()=="Feminino"){
							$bemvindo="Bem-vindo Sra ".  $user->getNome();
						} else {
							$bemvindo="Bem-vindo Sr ".  $user->getNome();
						}
					$links["atualiza.php"]="Alterar Perfil";
					$links["escola_prof.php"]="Solicitar entrada em uma escola";
					$links["mudar_senha.php"]="Trocar Senha";
					$links["index.php?logoff"]="Sair";
					break;
					case 2:
					$painel_nome="coordenador";
					if($prof->getSexo()=="Feminino"){
							$bemvindo="Bem-vindo Sra ".  $user->getNome();
						} else {
							$bemvindo="Bem-vindo Sr ".  $user->getNome();
						}
					$links["atualiza.php"]="Alterar Perfil";
					$links["prof_escola.php"]="Ver Professores / Atribuir Salas";
					$links["materia.php"]="Criar Matéria";
					$links["mudar_senha.php"]="Trocar Senha";
					$links["index.php?logoff"]="Sair";
					break;
					case 3:
					$painel_nome="administrador";
					if($prof->getSexo()=="Feminino"){
						$bemvindo="Bem-vindo Sra ".  $user->getNome();
					} else {
						$bemvindo="Bem-vindo Sr ".  $user->getNome();
					}
					$links["atualiza.php"]="Alterar Perfil";
					$links["escola.php"]="Inserir Escola";
					$links["mudar_senha.php"]="Trocar Senha";
					$links["index.php?logoff"]="Sair";
					break;
				} // fechando switch
			?>
            			<div class="left">
						
						<h1>Painel do <? echo $painel_nome; ?></h1>
						
						<p><? echo $bemvindo; ?>:</p>
						<ul>
                        <?
						foreach($links as $href => $name){
						?>
						<li><a href="<? echo $href; ?>" onclick="sobe();" target="corpo_principal"><? echo $name; ?></a></li>
                        <?
						}
						?>
						</ul>
						<br />
						
						</div>
                        
            			<div class="left right">
						<h1>Alertas</h1>
						
						<ul>
						<? 
						$alerta=0;
						$esc=new Escola;
						$return=$esc->getRequestEscola($user->getProfId());

						if($user->getTipo()==0){
							?>
							<li><a href="atualiza.php" onclick="sobe();" target="corpo_principal">Complete seus dados para continuar.</a></li>
						<? 
						$alerta++;
						} elseif(count($return)<1){
							?>
							<li><a href="escola_prof.php" onclick="sobe();" target="corpo_principal">Você ainda não está cadastrado em nenhuma escola.</a></li>
							<?
						$alerta++;
						}
						
						if($alerta<1){
							?>
							<li>Nenhum alerta importante.</li>
							<?
						}
						?>
						</ul>
						</div>
                        <? } ?>
		</div>
	</div> <!-- /login -->	

    <!-- A aba no top -->	
	<div class="tab">
		<ul class="login">
	    	<li class="left">&nbsp;</li>
	        <li>Olá <?php 
			if($_SESSION['nome']!=""){ echo $_SESSION['nome']; }
			elseif($_SESSION['usr']){ echo $_SESSION['usr']; }
			else { echo 'Visitante'; } ?>!</li>
			<li class="sep">|</li>
			<li id="toggle">
				<a id="open" class="open" href="#"><?php echo $_SESSION['id']?'Abrir Painel':'Logar | Cadastrar';?></a>
				<a id="close" style="display: none;" class="close" href="#">Fechar Painel</a>			
			</li>
	    	<li class="right">&nbsp;</li>
		</ul> 
	</div> <!-- / top -->
	
</div> <!--painel -->