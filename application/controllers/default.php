<?php

class DefaultController extends Controller
{
	function action_default()
	{
		// temporary, must be removed and replaced by View class
		//include("usuario.php");
		$view = new View('usuarios');
		$view->send();
	}

	function action_home()
	{
		$view = new View('home');
		$view->send();
	}
}

?>