<?php
/**
 * minimvc - A very simple MVC implementation for PHP.
 *
 * Copyright (c) 2009 Everaldo Canuto <everaldo.canuto@gmail.com>
 *                    Enrico Spinetta <enricosp@gmail.com>
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

class Dispatcher
{
	public $controller = null;
	public $action     = null;
	public $method     = null;
	public $path       = null;

	private $username   = null;
	private $password   = null;

	private $base_path  = '../application/controllers';

	public function __construct()
	{
		$this->method   = @$_SERVER['REQUEST_METHOD'];
		$this->username = @$_SERVER['PHP_AUTH_USER'];
		$this->password = @$_SERVER['PHP_AUTH_PW'];

		$path = trim( isset($_GET['do']) ? $_GET['do'] : @$_SERVER['PATH_INFO'] , '/' );

		do {
			@list ($controller, $path) = explode('/', $path, 2);
			$this->controller .= '/' . $controller;
		} while (is_dir ($this->base_path.$this->controller) && !empty($controller));

		@list ($this->action, $this->path) = explode('/', $path, 2);

		$this->controller = trim($this->controller, '/');

		if ($this->controller == '')
			$this->controller = 'default';

		if ($this->action == '')
			$this->action = 'default';
	}

	public function dispatch()
	{

		$controller_file = "$this->base_path/$this->controller.php";

		$class = 'Controller';
		if (file_exists($controller_file)) {
			require $controller_file;
			$class = basename($this->controller).'Controller';
		}

		// check authentication
		if ($class::$authtype == 'http') {
			// to-do: implement
		} else {
			if (Authentication::loginRequired()) {
				if ($this->controller == 'logout') {
					Authentication::logout();
					redirect('?');
				}

				if (!Authentication::isLogged() && ($this->controller != 'login'))
					redirect('?do=login');
			}
		}

		$controller = new $class($this);

		$action = 'action_'.$this->method.'_'.$this->action;
		if (!method_exists($controller,$action))
			$action = 'action_'.$this->method;
		if (!method_exists($controller,$action))
			$action = 'action_' . $this->action;

		call_user_func(array($controller, $action));
	}
}

class Controller
{
	static    $authtype = 'form';
	protected $dispatcher;

	public function __construct($dispatcher)
	{
		$this->dispatcher = $dispatcher;
	}

	public function action_default()
	{
		$view = new View($this->dispatcher->controller);
		$view->send();
	}
}

class View
{
	private $view = null;
	private $file = null;

	public $data = null;

	public function __construct($view = null)
	{
		$this->view = $view;
		
		if (!defined('APP_THEME'))
				define('APP_THEME', 'default');

		$places = array(
			'application/views/themes/'.APP_THEME."/$view.php",
			'application/views/themes/'.APP_THEME."/$view.html",
			"application/views/$view.php",
			"application/views/$view.html"
		);
		foreach ($places as $file) {
			if (file_exists($file)) {
				$this->file = $file;
				break;
			}
		}

	}

	public function send()
	{
		if ($this->file == null)
			echo "Invalid view \"$this->view\"!";
		else
			include $this->file;
	}
}

class Authentication
{
	static public function login()
	{
		$_SESSION['auth_logged'] = true;
	}

	static public function logout()
	{
	    $_SESSION = array();
	    session_destroy();
	}

	static public function isLogged()
	{
		$logged = @$_SESSION['auth_logged'];
		return $logged == null ? false : $logged;
	}

	static public function loginRequired()
	{
		if (!defined('AUTHENTICATION_MODE'))
			return false;

		return AUTHENTICATION_MODE != 'none';
	}
}

?>
