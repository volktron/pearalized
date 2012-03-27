<?php

/*	Pearless.php
 *	@author Henrik Volckmer
 */

require_once(PEARLESS_PATH . "/pearless/lib/string.class.php");

function s($string)
{
	return new pearless\lib\PString($string);
} 

function p($string)
{

	// For the most important stuff in Pearless to be accessed easily
	$factories = array(
		'datasource' 	=> 'pearless\datasource\DataSourceFactory'
	);

	$classes = array(
		'grid'			=> 'pearless\elements\Grid'
	);

	if (isset($factories[$string]))
	{
		$path = str_replace("\\","/",$factories[$string]);
		$path = str_replace(" ","",$path);
		$path = str_replace(">","/",$path).".php";
		$path = PEARLESS_PATH . "/".$path;

		require_once ($path);
		return new $factories[$string]();

	}
	if (isset($classes[$string]))
	{
		$path = str_replace("\\","/",$classes[$string]);
		$path = str_replace(" ","",$path);
		$path = str_replace(">","/",$path).".class.php";
		$path = PEARLESS_PATH . "/".$path;

		require_once ($path);
		return new $classes[$string]();
	}

	$class = str_replace(">","\\",$string);
	$class = str_replace(" ","",$class);
	$class = "pearless\\".$class;

	$path = str_replace("\\","/",$string);
	$path = str_replace(" ","",$path);
	$path = "pearless/".str_replace(">","/",$path);

	$path = PEARLESS_PATH . "/".$path.".class.php";

	require_once($path);
	return new $class();
}

?>