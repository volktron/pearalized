<?php

/*	Pearless.php
 *	@author Henrik Volckmer
 */

//require_once(PEARALIZED_PATH . "/pearalized/lib/string.php");

spl_autoload_register(function($class_name)
{
	if(file_exists(PEARALIZED_PATH.'/'.str_replace('\\', '/', $class_name).'.php'))
		require_once PEARALIZED_PATH.'/'.str_replace('\\', '/', $class_name).'.php';
	return 0;
});

$p_shelf = array();

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
		'datasource' 	=> 'pearalized\datasource\DataSourceFactory',
		'cachesource'	=> 'pearalized\cachesource\CacheSourceFactory'
	);

	$classes = array(
		'grid'			=> 'pearalized\elements\Grid'
	);

	if (isset($factories[$string]))
	{
		return new $factories[$string]();
	}
	if (isset($classes[$string]))
	{
		return new $classes[$string]();
	}

	$class = str_replace(">","\\",$string);
	$class = str_replace(" ","",$class);
	$class = "pearalized\\".$class;

	return new $class();
}

?>