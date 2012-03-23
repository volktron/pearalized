<?php

namespace pearless\datasource;

class DataSourceFactory
{	
	public function setup($params)
	{
		global $pearless;
		$classpath = "pearless\\datasource\\".$params['type']."\\";
		require_once($pearless."\\pearless\\datasource\\DataSourceInterface.php");
		require_once($pearless."\\pearless\\datasource\\ResultInterface.php");
		require_once($pearless."\\".$classpath."DataSource.php");
		require_once($pearless."\\".$classpath."Result.php");
		
		$classname = $classpath."DataSource";
		return new $classname($params);
	}
}

?>