<?
include "usuarios.class.php";

$user=new Usuario;

if(isset($_GET["user"])){
	$user->setId($_GET["user"]);
	$user->getUser();
}

if($_GET["action"]=="gravar"){

	$user=new Usuario;
	if($_POST["id"]>0){
		$user->setId($_POST["id"]);
	}
	$user->setNome($_POST["nome"]);
	$user->setUsuario($_POST["usuario"]);
	$user->setEmail($_POST["email"]);
	if($_POST["senha"]!=""){
		$user->setSenha($_POST["senha"]);
	}
	$user->setDataCad(date("Y-m-d ii:mm:ss"));
	$user->setLastIp($_SERVER['REMOTE_ADDR']);
	$user->setTipo(1);
	$user->setStatus(1);

	if($user->salvar()){
		echo "Sucesso!";
	}

}

		$uso=new Usuario;
		$uso->setUsuario("bacci");
		$uso->setSenha("vanesa");
		if($uso->checkUser()){
			echo "wins";
		}

?>