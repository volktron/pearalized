<?php

/*	Pearless.php
 *	@author Henrik Volckmer
 */

require_once(PEARALIZED_PATH . "/pearalized/lib/string.class.php");

$p_shelf = [];

function s($string)
{
	return new pearalized\lib\PString($string);
} 

function o($name, $obj = false)
{
	global $p_shelf;
	if ($obj)
		$p_shelf[$name] = $obj;
	
	return $p_shelf[$name];
}

function p($string)
{

	// For the most important stuff in Pearless to be accessed easily
	$factories = array(
		'datasource' 	=> 'pearalized\datasource\DataSourceFactory'
	);

	$classes = array(
		'grid'			=> 'pearalized\elements\Grid'
	);

	if (isset($factories[$string]))
	{
		$path = str_replace("\\","/",$factories[$string]);
		$path = str_replace(" ","",$path);
		$path = str_replace(">","/",$path).".php";
		$path = PEARALIZED_PATH . "/".$path;

		require_once ($path);
		return new $factories[$string]();

	}
	if (isset($classes[$string]))
	{
		$path = str_replace("\\","/",$classes[$string]);
		$path = str_replace(" ","",$path);
		$path = str_replace(">","/",$path).".class.php";
		$path = PEARALIZED_PATH . "/".$path;

		require_once ($path);
		return new $classes[$string]();
	}

	$class = str_replace(">","\\",$string);
	$class = str_replace(" ","",$class);
	$class = "pearalized\\".$class;

	$path = str_replace("\\","/",$string);
	$path = str_replace(" ","",$path);
	$path = "pearalized/".str_replace(">","/",$path);

	$path = PEARALIZED_PATH . "/".$path.".class.php";

	require_once($path);
	return new $class();
}

?>