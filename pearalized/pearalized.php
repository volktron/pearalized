<?php

/**	pearalized.php
 *	@author Henrik Volckmer
 */

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
	if ($obj !== false)
		$p_shelf[$name] = $obj;
	
	return $p_shelf[$name];
}

function p($string, $params = null)
{

	// For the most important stuff in pearalized to be accessed easily
	$factories = array(
		'datasource' 	=> 'pearalized\datasource\DataSourceFactory',
		'cachesource'	=> 'pearalized\cachesource\CacheSourceFactory',
		'controller'	=> 'pearalized\controller\ControllerFactory',
		'router'		=> 'pearalized\routing\RouterFactory'
	);

	$classes = array(
		'grid'			=> 'pearalized\elements\Grid',
		'dropdown'		=> 'pearalized\elements\Dropdown'
	);

	if (isset($factories[$string]))
	{
		return new $factories[$string]();
	}
	if (isset($classes[$string]))
	{
		if($params == null)
			return new $classes[$string]();
		else
			return new $classes[$string]($params);
	}

	$class = str_replace(">","\\",$string);
	$class = str_replace(" ","",$class);
	$class = "pearalized\\".$class;

	return new $class();
}

?>