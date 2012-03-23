<?php

function p($string)
{
	global $pearless;
	
	// For the most important stuff in Pearless to be accessed easily
	$shortcuts = array(
		'datasource' => 'pearless\datasource\DataSourceFactory'
	);

	if (isset($shortcuts[$string]))
	{
		$path = str_replace("\\","/",$shortcuts[$string]);
		$path = str_replace(" ","",$path);
		$path = str_replace(">","/",$path).".php";
		$path = $pearless."/".$path;
		
		require_once ($path);
		return new $shortcuts[$string]();
	
	}
	
	$class = str_replace(">","\\",$string);
	$class = str_replace(" ","",$class);
	$class = "pearless\\".$class;
	
	$path = str_replace("\\","/",$string);
	$path = str_replace(" ","",$path);
	$path = "pearless/".str_replace(">","/",$path);
	
	$path = $pearless."/".$path.".class.php";
	
	require_once($path);
	return new $class();
}

?>