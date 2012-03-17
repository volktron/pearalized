<?php

namespace pearless\datasource;

class DataSourceFactory
{
	public static function make_datasource($name, $params)
	{
		global $pearless;
		$classpath = "pearless\\datasource\\$name\\";
		require_once($pearless."\\".$classpath."DataSource.php");
		require_once($pearless."\\".$classpath."Result.php");
		
		$classname = $classpath."DataSource";
		return new $classname($params);
	}	
}

?>