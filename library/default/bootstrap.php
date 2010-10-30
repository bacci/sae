<?php
/**
 * Bootstrap - Main application entry point.
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

include_once 'minimvc.php';

// autoload files based on it class name.
function __autoload($class_name)
{
	require_once strtolower($class_name) . '.php';
}

function redirect($url)
{
	header('Location: '.$url);
	exit();
}

function reurl($name, $value)
{
	$vars = $_GET;
	$vars[$name] = $value;
	foreach ($vars as $key => $value) {
		$result .= ($result == null) ? '?' : '&';
		$result .= "$key=$value";
	}
	return $result;
}

function dump($str)
{
	echo "<pre>\n";
	var_dump($str);
	echo "</pre>\n";
}

// set include path.
set_include_path(get_include_path() . 
	PATH_SEPARATOR . '../library/' .
	PATH_SEPARATOR . '../library/default'
);

// load config settings.
$config_file = '../config/' . $_SERVER['HTTP_HOST'];

if (file_exists($config_file))
	include_once $config_file;
else
	include_once '../config/default';

// default application name value.
if (!defined('APP_NAME'))
	define('APP_NAME', 'PHPAPP');	

// start session.
session_name(APP_NAME);
session_start('');

?>
