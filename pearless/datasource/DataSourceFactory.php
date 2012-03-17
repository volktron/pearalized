<?php

namespace pearless\datasource;

class DataSourceFactory
{
	public static function make_datasource($name, $params)
	{
		global $pearless;
		$classname = "pearless\\datasource\\$name\\DataSource";
		require_once($pearless."\\".$classname.".php");
		
		return new $classname($params);
	}	
}

?>