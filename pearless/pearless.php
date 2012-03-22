<?php

function p($string)
{
	global $pearless;
	$class = str_replace(">","\\",$string);
	$class = str_replace(" ","",$class);
	$class = "pearless\\".$class;
	
	$classpath = str_replace("\\","/",$string);
	$classpath = str_replace(" ","",$classpath);
	$classpath = "pearless/".str_replace(">","/",$classpath);
	
	$path = $pearless."/".$classpath.".class.php";
	
	require_once($path);
	return new $class();
}

?>